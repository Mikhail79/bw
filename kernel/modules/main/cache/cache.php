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
 * Система кэширования.
 */
class cache {

	static protected $debug_data = [
		// Массив содержит ключи и счётчик обращений на запись.
		'recorded_keys' => [],
		// Массив содержит ключи и счётчик обращений на чтение.
		'read_keys' => []
	];

	static protected $initialized = false;

	/**
	 * @var null | cache_file | cache_redis
	 */
	static protected $engine = null;


	/**
	 * Метод перечитывает self::$cache.
	 */
	static public function init( $engine_type = 'file' ){



		if( $engine_type == 'redis' ){

			require_once('cache_redis.php');

			self::$engine = new CacheRedis();

		}
		else {

			require_once('cache_file.php');

			self::$engine = new CacheFile();

		}

		self::$initialized = true;

	}


	/**
	 * Метод сохраняет кэш на диск.
	 * Для текущего приложения.
	 */
	static public function update(){

	}


	static public function put( $cache_id, $data, $expiry = 3600 ){

		return self::set( $cache_id, $data, $expiry );

	}


	/**
	 *
	 * @param int $expiry время, на которое нужно
	 * кэшировать относительно текущего timestamp.
	 * @param bool $now обновить сразу же cache_db.php, а не в конце cp.php.
	 */
	static public function set( $cache_id, $data, $expiry = 3600 ){

		if( app::$config['debug'] == true ){

			if( array_key_exists( $cache_id, self::$debug_data['recorded_keys'] ) == false ){

				self::$debug_data['recorded_keys'][ $cache_id ] = 0;

			}

			self::$debug_data['recorded_keys'][ $cache_id ]++;

		}

		return self::$engine->set( $cache_id, $data, $expiry );

	}


	static public function exists( $cache_id ){

		return self::$engine->exists( $cache_id );

	}


	/**
	 *
	 * @return false - вышел срок или нет такого ключа.
	 */
	static public function get( $cache_id ){

		if( app::$config['debug'] == true ){

			if( array_key_exists( $cache_id, self::$debug_data['read_keys'] ) == false ){

				self::$debug_data['read_keys'][ $cache_id ] = 0;

			}

			self::$debug_data['read_keys'][ $cache_id ]++;

		}

		return self::$engine->get( $cache_id );

	}


	/**
	 * Обновить закэшированный $cache_id.
	 */
	static public function refresh($cache_id){

		return self::$engine->refresh($cache_id);

	}


	/**
	 * Сброс кэша.
	 *
	 * TODO Возможность указывать конкретные приложения [site,cp].
	 *
	 * @param boolean $full
	 * 		true Сброс кэша всех приложений.
	 * 		false Сброс кэша текущего приложения.
	 */
	static public function flush( $full = false ){

		return self::$engine->flush($full);

	}

	static public function get_debug_info(){

		return self::$debug_data;

	}

}

?>