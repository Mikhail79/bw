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
 * Class RedisWrapper
 *
 * Пришлось сделать обёртку для расширения phpredis, так как при отсутствии ключа (отсутствие данных),
 * phpredis возвращает пустой массив, а во фреймворке принят сдандарт возвращать null.
 *
 * Требует PHP-расширение https://github.com/nicolasff/phpredis.
 *
 * @link http://redis.io/commands
 * @link https://github.com/nicolasff/phpredis
 * @link https://github.com/nrk/predis
 */
class RedisWrapper {

	protected $redis = null;

	public function __construct(){

		if( extension_loaded('redis') == true && app::$config['redis_engine'] == 'phpredis' ){

			$this->redis = new Redis();

		}
		else if( app::$config['redis_engine'] == 'predis' ){


		}
		else { // native framework

			// require( __DIR__ . '/Redis.php' );

		}


	}

	function __call( $name, $args = [] ){

		$name = strtolower( $name );

		$for_check_keys = [
			'hgetall',
		];

		if( in_array( $name, $for_check_keys ) == true ){

			$key = (string) $args[0];

			if( $this->redis->exists( $key ) == false ){
			//	app::cons($name . ' : ' . $key);

				return null;

			}

		}

		$result = call_user_func_array( [ $this->redis, $name ], $args );

	//	array_unshift( $args, strtoupper( $name ) );

		return $result;

	}





	/*
	public function hset_array( $key, $data = [] ){

		$key = (string) $key;

		if( is_array( $data ) == true ){

			$this->redis->mset( $key, $data );


			foreach( $data as $name => $value ){

				$value = (string) $value;


				// 1 if field is a new field in the hash and value was set.
				// 0 if field already exists in the hash and the value was updated.
				// $result = $this->hset( $key, $name, $value );
				// TODO Можно использовать MSET.
			//	app::cons($name);
				$this->redis->hset( $key, $name, $value );

				// var_dump($result);

			}


		}

	}
	*/

}

?>