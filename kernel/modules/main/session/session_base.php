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

class SessionBase {

	// Старт сессии.
	// false - если не удалось стартовать механизм сессий.
	public function start( $session_id = '' ){

		// session.hash_function

		ini_set('session.name', app::$config['session_name'] );

		// Переопределить обработчик сессий.
		session_set_save_handler(
			[ $this, 'sess_open' ],
			[ $this, 'sess_close' ],
			[ $this, 'sess_read' ],
			[ $this, 'sess_write' ],
			[ $this, 'sess_destroy' ],
			[ $this, 'sess_gc' ]
		);

		session_start();

	}


	/**
	 * Первый вызываемый метод.
	 *
	 * На этом этапе должна происходить генерация session_id.
	 * Вызов внутри метод sess_open функции session_id() будет возвращать пустую строку.
	 * Если в этом методе не установить свой session_id( ВАШ SESSION_ID ), то тогда PHP сам сгенерирует session_id(), но
	 * уже за пределами этого метода, что может быть поздно для sess_write и других сессионых методов.
	 *
	 * @param $save_path
	 * @param $session_name
	 * @return bool
	 */
	public function sess_open( $save_path, $session_name ){

		return true;

	}

	/**
	 * Закрытие сессии.
	 */
	public function sess_close(){


		return true;

	}


	/**
	 * Чтение переменных сессии.
	 * Метод должен возвращать сериализованную строку с переменными сессии или пустую строку, если данных нет.
	 * @return string
	 */
	public function sess_read( $sid ){

		$serialized_data = '';

		return $serialized_data;

	}






	/**
	 * Запись в переменные сессии.
	 *
	 * Вызывается также после отработки скрипта, когда уже уничтожены все соединения с сокетами и т.п.
	 * Поэтому нужно быть внимательным при разработки наследников.
	 *
	 * ! Интересная особенность. Все запросы который выполняются внутри метода,
	 * не записываются в $db->queries. Потому что PHP блокирует любые присвоения глобальным переменным.
	 * Поэтому выполненные здесь запросы не видны в консоли отладки фреймворка.
	 * Вывод возможен через app::cons().
	 */
	public function sess_write( $sid, $val ) {

		return true;

	}




	/**
	 * Уничтожение сессии.
	 */
	public function sess_destroy( $sid ){


	}




	/**
	 * Функция удаляет из базы просроченные сессии.
	 */
	public function sess_gc( $maxlifetime = null ){

		return true;

	}



	public function generate_sid(){

		$hash = randstr( 100 ) . time() . $_SERVER['REMOTE_ADDR'] . app::$name;
		$hash = md5( $hash );

		return $hash;

	}

	/**
	 * Метод возвращает код пользователя,
	 * если указанная сессия авторизованна.
	 * @return int $uid Код пользователя.
	 */
	public function get_uid( $session_id = '', $app_name = null ){

		$uid = 0;

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


		$session = null;

		return $session;

	}


	/**
	 * Метод проверяет, авторизованна ли указанная сессия.
	 *
	 * @param str $session_id Сессия.
	 * @return bool
	 */
	public function is_authorized( $session_id = null, $app_name = null ){

		if( $session_id == null ) {

			$session_id = session_id();

		}

		if( $app_name == null ){

			$app_name = app::$name;

		}

		$uid = $this->get_uid( $session_id, $app_name );

		return ( $uid > 0 ? true : false );

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

		return false;


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



		return false;

	}




}

?>