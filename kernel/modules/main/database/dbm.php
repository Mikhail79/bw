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
 * Class dbm
 * Database Manager
 *
 *
 */
class dbm {


	// Самый надёжный уровень изоляции.
	const SERIALIZABLE = 1;
	const REPEATABLE_READ = 2;
	const READ_COMMITTED = 3;
	const READ_UNCOMMITTED = 4;

	/**
	 * @var DBO[]
	 */
	static protected $objects = [];



	static public function exists( $index ){

		if( array_key_exists( $index, self::$objects ) == true ){

			if( is_object( self::$objects[ $index ] ) == true ) {

				return true;

			}

		}

		return false;

	}


	/**
	 * @param int $index
	 * @return dbo
	 * @throws Exception
	 */
	static public function get( $index = 0 ){

		//		$index = intval( $index );


		if( array_key_exists( $index, self::$objects ) == false || is_object( self::$objects[ $index ] ) == false ){
			throw new Exception('The database object with index "' . $index . '" is not found.');
		}

		return self::$objects[ $index ];

	}

	static public function server( $index = 0 ){

		return self::get( $index );

	}

	static public function db( $index = 0 ){

		return self::get( $index );

	}

	static public function remove( $index = 0 ){

		$index = (string) $index;

		if( array_key_exists( $index, self::$objects ) == false || is_object( self::$objects[ $index ] ) == false ){
			throw new Exception('The database object with index "' . $index . '" is not found.');
		}

		if( self::$objects[ $index ]->is_connected() == true ){
			self::$objects[ $index ]->close();
		}

		unset( self::$objects[ $index ] );

	}



	/*
	 * @param array $params
	 *
	 * index - Алфавитно-цифровой индекс объекта.
	 * host
	 * port
	 * db
	 * user
	 * password
	 * tp
	 */
	static public function add( $params = [] ){

		$default_params = [
			'index' => 0,
			'host' => 'localhost',
			'port' => 3306,
			'db' => '',
			'user' => '',
			'password' => '',
			'tp' => ''
		];

		$params = set_params( $default_params, $params );

		$params['index'] = (string) $params['index'];

		if( array_key_exists( $params['index'], self::$objects ) == true ){
			throw new Exception('This index "' . $params['index'] . '" has been used. Specify a different index.');
		}

		$dbo = new dbo();

		$dbo->tp = $params['tp'];

		$connection = $dbo->connect(
			$params['host'],
			$params['port'],
			$params['db'],
			$params['user'],
			$params['password']
		);

		self::$objects[ $params['index'] ] = $dbo;

		return $connection;

	}


	/**
	 * Метод возвращает индекс нового добавленного объекта.
	 *
	 * @param dbo $db
	 * @param null $index
	 * @return mixed|null
	 */
	static public function add_dbo( dbo $db, $index = null ){

		if( $index != null ){

			self::$objects[ $index ] = $db;

		}
		else {

			self::$objects[] = $db;

			end( self::$objects );
			$index = key( self::$objects );

		}

		return $index;

	}

}



?>