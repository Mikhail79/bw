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

/**
 * Механизм сессий, который позволяет отслеживать авторизацию пользователя.
 * Помимо этого механизма, есть ещё механизм сеанс работы (sessions_extra).
 * TODO Разделить sessions и sessions_extra. Добавить app.
 */
class session {

	static public $engine_type = '';

	static protected $initialized = false;

	/**
	 * @var null | session_file | session_redis | session_database
	 */
	static protected $engine = null;


	static public function init( $engine_type = 'database' ){


		if( $engine_type == 'redis' ){

			require_once('session_redis.php');

			self::$engine = new SessionRedis();

		}
		else if( $engine_type == 'database' ){

			require_once('session_database.php');

			self::$engine = new SessionDatabase();

		}
		else {

			require_once('session_file.php');

			self::$engine = new SessionFile();

		}

		self::$engine_type = $engine_type;

		self::$initialized = true;

	}


	// Старт сессии.
	// false - если не удалось стартовать механизм сессий.
	static public function start( $session_id = '' ){

		self::$engine->start( $session_id );

	}

	
	/**
	 * Метод проверяет, авторизованна ли указанная сессия.
	 * 
	 * @param str $session_id Сессия.
	 * @return bool
	 */
	static public function is_authorized( $session_id = null, $app_name = null ){

		return self::$engine->is_authorized( $session_id, $app_name );

	}


	static public function login(){

	}

	static public function logout(){

	}

	static public function sign_in(){

	}

	static public function sign_out(){

	}

	
	/**
	 * Метод авторизует указанную сессию.
	 * Внимание! Метод не делает проверок пароля и т.п. Метод 
	 * Метод только авторизует сессию.
	 * 
	 * @param int $uid
	 * @param str $session_id
	 * @return bool
	 */
	static public function authorize( $uid, $session_id = null ){

		return self::$engine->authorize( $uid, $session_id );

	}
	
	
	/**
	 * Метод деавторизует указанную сессию.
	 */
	static public function deauthorize( $session_id = null ){

		return self::$engine->deauthorize( $session_id );

	}
	
	
	
	/**
	 * Метод возвращает код пользователя, 
	 * если указанная сессия авторизованна.
	 * @return int $uid Код пользователя.
	 */
	static public function get_uid( $session_id = null, $app_name = null ){

		return self::$engine->get_uid( $session_id, $app_name );
	
	}

	/**
	 * Метод возвращает данные сессии.
	 *
	 *
	 * @param string $sid
	 * @return array|null
	 */
	static public function get_session( $sid = null, $app_name = null ){

		return self::$engine->get_session( $sid, $app_name );

	}


	static public function get_session_id(){

		return session_id();

	}


}

?>