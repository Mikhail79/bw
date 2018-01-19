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

require_once('cache_base.php');

class CacheRedis extends CacheBase {

	protected $redis = null;

	protected $app_name = null;

	public function __construct( $app_name = null ){

		if( $app_name != null ){

			$this->app_name = $app_name;


			//$config = app::get_config($app_name);
			$config = app::get_config('kernel');

			$module = app::get_module('main','kernel');

			// На основе app::init_redis()
			require_once( $module->dir . '/redis/redis_wrapper.php');

			$this->redis = new RedisWrapper();



			if( $config['redis']['persistent'] == true ){

				$this->redis->pconnect( $config['redis']['host'] );

			}
			else {

				$this->redis->connect( $config['redis']['host'] );

			}


			// TODO Базы redis и RedisManager
			$result = $this->redis->select( $config['redis']['db'] );

			if( $result == false ){

				throw new Exception('Redis database not selected.');

			}

		}
		else {

			$this->app_name = app::$config['name'];

			// TODO Возможность выбирать объект подключения и его размещение в классе cache или app.
			if( $this->redis == null ){

				app::init_redis();

			}

			$this->redis = app::$redis;

		}



		/*

		// TODO Проверка функций.


			$this->redis = new Redis();

			$result = self::$redis->pconnect('127.0.0.1', 6379);

			if( $result == true ){
				self::$initialized = true;
			}

		*/


	}


	protected function check_key( $cache_id ){

		$cache_id = (string) $cache_id;

		if( $cache_id == '' ){
			throw new Exception('Invalid cache id.');
		}
		
		$cache_id = 'cache|' . $this->app_name . '|' . $cache_id;

		return $cache_id;
		
	}

	public function set( $cache_id, $data = null, $expiry = 3600 ){

		$cache_id = $this->check_key( $cache_id );

		///echo $cache_id . '<br>';

		$data = serialize( $data );

		//echo $data;


		$result = $this->redis->hset( $cache_id, 'data', $data );

		//echo var_export($result)  . '<br>';

		if( $expiry > 0 ){
			$expiry = time() + $expiry;
		}

		$this->redis->hset( $cache_id, 'expiry', $expiry );

	//	echo $this->redis->exists( $cache_id );
		//echo $cache_id.'<br>';
		//print_r($this->redis->keys('cache*'));

		//var_export($this->get($cache_id));


		if( $result === false ){
			return false;
		}
		else {
			return true;
		}


	}

	public function get( $cache_id ){
		$cache_id = $this->check_key( $cache_id );
	//	echo $cache_id.'<br><br>';


		if( $this->redis->exists( $cache_id ) == true ){

			$data = $this->redis->hgetall( $cache_id );

		//	print_r($data);

			if( $data['expiry'] > time() || $data['expiry'] == 0 ){
				$data['data'] = unserialize( $data['data'] );
				return $data['data'];
			}
			else {
				return false;
			}



		}
		else {
			return false;
		}



	}

	public function delete( $cache_id ){
		$cache_id = $this->check_key( $cache_id );
		return (boolean) $this->redis->delete( $cache_id );
	}


	public function flush( $full = false ){

		if( $full == true ){

			$key_pattern = 'cache|*';

			$keys = $this->redis->keys( $key_pattern );

			if( is_array( $keys ) == true ){
				foreach( $keys as $key ){
					$this->redis->del( $key );
				}
			}

			/*
			$applications = app::get_configs();

			foreach( $applications as $i => $app ){

				$key_pattern = 'cache|' . $app['name'] . '|*';

				$keys = $this->redis->keys( $key_pattern );

				if( is_array( $keys ) == true ){
					foreach( $keys as $key ){
						$this->redis->del( $key );
					}
				}


			}
			*/

		}
		else{

			$key_pattern = 'cache|' . $this->app_name . '|*';

			$keys = $this->redis->keys( $key_pattern );

			if( is_array( $keys ) == true ){
				foreach( $keys as $key ){
					$this->redis->del( $key );
				}
			}

		}

		return true;

	}

	public function exists( $cache_id ){

		$cache_id = $this->check_key( $cache_id );

		return $this->redis->exists( $cache_id );

	}

}

?>