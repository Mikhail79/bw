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

class CacheFile extends CacheBase {

//	protected $cache_file = '';

	protected $cache_dir = '';


	/**
	 *
	 * Массив с информацией о закэшированных данных.
	 *
	 * $cache['list']['ключ'] - array( 'expiry' => timestamp , 'file' => '/dir/file' )
	 * $cache['data']['ключ'] - данные
	 *
	 */
//	public $cache = [];

	public function __construct(){



	//	$this->cache_file = app::$config['dirs']['cache'] . '/cache.php';

		$this->cache_dir = app::$config['dirs']['cache'] . '/data';

		// TODO УБрать
		//$htaccess = app::$config['dirs']['cache'] . '/.htaccess';

		if( is_file($htaccess) == false ){

		//	write_file($htaccess,'deny from all');

		}


		if( is_dir( $this->cache_dir ) == false ){

			mkdir( $this->cache_dir, 0777, true );

		}


	//	$this->update();


	}

	public function exists( $cache_id ){

		$file = $this->cache_dir . '/' . md5( $cache_id ) . '.php';

		return is_file( $file );

	}


	/**
	 * Особенность работы: Если кэшируется булево значение, которое равно false, тогда функция всегда будет возвращать false.
	 *
	 * @return false - вышел срок или нет такого ключа.
	 */
	public function get( $cache_id ){

		$file = $this->cache_dir . '/' . md5( $cache_id ) . '.php';

		if( is_file( $file ) == true ){

			$content = read_file( $file );

			$content = explode("\n",$content);

			$expiry = intval( $content[2] );

			$content = unserialize( stripcslashes( $content[3] ) );

			// Если время кэширования не установлено, то есть кэш хранится бессрочно или кэш ещё актуальный.
			if( $expiry == 0 || $expiry > time() ){

				return $content;

			}
			else {

				return false;

			}

		}
		else {

			return false;

		}



		/*

		if( isset( $this->cache['list'][$cache_id]['expiry'] ) === true &&
			( $this->cache['list'][$cache_id]['expiry'] > time() || $this->cache['list'][$cache_id]['expiry'] == 0 ) ){

			$file = $this->cache['list'][$cache_id]['file'];
			if( is_file($file) === true ){
				// !!! Читает только при первом обращение.
				include_once($file);
				//return $this->cache['data'][$cache_id];
				return unserialize( stripcslashes( $this->cache['data'][$cache_id] ) );
			}else{
				return false;
			}
		}
		else {
			// Удалить просроченный кэш-файл.
			//$file = $this->cache['list'][$cache_id]['file'];
			if( is_file($file) === true )
				unlink($file);
			return false;
		}

		*/


	}


	/**
	 *
	 * @param int $expiry время, на которое нужно
	 * кэшировать относительно текущего timestamp.
	 * @param bool $now обновить сразу же cache_db.php, а не в конце cp.php.
	 */
	public function set( $cache_id, $data = null, $expiry = 3600 ){

		/*
		// Бессрочное кэширование.
		$this->cache['list'][$cache_id]['expiry'] = 0;

		if( $expiry > 0 )
			$this->cache['list'][$cache_id]['expiry'] = time() + $expiry;


		if( isset( $this->cache['list'][ $cache_id ]['file'] ) == false ){
			// Случайное имя файла для кэша.
			//$this->cache['list'][$cache_id]['file'] = app::$config['dirs']['cache'] . '/' . time() . '_' . randstr(40);
			$this->cache['list'][$cache_id]['file'] = $this->cache_dir . '/' . md5( $cache_id ) . '.php';
		}

		*/



		/*
		$content = '<?php' . "\n";
		//$content.= '$this->cache["data"]["'.$cache_id.'"] = ' . var_export( $data, true ) . ';' . "\n";
		$content.= '$this->cache["data"]["'.$cache_id.'"] = "' . addcslashes( serialize( $data ), "\x00..\x1F\x7F\x22\x27\x5C" ) . '";' . "\n";
		$content.= '?>';
		*/

		if( $expiry > 0 ){

			$expiry = time() + $expiry;

		}

		$content = '<?exit;?>' . PHP_EOL;
		$content.= $cache_id . PHP_EOL;
		$content.= $expiry . PHP_EOL;
		$content.= addcslashes( serialize( $data ), "\x00..\x1F\x7F\x22\x27\x5C" );


		$file = $this->cache_dir . '/' . md5( $cache_id ) . '.php';


		try {

			//write_file( $this->cache['list'][$cache_id]['file'], $content );

			write_file( $file, $content );

			if( is_file( $file ) == true ){
				return true;
			}
			else {
				return false;
			}



//			if( is_file($this->cache_file) === true )
//				unlink($this->cache_file);

//			$this->update();

			return true;

		}
		catch( Exception $e ){

			return false;

		}

	}

	public function update(){

		return;

		/*

		if( is_file($this->cache_file) === false ){
			$content = '<?php' . "\n";
			$content.= '$this->cache["list"] = ' . var_export( $this->cache['list'], true ) . ';' . "\n";
			$content.= '?>';
			write_file( $this->cache_file, $content );
		}
		
		if( is_file( $this->cache_file ) == true ){
			include($this->cache_file);
		}

		*/
		
	}




	/**
	 * Обновить закэшированный $cache_id.
	 * @deprecated
	 */
	public function refresh($cache_id){
		$file = $this->cache['list'][$cache_id]['file'];
		if( is_file($file) === true )
			unlink($file);
	}

	/**
	 * Метод очищает содержимое директории с кэшем.
	 * @return boolean
	 */
	protected function _flush_cache( $app_name = null ){

		$result = false;

		if( app::exists( $app_name, $config ) == true ){

			$dir = $config['dirs']['cache'] . '/data';

			if( is_dir( $dir ) == true ){

				delete( $dir );

				mkdir( $dir, 0777, true );

				$result = true;

			}
		}

		return $result;

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
	public function flush( $full = false ){

		if( $full == true ){

			$applications = app::get_configs();

			foreach( $applications as $i => $app ){

				$result = $this->_flush_cache( $app['name'] );

			}

		}
		else{

			exec( 'rm -r ' . $this->cache_dir . '/*' );

			cache::update();

		}

	}

	
}

?>