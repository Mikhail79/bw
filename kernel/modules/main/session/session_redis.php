<?
/**
 * BlueWhale PHP Framework
 *
 * @version 0.1.2 alpha (31.12.2017)
 * @author Mikhail Shershnyov <useful-soft@yandex.ru>
 * @copyright Copyright (C) 2006-2017 Mikhail Shershnyov. All rights reserved.
 * @link https://bwframework.ru
 * @license The MIT License https://bwframework.ru/license/
 */

require_once('session_base.php');

class SessionRedis extends SessionBase {

	public function __construct(){

		// TODO Возможность выбирать объект подключения и его размещение в классе cache или app.
		if( app::$redis == null ){

			app::init_redis();

		}

	}

	public function sess_open( $save_path, $session_name ) {

		$sid = get_cookie_str( $session_name );

		if ( is_key( $sid, 32 ) == false ) {

			$sid = $this->generate_sid();

		}

		session_id( $sid );

		// to be continued

		$redis_key = $this->get_real_key( app::$config['name'], $sid );

		if( $redis_key == null ){

			return false;

		}

//		$redis_key = 'session|' . app::$config['name'] . '|' . $sid;

//		error_log($redis_key);

		$ts = time();

		$ip = bin2hex( inet_aton( $_SERVER['REMOTE_ADDR'] ) );

		if( app::$redis->exists( $redis_key ) == false ){

			$expiry = $ts + app::$config['session']['lifetime'];

			$ins_data = [];
			$ins_data['sid'] = $sid;
			$ins_data['expiry'] = $expiry;
			$ins_data['ip'] = $ip;
			$ins_data['last_request'] = $ts;
			$ins_data['start'] = $ts;
			$ins_data['app'] = app::$config['name'];
			$ins_data['variables'] = '';
			$ins_data['uid'] = 0;

			foreach( $ins_data as $key => $value ){

				app::$redis->hset( $redis_key, $key, $value );

			}

		}
		else {

			$row = app::$redis->hgetall( $redis_key );

			// Проверка на изменения IP-адреса.
			// Защита от воровства сессии.
			// Произошла подмена IP.
			if( $row['ip'] != $ip ){

				// Данная вызов пораждает
				// Warning: session_destroy(): Trying to destroy uninitialized session in /var/www/bw/kernel/modules/main/session/SessionDatabase.php on line 167
				// Что логично, потому что текущий контекст внутри session_start().
				//session_destroy();

				$this->sess_destroy( $sid );

			}
			else {

				// корректируем LastRequest

				$expiry = $ts + app::$config['session']['lifetime'];

				$upd_data = [];
				$upd_data['last_request'] = $ts;
				$upd_data['expiry'] = $expiry;

				foreach( $upd_data as $key => $value ){

					app::$redis->hset( $redis_key, $key, $value );

				}

				// TODO Опция: следует ли обновлять время жизни куки. "Чужой компьютер"
				// Выдать браузеру, чтобы он тоже обновил у себя expiry.
				setcookie( $session_name, $sid, $expiry, '/' );

			}

		}



		return true;

	}



	/**
	 * Уничтожение сессии.
	 */
	public function sess_destroy( $session_id ){

		$app_name = app::$config['name'];


		$redis_key = $this->get_real_key( $app_name, $session_id );
//		$redis_key = 'session|' . $app_name . '|' . $session_id;


		app::$redis->del( $redis_key );



		return true;

	}




	/**
	 *
	 *
	 * ! Интересная особенность. Все запросы который выполняются внутри метода,
	 * не записываются в $db->queries. Потому что PHP блокирует любые присвоения глобальным переменным.
	 * Поэтому выполненные здесь запросы не видны в консоли отладки фреймворка.
	 * Вывод возможен через app::cons().
	 */


	/**
	 * Запись в переменные сессии.
	 *
	 * Вызывается при записи и при закрытии сессии (не контролируемый вызов, следует уже после register_shutdown_function).
	 *
	 * @param $sid
	 * @param $val Сериализованная строка, но не через serialize(). Для сессий свой сериализатор.
	 * @return bool|mysqli_result|resource
	 */
	public function sess_write( $sid, $val ) {

		$redis_key = $this->get_real_key( app::$config['name'], $sid );
//		$redis_key = 'session|' . app::$config['name'] . '|' . $sid;

		$session = app::$redis->hgetall( $redis_key );

		// Fix.
//		if( empty( $session ) == true ){

//			$session = null;

//		}


		if( $session != null ){

			try {

				app::$redis->hset( $redis_key, 'variables', $val );

				$result = true;

			}
			catch( exception $e ){

				$result = false;

			}

		}
		else {

			$result = false;

		}

		return $result;

	}

	public function sess_read( $sid ){

		$redis_key = $this->get_real_key( app::$config['name'], $sid );
//		$redis_key = 'session|' . app::$config['name'] . '|' . $sid;

		$session = app::$redis->hgetall( $redis_key );

		// Fix.
//		if( empty( $session ) == true ){

//			$session = null;
//
//		}

		return ( $session != null ? $session['variables'] : '' );

	}



	public function get_uid( $session_id = '', $app_name = null ){

		if( $app_name == null ){
			$app_name = app::$config['name'];
		}

		if( $session_id == '' ) {
			$session_id = session_id();
		}

		$uid = 0;

		$session = $this->get_session();


		if( $session != null ){

			$uid = $session['uid'];

		}


		return $uid;

	}


	/**
	 * Метод возвращает данные сессии.
	 *
	 *
	 * @param string $sid
	 * @return array|null
	 */
	public function get_session( $sid = null, $app_name = null ){

		if( $sid == null ) {

			$sid = session_id();

		}

		if( $app_name == null ){

			$app_name = app::$config['name'];

		}

		$redis_key = $this->get_real_key( $app_name, $sid );
	//	$redis_key = 'session|' . $app_name . '|' . $sid;

		$session = app::$redis->hgetall( $redis_key );

		// Fix.
//		if( empty( $session ) == true ){

//			$session = null;

//		}

		return $session;

	}


	/**
	 * Метод авторизует указанную сессию.
	 * Внимание! Метод не делает проверок пароля и т.п. Метод
	 * Метод только авторизует сессию.
	 *
	 * Пользователь должен быть активирован и закреплён за указанным приложением.
	 *
	 * @param int $uid
	 * @param str $session_id
	 * @return bool
	 */
	public function authorize( $uid, $session_id = null, $app_name = null ){

		if( $session_id == null ) {

			$session_id = session_id();

		}

		if( $app_name == null ){

			$app_name = app::$config['name'];

		}

		$session = $this->get_session( $session_id, $app_name );

		if( $session === null ) {

			return false;

		}

		$redis_key = $this->get_real_key( $app_name, $session_id );
		//$redis_key = 'session|' . $app_name . '|' . $session_id;

		$sql = 'SELECT * FROM ?_users WHERE id = ?d AND application = ? AND active = 1 AND remove_ts = 0';
		$user = app::$db->selrow( $sql, $uid, $app_name );



		if( $user == null ) {

			return false;

		}

		try {


			$new_redis_key = 'session|' . $app_name . '|' . $session_id . '|' . $user['id'];

			app::$redis->rename( $redis_key, $new_redis_key );

			app::$redis->hset( $new_redis_key, 'uid', $user['id'] );

			$sql = 'UPDATE ?_users SET last_auth_ts = ?d, last_ip = UNHEX(?) WHERE id = ?d';
			app::$db->q( $sql, time(), $session['ip'], $user['id'] );

			return true;

		}
		catch( Exception $e ){

			return false;

		}



	}


	/**
	 * Метод деавторизует указанную сессию.
	 */
	public function deauthorize( $session_id = null, $app_name = null ){

		if( $session_id == null ) {

			$session_id = session_id();

		}

		if( $app_name == null ){

			$app_name = app::$config['name'];

		}

		$redis_key = $this->get_real_key( $app_name, $session_id );
//		$redis_key = 'session|' . $app_name . '|' . $session_id;

		$session = $this->get_session( $session_id, $app_name );

		if( $session === null ) {

			return false;

		}

		$new_redis_key = 'session|' . $app_name . '|' . $session_id . '|0';

		app::$redis->rename( $redis_key, $new_redis_key );

		app::$redis->hset( $new_redis_key, 'uid', 0 );

		return true;

	}





	/**
	 * Метод для замены стандартной функции session_id().
	 * Для генерации более сложного идентификатора.
	 *
	 * $sid a-z, A-Z, 0-9.
	 *
	 * @deprecated
	 *
	 */
	public function session_id( $sid = null ){

		if( $sid != null ){

			if( is_key( $sid, 32 ) == false ){

				$sid = self::generate_sid();

			}

			$sid = session_id( $sid );

		}
		else {

			$sid = session_id();

		}

		//
		// BEGIN Проверка уникальности.
		//


		$redis_key = $this->get_real_key( app::$config['name'], $sid );
		//$redis_key = 'sessions|' . app::$config['name'] . '|' .$sid;

		//$session = self::$redis->prepare_array( self::$redis->hgetall( $redis_key ) );
		$session = self::$redis->hgetall( $redis_key );

		$ip = inet_aton( $_SERVER['REMOTE_ADDR'] );

		//if( $session != null ){
		if( empty( $session ) == false ){

			$ip = bin2hex( inet_aton( $_SERVER['REMOTE_ADDR'] ) );

			if( $session['ip'] != $ip ){

				// Рекурсивный (!) подбор уникального session id.
				// Либо будет сгенерирован уникальный session id, либо script timeout.
				$sid = self::session_id( self::generate_sid() );

			}

			//	$expiry = $ts + app::$config['session']['lifetime'];

			//	setcookie( app::$config['session_name'], $sid, $expiry, '/' );

		}

		//
		// END Проверка уникальности.
		//

		return $sid;

	}


	protected function get_real_key( $app_name, $sid ){

		$key_pattern = 'session|' . $app_name . '|' . $sid . '|*';

		$keys = app::$redis->keys( $key_pattern );

		$key = null;

		if( count( $keys ) > 0 ){

			$key = $keys[0];

		}
		else {

			$key = 'session|' . $app_name . '|' . $sid . '|0';

		}

	//	error_log('$key ' . $key);

		return $key;

	}


}


?>