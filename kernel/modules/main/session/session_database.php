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

class SessionDatabase extends SessionBase {


	public function sess_read( $sid ){
		//error_log('SESS_READ');
		// TODO Добавить поля sid, app, remove_ts в sessions_variables.

		$sql = 'SELECT variables FROM ?_sessions';
		$sql.= ' WHERE';
		$sql.= ' sid = ?';
		$sql.= ' AND app = ?';
		$sql.= ' AND remove_ts = 0';

		$session = app::$db->selrow(
			$sql,
			$sid,
			app::$config['name']
		);


		return ( $session != null ? $session['variables'] : '' );

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
				
				$sid = $this->generate_sid();
				
			}
			
			$sid = session_id( $sid );
			
		}
		else {
			
			$sid = session_id();
			
		}
		
		//
		// BEGIN Проверка уникальности.
		//


		$sql = 'SELECT * FROM ?_sessions WHERE sid = ? AND app = ? AND ( ip != INET6_ATON(?) OR remove_ts > 0 )';

		$session = app::$db->selrow(
			$sql,
			$sid,
			app::$config['name'],
			$_SERVER['REMOTE_ADDR']
		);
		
		if( $session != null ){
			
			$ts = time();
			
			
			/*
			$hash = randstr( 100 ) . $ts . $_SERVER['REMOTE_ADDR'];
			$hash = md5( $hash );
			*/
			
			$sid = $this->session_id( $this->generate_sid() );
			
			$expiry = $ts + app::$config['session']['lifetime'];
			
			setcookie( app::$config['session_name'], $sid, $expiry, '/' );
			
		}
		
		//
		// END Проверка уникальности.
		//
		
		return $sid;
		
	}
	
	

	public function sess_open( $save_path, $session_name ){

		$sid = get_cookie_str( $session_name );

		if( is_key( $sid, 32 ) == false ){

			$sid = $this->generate_sid();

		}

		session_id( $sid );

		// убрать просроченные сессии.
		//$this->sess_gc(0);


		$sql = 'SELECT * FROM ?_sessions WHERE sid = ? AND app = ? AND remove_ts = 0';

		$row = app::$db->selrow( $sql, $sid, app::$config['name'] );

		$insert_extra = false;



		$ts = time();

		if( $row == null ){

			$ip = $_SERVER['REMOTE_ADDR'];
			
			$expiry = $ts + app::$config['session']['lifetime'];

			$sql = 'INSERT INTO ?_sessions SET';
			$sql.= ' sid = ?,';
			$sql.= ' expiry = ?d,';
			$sql.= ' ip = INET6_ATON(?),';
			$sql.= ' last_request = ?d,';
			$sql.= ' start = ?d,';
			$sql.= ' app = ?';

			$row = array(
				'id' => 0,
				'uid' => 0
			);

			$row['id'] = app::$db->ins(
				$sql,
				$sid,
				$expiry,
				$ip,
				$ts,
				$ts,
				app::$config['name']
			);

			$insert_extra = true;


		}
		else{

			// Проверка на изменения IP-адреса.
			// Защита от воровства сессии.
			// Произошла подмена IP.
			if( $row['ip'] != inet_pton( $_SERVER['REMOTE_ADDR'] ) ){

				// Данная вызов пораждает
				// Warning: session_destroy(): Trying to destroy uninitialized session in /var/www/bw/kernel/modules/main/session/SessionDatabase.php on line 167
				// Что логично, потому что текущий контекст внутри session_start().
				//session_destroy();

				$this->sess_destroy( $sid );

			}
			else{

				// корректируем LastRequest

				$expiry = $ts + app::$config['session']['lifetime'];

				$sql = 'UPDATE ?_sessions USE INDEX(main) SET last_request = ?d, expiry = ?d WHERE sid = ? AND app = ? AND remove_ts = 0';

				app::$db->q(
					$sql,
					$ts,
					$expiry,
					$sid,
					app::$config['name']
				);

				//
				// BEGIN Проверить сеанс работы.
				//

				if( app::$config['use_extra_sessions'] == true ){

					$sql = 'SELECT * FROM ?_sessions_extra WHERE session_id = ?d AND end_ts = 0 AND ip = INET6_ATON(?) AND uid = ?d';

					$session_extra = app::$db->selrow(
						$sql,
						$row['id'],
						$_SERVER['REMOTE_ADDR'],
						$row['uid']
					);

					if( $session_extra != null ){

						$diff_ts = $ts - $session_extra['last_request_ts'];

						if( $diff_ts > app::$config['online_interval'] ){

							//
							// BEGIN Закрыть сеанс работы.
							//

							$sql = 'UPDATE ?_sessions_extra SET';
							$sql.= ' end_ts = ?d';
							$sql.= ' WHERE';
							$sql.= ' id = ?d';

							app::$db->q(
								$sql,
								$ts,
								$session_extra['id']
							);

							//
							// END Закрыть сеанс работы.
							//

							$insert_extra = true;

						}
						else {

							//
							// BEGIN Отметить время последнего запроса.
							//

							$sql = 'UPDATE ?_sessions_extra SET';
							$sql.= ' last_request_ts = ?d';
							$sql.= ' WHERE';
							$sql.= ' id = ?d';

							app::$db->q(
								$sql,
								$ts,
								$session_extra['id']
							);

							//
							// END Отметить время последнего запроса.
							//

						}


					}
					else {

						$insert_extra = true;

					}

				}

				//
				// END Проверить сеанс работы.
				//


				// TODO Опция: следует ли обновлять время жизни куки. "Чужой компьютер"
				// Выдать браузеру, чтобы он тоже обновил у себя expiry.
				setcookie( $session_name, $sid, $expiry, '/' );

			}

		}


		//
		// BEGIN Открыть сеанс работы.
		//
		if( app::$config['use_extra_sessions'] == true ){

			if( $insert_extra == true ){

				$sql = 'INSERT INTO ?_sessions_extra SET';
				$sql.= ' session_id = ?d,';
				$sql.= ' begin_ts = ?d,';
				$sql.= ' last_request_ts = ?d,';
				$sql.= ' ip = INET6_ATON(?),';
				$sql.= ' uid = ?d';

				app::$db->ins(
					$sql,
					$row['id'],
					$ts,
					$ts,
					$_SERVER['REMOTE_ADDR'],
					$row['uid']
				);

			}

		}

		//
		// END Открыть сеанс работы.
		//

		return true;

	}


	/**
	 * Вызывается при записи и при закрытии сессии (не контролируемый вызов, следует уже после register_shutdown_function).
	 *
	 * Примечание: если создать ключ состоящий из цифр, например: $_SESSION['123'] = 'ok', то в переменную $val не
	 * попадёт ключ 123 со своим значением. Это связанно с тем, что топовые ключи $_SESSION могут быть экспортированы как переменные в глобальное
	 * пространство PHP, а переменная в PHP не может быть такой $123.
	 *
	 * @param $sid
	 * @param $val
	 * @return bool|mysqli_result|resource
	 */
	public function sess_write( $sid, $val ) {

		$sql = 'SELECT * FROM ?_sessions WHERE sid = ? AND app = ? AND remove_ts = 0';

		$session = app::$db->selrow( $sql, $sid, app::$config['name'] );

		if( $session != null ){

			try {

				$sql = 'UPDATE ?_sessions SET variables = ? WHERE id = ?d';

				$result = app::$db->q( $sql, $val, $session['id'] );

				$result = (boolean) $result;

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


	/**
	 * Уничтожение сессии.
	 */
	public function sess_destroy( $sid ){

		try {

			//$sql = 'UPDATE ?_sessions SET remove_ts = ?d WHERE sid = ? AND app = ?';
			//app::$db->q( $sql, time(), $sid, app::$config['name'] );

			$sql = 'DELETE FROM ?_sessions WHERE sid = ? AND app = ?';
			app::$db->q( $sql, $sid, app::$config['name'] );

		}
		catch( exception $e ){
		}

		return true;

	}





	/**
	 * Функция удаляет из базы просроченные сессии.
	 *
	 * TODO CLI скрипт для чистки таблицы сессий.
	 */
	public function sess_gc( $maxlifetime = null ){

	//	error_log('SESS_GC');

		$ts = time();

		try {

			// $sql = 'UPDATE ?_sessions SET remove_ts = ?d WHERE expiry <= ?d';
			//app::$db->q( $sql, $ts, $ts );

			$sql = 'DELETE FROM ?_sessions WHERE expiry <= ?d AND app = ?';
			app::$db->q( $sql, $ts, app::$name );

		}
		catch( exception $e ) {
		}


		//
		// BEGIN Закрыть не активные сеансы работы.
		//

		// TODO Временно здесь.

		/*
		$sql = 'UPDATE ?_sessions_extra SET end_ts = ?d, last_request_ts = ?d WHERE ( ?d - last_request_ts ) > ?d AND end_ts = 0';
		app::$db->q( $sql, $ts, $ts, $ts, app::$config['online_interval'] );
		*/

		//$sql = 'UPDATE ?_sessions_extra SET end_ts = last_request_ts WHERE ?d >= last_request_ts AND ( ?d - last_request_ts ) > ?d AND end_ts = 0';

		if( app::$config['use_extra_sessions'] == true ){

			$sql = 'UPDATE ?_sessions_extra SET end_ts = ?d WHERE ?d >= last_request_ts AND ( ?d - last_request_ts ) > ?d AND end_ts = 0';
			app::$db->q( $sql, $ts, $ts, $ts, app::$config['online_interval'] );

		}

		//
		// END Закрыть не активные сеансы работы.
		//

		return true;

	}


	public function get_uid( $session_id = '', $app_name = null ){

		if( $app_name == null ){
			$app_name = app::$name;
		}

		if( $session_id == '' ) {
			$session_id = session_id();
		}

		$uid = 0;

		$sql = 'SELECT * FROM ?_sessions WHERE sid = ? AND app = ?';
		$row = app::$db->selrow( $sql, $session_id, $app_name );

		if( $row != null ){

			$uid = $row['uid'];

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

		$sql = 'SELECT * FROM ?_sessions WHERE sid = ? AND app = ? AND remove_ts = 0';
		$session = app::$db->selrow( $sql, $sid, $app_name );

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



		$sql = 'SELECT * FROM ?_users WHERE id = ?d AND application = ? AND active = 1 AND remove_ts = 0';
		$user = app::$db->selrow( $sql, $uid, $app_name );


		if( $user == null ) {

			return false;

		}


		try {

			app::$db->start();

			$sql = 'UPDATE ?_sessions SET uid = ?d WHERE id = ?d';
			app::$db->q( $sql, $user['id'], $session['id'] );

			$sql = 'UPDATE ?_users SET last_auth_ts = ?d, last_ip = UNHEX(?) WHERE id = ?d';
			app::$db->q( $sql, time(), bin2hex( $session['ip'] ), $user['id'] );


			app::$db->commit();

			return true;

		}
		catch( Exception $e ){

			app::$db->rollback();

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

		$session = $this->get_session( $session_id, $app_name );

		if( $session === null ) {

			return false;

		}

		$sql = 'UPDATE ?_sessions SET uid = 0 WHERE id = ?d';
		app::$db->q( $sql, $session['id'] );

		return true;

	}


}


?>