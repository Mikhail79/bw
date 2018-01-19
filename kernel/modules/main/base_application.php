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

require_once( __DIR__ . '/functions.php');
require_once( __DIR__ . '/module.php');

class BaseApplication {

	// Название приложения.
	static public $name = '';

	// Конфигурация приложения: глобальный конфиг (configs/kernel.php) + конфиг текущего приложения.
	static public $config = [];

	// Для хранения прочитанных конфигураций.
	static protected $configs = [];

	// Путь к конфигурационному файлу.
	static public $config_dir = '';

	// Для хранения объектов модуля.
	static protected $modules = [];

	// Путь к директории ядра.
	static public $kernel_dir = '';

	static public $dirs = [];



	//static protected function common_init( $app_name, $config_dir = '' ){
	static protected function primary_init( $app_name, $config_dir = '' ){

		$app_name = (string) $app_name;

		if( version_compare(PHP_VERSION, '5.4.0', '<') == true ){
			exit('The BlueWhale swims only in PHP >= 5.4.x');
		}

		if( $app_name == '' ){
			// Не задано название приложения.
			throw new \Exception('Do not set the application name.');
		}

		self::$kernel_dir = realpath( __DIR__ . '/../../' );

		//
		// BEGIN Директория для конфигурационных файлов.
		//

		// TODO Добавить в главный конфиг.

		if( $config_dir == '' ){
			$config_dir = self::$kernel_dir . '/configs';
		}

		self::$config_dir = $config_dir;

		//
		// END Директория для конфигурационных файлов.
		//


		//
		// BEGIN Главный конфигурационный файл.
		//

		self::load_config( 'kernel', $config_dir );

		//
		// END Главный конфигурационный файл.
		//

		//
		// BEGIN Конфигурационный файл текущего приложения.
		//

		self::load_config( $app_name, $config_dir );

		//
		// END Конфигурационный файл текущего приложения.
		//


		self::$name = self::$config['name'];

		self::$dirs = self::$config['dirs'];


	}


	/**
	 * Метод проверяет, откуда запущено приложение.
	 * Command-Line Interface (CLI) или иной интерфейс (HTTP, CGI)
	 * @return boolean
	 *      true = CLI
	 *      false = HTTP, CGI
	 */
	static public function cli(){

		$result = false;

		if( php_sapi_name() == 'cli' ){

			$result = true;

		}

		return $result;

	}


	/**
	 * Метод возвращает массив с именами приложений.
	 * TODO $return_configs
	 */
	static public function app_list( $dir = '', $return_configs = false ){

		$names = [];

		if( $dir == '' ){
			$dir = self::$config_dir;
		}

		if( is_dir( $dir ) == true ){

			foreach( self::$config['applications'] as $app_name ){

				$names[] = $app_name;

			}



			/*
			$files = get_dir( $dir, 1 );

			foreach( $files as $file ){

				$matches = [];

				//if( preg_match( '@^config\.(.*)\.php$@i', $file, $matches ) == true ){
				if( preg_match( '@^(.*)\.php$@i', $file, $matches ) == true ){

					if( $matches[1] == 'default' || $matches[1] == 'kernel' ){
						continue;
					}

					$file = $dir . '/' . $file;

					$names[] = $matches[1];

				}

			}
			*/

		}

		return $names;

	}



	/**
	 * Метод возвращает конфигурации приложений.
	 *
	 * @return array Возвращает массив для $config['applications'].
	 */
	static public function get_configs( $dir = '', $reload = false ){

		$applications = [];

		$names = self::app_list( $dir );

		if( $dir == '' ){
			$dir = self::$config_dir;
		}

		foreach( $names as $name ){

			$applications[] = self::get_config( $name, $dir, $reload );

		}

		return $applications;

	}


	/**
	 * Метод загружает конфигурационный файл и объединяет свои ключ с self::$config.
	 *
	 * Таким образом, загружается конфигурационный файл ядра, а после конфигурационный файл
	 * текущего приложения. Так происходит наследование и переопределение.
	 *
	 * @param $application
	 * @param string $dir
	 * @return boolean
	 * @throws \Exception
	 */
	static protected function load_config( $app_name, $dir = '' ){

		if( $dir == '' ){
			$dir = self::$config_dir;
		}

		$file = $dir . '/' . $app_name . '.php';

		//$config = null;
		$config = [];

		// Подключить конфигурационный файл.
		if( is_file( $file ) == true ){

			require_once( $file );

		}
		else {

			// Конфигурационный файл не найден.
			throw new \Exception('The configuration file not found.');

		}

		if( empty( $config ) == true || is_array( $config ) == false ){
			// Конфигурация пуста.
			throw new \Exception('The configuration is empty.');
		}

		self::$configs[ $app_name ] = $config;

		// TODO Обработка для вложенных массивов.
		foreach( $config as $key => $value ){

			self::$config[ $key ] = $value;

		}

	}


	/**
	 * Метод возвращает конфигурацию ядра + приложения.
	 * Ключи в конфигурации приложения накладываются на ключи в ядре.
	 *
	 * @param $app_name
	 * @return array
	 */
	static public function get_full_config( $app_name ){

		$kernel_config = self::get_config('kernel');

		$app_config = self::get_config( $app_name );

		$config = array_merge( $kernel_config, $app_config );

		return $config;

	}


	/**
	 * Метод возвращает конфигурацию приложения.
	 * Результат кэшируется после первого чтения.
	 *
	 * @param $app
	 * @param string $dir
	 * @return null
	 */
	static public function get_config( $app, $dir = '', $reload = false ){

		$app = mb_strtolower( $app );

		if( array_key_exists( $app, self::$configs ) == true && $reload == false ){

			return self::$configs[ $app ];

		}

		$config = null;

		if( $dir == '' ){

			$dir = self::$config_dir;

		}

		$file = $dir . '/' . $app . '.php';

		/*
		if( is_dir( $dir ) == true ){

			$file = $dir . '/config.' . $app . '.php';

			if( is_file( $file ) == true ){

				//require_once( $file );
				require( $file );

				self::$configs[ $app ] = $config;

			}

		}
		*/

		// Подключить конфигурационный файл.
		if( is_file( $file ) == true ){

			require( $file );

		}
		else {

			// Конфигурационный файл не найден.
			throw new \Exception('The configuration file not found.' . $file);

		}

		if( empty( $config ) == true || is_array( $config ) == false ){
			// Конфигурация пуста.
			throw new \Exception('The configuration is empty.');
		}

		self::$configs[ $app ] = $config;


		return $config;

	}


	/**
	 * Метод однократно подключает файл модуля.
	 * В файле модуля могут быть функции и классы.
	 * В файле модуля не должно быть кода вне функций!
	 * Если не задан объект модуля, создавать стандартный class_module.
	 * @param string $class_name Название класса, который представляет модуль.
	 * Допускается отсутствие класса модуля. По умолчанию название класса модуля == $module_name.
	 * Класс должен быть унаследован от предка class_module.
	 *
	 * @param mixed $params Параметры передаваемые в конструктор класса модуля.
	 *
	 * @return Module
	 *
	 *
	 *
	 */
	static public function load_module($module_name, $app_name = null, $state = 'default'){
	//static public function load_module($module_name, $app_name = null, $class_name = null, $params = null){

		if( preg_match( '@^[\.a-z0-9_-]+$@i', $module_name ) == false ){

			throw new Exception( 'Incorrect module name. ' . $module_name );

		}


		if( $app_name == 'kernel' ){

			$module_file = self::$kernel_dir . '/modules/' . $module_name . '.php';

			$module_dir = self::$kernel_dir . '/modules/' . $module_name;

		}
		else{

			$module_dir = self::$config['dirs']['modules'] . '/' . $module_name;

			if( $app_name == null ){

				$app_name = self::$config['name'];
				$module_file = self::$config['dirs']['modules'] . '/' . $module_name . '.php';

			}
			else if( self::exists($app_name,$application) === true ){

				$module_file = $application['dirs']['modules'] . '/' . $module_name . '.php';

			}

		}

		if( is_object( self::$modules[ $app_name ][ $module_name ] ) == true ){

			$module = self::$modules[ $app_name ][ $module_name ];

			if( $module->loading == true ){

				return $module;

			}
			else {

				$module->loading = true;

				$module->load_dependencies();

				$module->load_state( $state );

				$module->loading = false;

			}

			return $module;

		}




		if( is_file( $module_file ) == true ){
			//echo $module_file;
			require_once( $module_file );

			//		self::$modules[ $app_name ][ $module_name ] = true;

			/*
						if( $class_name == null ){
							$class_name = $module_name;
						}
						*/

			self::$modules[ $app_name ][ $module_name ] = new Module( $module_name, $app_name );

			//		print_r(self::$modules);


			/*
						if( class_exists($module_name) == true && is_subclass_of( $class_name, 'class_module' ) == true ){

							self::$modules[ $app_name ][ $module_name ] = new $class_name( $module_name, $app_name, $params );

						}else{

							self::$modules[ $app_name ][ $module_name ] = new class_module( $module_name, $app_name, $params );

						//	print_r( get_included_files() );
						//	exit;


						}
			*/


			return self::$modules[ $app_name ][ $module_name ];

		}
		elseif( is_dir( $module_dir ) == true ){


			//
			// BEGIN Объект модуля.
			//

			$module = new Module( $module_name, $app_name );

			//
			// END Объект модуля.
			//


			self::$modules[ $app_name ][ $module_name ] = $module;
			//$module = self::$modules[ $app_name ][ $module_name ];

			$module->loading = true;

			$module->load_dependencies();

			$module->load_state( $state );

			$module->loading = false;

			return $module;

		}
		else{

			throw new \Exception('The module not found. "' . $module_file . '".');

		}

	}


	/**
	 * @param $controller_name
	 * @param null $module_name
	 * @param null $app_name
	 * @return Controller | null
	 * @throws Exception
	 */
	static public function get_controller( $controller_name, $module_name = null, $app_name = null ){

		if( $app_name == null ){
			$app_name = self::$name;
		}


	//	self::load_module('application','kernel','controller');


		$controller_path = '';
		$controller = null;

		$config = self::get_config( $app_name );


		if( $controller_name != '' && $module_name != '' ){

			self::load_module( $module_name, $app_name );

			//$module = self::get_module( $module_name, $app_name );

			$class_name = $controller_name;
			$controller = new $class_name();

			//$controller_path = $module->dir . '/controllers/' . $controller_name . '.php';
			//echo $controller_path;exit;

		}
		else {

			if( array_key_exists( $controller_name, self::$config['controllers'] ) == true ){

				$controller_data = self::$config['controllers'][ $controller_name ];

				$controller_path = $config['dirs']['controllers'] . '/' . $controller_data[0];
				$class_name = $controller_data[1];


			}
			else {

				$controller_path = $config['dirs']['controllers'] . '/' . $controller_name . '.php';
				$class_name = $controller_name;

			}


			if( is_file( $controller_path ) == true ){
				require_once( $controller_path );
				$controller = new $class_name();
			}

		}




		return $controller;

	}

	static public function get_controller2( $controller_name, $app_name = null, $config = null ){

		if( $app_name == null ){

			$app_name = self::$name;

		}

		if( is_array( $config ) == true ){

			$current_config = $config;

		}
		else {

			$current_config = self::get_config( $app_name );

		}

		$controller = null;

		$controller_module = null;

		$controller_application = $app_name;

		$exists = false;

		foreach( $current_config['controllers'] as $key => $item ){

			if( is_string( $item ) == true ){

				if( $item == $controller_name ){

					$controller_class = $item;

					$controller_file = $item . '.php';

					$exists = true;

					break;

				}

			}
			else if( is_array( $item ) == true ) {

				if( $item['name'] == $controller_name ){

					$controller_class = $item['name'];

					$controller_file = $item['name'] . '.php';

					if( array_key_exists( 'class', $item ) == true ){

						$controller_class = $item['class'];

					}

					if( array_key_exists( 'file', $item ) == true ){

						$controller_file = $item['file'];

					}

					if( array_key_exists( 'application', $item ) == true ){

						$controller_application = $item['application'];

					}


					if( array_key_exists( 'module', $item ) == true ){

						$controller_module = $item['module'];

					}

					$exists = true;

					break;

				}

			}

		}



		if( $exists == true ){

			$config = self::get_config( $controller_application );

			if( $controller_module !== null ){

				self::load_module( $controller_module, $controller_application );

				$controller = new $controller_class();

			}
			else {

				$controller_path = $config['dirs']['controllers'] . '/' . $controller_file;

				if( is_file( $controller_path ) == true ){

					require_once( $controller_path );

					$controller = new $controller_class();

				}

			}

		}


		return $controller;

	}


	/**
	 * Возвращает объект модуля.
	 *
	 * @static
	 * @param string $module_name
	 * @param string $app_name
	 * @param string $state Так как метод не только возвращает объект модуля, но ещё может загружать модуль, пришлось ввести
	 * этот параметр, для передачи его load_module.
	 * @return Module
	 */
	static public function get_module( $module_name, $app_name = null, $state = 'default' ){

		return self::load_module( $module_name, $app_name, $state );

	}

	static public function module_exists( $module_name, $app_name = ''){
		if( $app_name == '' ){
			$app_name = self::$config['name'];
			$module_file = self::$config['dirs']['modules'] . '/' . $module_name . '.php';
		}
		elseif( self::exists($app_name,$application) === true ){
			$module_file = $application['dirs']['modules'] . '/' . $module_name . '.php';
		}

		if( is_file( $module_file ) == true ){
			return true;
		}
		else{
			return false;
		}
	}

	/**
	 * Метод проверяет существование приложения.
	 *
	 * TODO Можеть быть стоит убрать подключение, и просто считывать как файл.
	 * Тогда при зашифрованном файле ionCube Encoder будет белиберда.
	 *
	 * $config - кэшируется после первого чтения.
	 */
	static public function exists( $app_name, &$config = [] ){

		$exists = false;

		$file = self::$config_dir . '/' . $app_name . '.php';

		if( is_file( $file ) == true ){
			$config = self::get_config( $app_name );
			// self::cons($config);
			$exists = true;
		}


		/*
		foreach( self::$config['applications'] as $application ){
			if( mb_strtolower( $application['name'] ) == $app_name ){
				$config = $application;
				$exists = true;
				break;
			}
		}
		*/

		return $exists;
	}

	/**
	 * Метод возвращает массив с именами модулей указанного приложения.
	 */
	static public function get_modules( $app_name = '' ){
		$arr = [];

		$dir = '';

		if( $app_name == '' ){
			$app_name = self::$config['name'];
		}

		if( $app_name == 'kernel' ){
			$dir = self::$kernel_dir . '/modules';
		}
		else {
			if( self::exists( $app_name, $config ) == true ){
				$dir = $config['dirs']['modules'];
			}
		}

		if( is_dir( $dir ) == true ){

			$files = get_dir( $dir );

		//	$files = array_merge( $files['dirs'], $files['files'] );
			$files = $files['dirs'];

			foreach( $files as $file ){

				//$module_file = $dir . '/' . $file . '/.metadata/module.php';
				//echo $module_file . '<br>';

				$path_parts = pathinfo( $dir . '/' . $file );

				if( is_modulename( $path_parts['filename'] ) == true ){
					// Условие добавлено, так как модуль, может быть одиночным файлом, у которого может быть одноимённая директория.
					if( in_array( $path_parts['filename'], $arr ) == false ){
						$arr[] = $path_parts['filename'];
					}
				}
			}

		}

		return $arr;

	}

	/**
	 * Метод возвращает список загруженных модулей на текущий момент.
	 */
	static public function get_loaded_modules(){

		$list = [];

		foreach( self::$modules as $app_name => $app_modules ){
			foreach( $app_modules as $module_name => $module ){
				$item = [];
				$item['module'] = $module_name;
				$item['application'] = $app_name;
				$item['states'] = $module->get_states();
				$list[] = $item;
			}
		}

		return $list;

	}


	static public function include( $file, $once = true ){

		$path = self::$config['dirs']['includes'] . '/' .$file;

		if( is_file( $path ) == true ){

			if( $once == true ){

				require_once( $path );

			}
			else {

				require( $path );

			}
		}
		else {

			throw new Exception('The script "' . $file . '" not found.');

		}

	}

}

?>