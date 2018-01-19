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

require_once( __DIR__ . '/base_application.php');
require_once( __DIR__ . '/exception_http.php');

/**
 * Класс, который инициализирует систему и содержит ссылки на важные объекты: user, smarty, db.
 *
 *
 */
class WebApplication extends BaseApplication {

	// Типы сообщений.
	const MES_ERROR = 1; // Ошибка, не удачное выполнение операции.
	const MES_INFO = 2; // Позитивная информация, успешное выполнение операции.
	const MES_WARN = 3; // Важная информация, предупреждение, не критическая ошибка.
	const MES_OK = 4; // Успешное выполнение операции.

	// Типы событий AF - Anti Flood.
	const AF_LOGIN = 0; // Попытка авторизации.
	const AF_REG = 1; // Попытка регистрации.
	const AF_ACCESS_RECOVERY = 2; // Сброс пароля (восстановление доступа).
	const AF_FORM_SUBMIT = 3; // Отправка форм.


	/**
	 * Типы ключей.
	 */

	// Пользовательский ключ.
	const KEY_CUSTOM = 0;

	// Регистрация пользователя.
	const KEY_REGISTRATION = 1;

	// Восстановление доступа (сброс пароля).
	const KEY_ACCESS_RECOVERY = 2;

	// Срок действия ключа по умолчанию.
	// ( 60 * 60 * 24 ) * 1 сутки
	static public $default_expiry = 86400;

	static public $bluewhale = 'http://cms.designium.ru';

	static public $version = '01012017';


	/**
	 * Вынести в глобальный конфиг.
	 * @var array
	 */
	static public $af_types = array(
		0 => 'Форма авторизации.',
		1 => 'Форма регистрации.',
		2 => 'Форма восстановления пароля.',
		3 => 'Форма.'
	);

	/**
	 * Ограничения.
	 * time - время в секундах на которое блокируется IP,
	 * при достижении максимального значения counter.
	 */
	static public $af_limits = array(
		0 => array( 'counter' => 25, 'time' => 600 ),
		1 => array( 'counter' => 10, 'time' => 600 ),
		2 => array( 'counter' => 10, 'time' => 600 ),
		3 => array( 'counter' => 10, 'time' => 3600 ),
	);


	/**
	 * Month day's.
	 * for combobox
	 */
	static public $days = array('&nbsp;',1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);

	// Типы событий.
//	static public $info = 1;
//	static public $warning = 2;
//	static public $error = 3;

	static protected $log_events = [
		1 => 'Пользователь вошёл в программу.',
		2 => 'Пользователь вышел из программы.',
		3 => 'Создан новый товар.',
		4 => 'Изменён товар.',
		5 => 'Удалён товар с кодом %d.',
	];


	static public $event_listeners = [];

	/**
	 * @var array Dictionary
	 */
	static public $dictionaries = [];


	//
	// BEGIN Объекты.
	//



	/**
	 * Текущая исполняемая страница.
	 *
	 * @var Page
	 */
	static public $page = null;


	/**
	 * Пользователь.
	 *
	 * @var User|null $user
	 */
	static public $user = null;


	/**
	 * Основное подключение к БД.
	 *
	 * @var DBO|null $db
	 */
	static public $db = null;

	/**
	 * Шаблонный движок Smarty.
	 *
	 * @deprecated
	 * @var Smarty|null
	 */
	static public $smarty = null;


	/**
	 * Шаблонизатор (TemplateEngine)
	 *
	 * @var TemplateEngine|null
	 */
	static public $tpl = null;


	/**
	 * Основное подключение к Redis.
	 *
	 * @var Redis | null
	 */
	static public $redis = null;



	static public $purifier = null;

	//
	// END Объекты.
	//





	// Время старта (для замера скорости работы).
	// Не очень точный показатель.
	static public $start_time = null;


	// Признак инициализированности.
	static protected $initialized = false;

	static protected $pre_initialized = false;


	// Текущий интерфейс приложения.
	static public $interface = null;


	// Абсолютный путь к текущему интерфейсу.
	static public $interface_path = null;


	// Текущий язык.
	static public $language = null;


	// Для внутреннего хранения объектов страниц.
	// Сюда попадают объекты, инициированные app::get_page().
	static protected $pages = [];





	// Адрес текущего интерфейса.
	static public $interface_url = '';


	static public $internals_url = '';


	// Адрес картинок текущего интерфейса.
	static public $images_url = '';


	// URL сайта. Часто совпадает с root_url. Например "http://site.com/".
	static public $url = '';

	// URL вещуший к контроллеру. Например "http://site.com/cp".
	static public $root_url = '';


	// Признак 404 ошибки.
	static public $error404 = false;





	// URL к открытым файлам ядра. Прописывается в конфиге приложения.
	// Без слэша на конце.
	// TODO Вынести в конфиг.
	static public $kernel_url = '/kernel';





	// Путь к контроллеру.
	// Вычисляется динамически!
	static public $controller = '';


	// Имя скрипта (контроллера).
	// Вычисляется динамически!
	static public $controller_name = '';


	// Вычисляется динамически!
	static public $controller_url = '';


	// Переопределяет session_id для приложения.
	// Используется, когда session_id нужно передать не через cookie.
	// В случае с Flash, идентификатор сессии передаётся через отдельную переменную $_REQUEST['_sid'].
	// Устанавливать до инициализации приложения.
//	static public $session_id = '';


	// Буффер обмена.
	static public $data = null;


	// 0 - URL к скрипту
	// 1 - приоритет (целое число).
	// 3 - Параметр для $LAB. Если true - блокирующая загрузка, то есть будет дописан .wait(), false - не блокирующая загрузка.
	static public $scripts = [];


	static public $styles = [];





	/**
	 * Метод расширяет функции parent::primary_init
	 * Загружает только конфигурационный файл приложения.
	 * SEF на уровне конфигурационного файла.
	 *
	 * @param string $app_name
	 * @param string $config_dir
	 * @throws Exception
	 */
	static public function primary_init( $app_name, $config_dir = '' ){

		$app_name = (string) $app_name;

		if( self::$pre_initialized == true ){
			// Приложение уже было инициализированно.
			throw new Exception('The application has been minimal initialized.');
		}


		self::$start_time = microtime( true );

		parent::primary_init( $app_name, $config_dir );



		//
		// BEGIN
		//

		// TODO Для CLI скрипта не актуально. Хотя для вычислений может пригодиться.
		// TODO В конфиг

		self::$controller_url = app::$config['controller_url'];

		// URL сайта. Часто совпадает с root_url. Например "http://site.com/".
		self::$url = self::$config['url'];

		// URL вещуший к контроллеру. Например "http://site.com/cp".
		self::$root_url = self::$config['root_url'];

		// URL путь к интерфейсу.
		self::$interface_url = self::$config['interface_url'];

		// URL к внутренностям (директории) приложения.
		self::$internals_url = self::$config['internals_url'];

		// URL путь к картинкам сайта.
		self::$images_url = self::$config['images_url'];

		self::$kernel_url = self::$config['kernel_url'];

		//
		// END
		//



		self::load_module( 'main', 'kernel' );

		/*
		$files = get_included_files();
		print_r($files);
		echo memory_get_peak_usage(true);
		exit;
		*/



		// TODO Кэшировать конфигурации модулей.



		//
		// BEGIN Почистить ключи в $_REQUEST.
		//

		// Вынести в primary_init

		if( is_array( self::$config['forbidden_vars'] ) == true ){

			foreach( self::$config['forbidden_vars'] as $var ){

				if( array_key_exists( $var, $_REQUEST ) == true ){

					unset( $_REQUEST[ $var ] );
					unset( $_POST[ $var ] );
					unset( $_GET[ $var ] );

				}

			}

		}

		//
		// END Почистить ключи в $_REQUEST.
		//


//		print_r(get_included_files());
//		echo memory_get_peak_usage(true);
//		exit;


		//
		// BEGIN Собрать конфигурации модулей.
		//



		/*
		$dirs = get_dir( self::$config['dirs']['modules'], 2 );

		foreach( $dirs as $dir ){
			$path = self::$config['dirs']['modules'] . '/' . $dir . '/module.php';
			if( is_file( $path ) == true ){
				$module = [];
				//$module = require_once( $path );
				require_once( $path );
				if( array_key_exists( 'routes', $module ) == true ){
					foreach( $module['routes'] as $route ){
						$route['module'] = $dir;
						self::$config['routes'][] = $route;
					}
				}
				//print_r($module);
			}
		}
		*/


	//	print_r(self::$config);
		//print_r($dirs);
	//	exit;

		//
		// END Собрать конфигурации модулей.
		//


		//
		// BEGIN Импортировать список контроллеров из модулей.
		//


		if( is_array( self::$config['import_controllers'] ) == true ){

			$dirs = get_dir( self::$config['dirs']['modules'], 2 );

			foreach( self::$config['import_controllers'] as $module_name ){

				$path = self::$config['dirs']['modules'] . '/' . $module_name . '/.metadata/controllers.php';

				if( is_file( $path ) == true ){

					$controllers = [];

					require_once( $path );

					if( is_array( $controllers ) == true ){

						foreach( $controllers as $arr_controller ){

							$arr_controller['module'] = $module_name;

							self::$config['controllers'][] = $arr_controller;

						}

					}

				}

			}

		}


		//
		// END Импортировать список контроллеров из модулей.
		//



		//
		// BEGIN Импортировать список сервисов из модулей.
		//

		/*

		if( is_array( self::$config['import_services'] ) == true ){

			$dirs = get_dir( self::$config['dirs']['modules'], 2 );

			foreach( self::$config['import_services'] as $module_name ){

				$path = self::$config['dirs']['modules'] . '/' . $module_name . '/.metadata/services.php';

				if( is_file( $path ) == true ){

					$controllers = [];

					require_once( $path );

					if( is_array( $controllers ) == true ){

						foreach( $controllers as $arr_controller ){

							$arr_controller['module'] = $module_name;

							self::$config['services'][] = $arr_controller;

						}

					}

				}

			}

		}

		*/

		//
		// END Импортировать список сервисов из модулей.
		//


		$init_script = self::$config['dirs']['includes'] . '/init.php';

		if( is_file( $init_script ) == true ){

			require_once( $init_script );

		}




		//print_r( get_included_files() );
		//echo memory_get_peak_usage(true);
		//exit;

		self::$pre_initialized = true;

	}



	static public function init_redis(){

		require_once( __DIR__ . '/redis/redis_wrapper.php');

		self::$redis = new RedisWrapper();

		if( self::$config['redis']['persistent'] == true ){

			self::$redis->pconnect( self::$config['redis']['host'] );

		}
		else {

			self::$redis->connect( self::$config['redis']['host'] );

		}


		// TODO Базы redis и RedisManager
		$result = self::$redis->select( self::$config['redis']['db'] );

		if( $result == false ){

			throw new Exception('Redis database not selected.');

		}

	}


	static public function init_db(){

		$module = self::get_module('main', 'kernel');
		require_once( $module->dir . '/database/dbo.php');


		if( self::$db == null ){

			if( self::$config['db']['db'] == '' ){

				throw new Exception('Not specified database name.');

			}

			$db = new DBO();

			$db->connect(
				self::$config['db']['host'],
				self::$config['db']['port'],
				self::$config['db']['db'],
				self::$config['db']['user'],
				self::$config['db']['password']
			);

			$db->tp = self::$config['db']['tp'];

			dbm::add_dbo( $db );

			self::$db = $db;

		}


		if( is_array( self::$config['databases'] ) == true ) {

			foreach ( self::$config['databases'] as $db_index => $db_config ) {

				if( dbm::exists( $db_index ) == false ) {

					$db = new DBO();

					$db->connect(
						$db_config['host'],
						$db_config['port'],
						$db_config['db'],
						$db_config['user'],
						$db_config['password']
					);

					$db->tp = $db_config['tp'];

					dbm::add_dbo($db, $db_index);

				}

			}

		}


		if( self::$config['debug'] == true ){

			self::$db->log_off = false;

		}


	}




	/**
	 * Метод инициализации приложения.
	 * Инициализация допускается только один раз за сеанс работы.
	 *
	 * @param str $app_name Имя запускаемого приложения.
	 * @param str $config_path Путь к конфигурационному файлу.
	 * @return bool Признак инициализации.
	 *
	 */
	static public function secondary_init( $app_name = '', $config_path = '' ){

		$app_name = (string) $app_name;

		if( self::$initialized == true ){
			// Приложение уже было инициализированно.
			// TODO Warning
			//	throw new Exception('The application has been initialized.');
			return;
		}

		if( self::$pre_initialized == false ){

			self::primary_init( $app_name, $config_path );

		}


		//
		// BEGIN Подключение к БД.
		//

		if( self::$config['use_db'] == true || self::$config['init_subsystems']['db'] == true ) {

			self::init_db();

		}


		//
		// END Подключение к БД.
		//

		//
		// BEGIN Подключение к Redis.
		//

		if( self::$config['use_redis'] == true || self::$config['init_subsystems']['redis'] == true ){

			self::init_redis();

		}

		//
		// END Подключение к Redis.
		//




		/*
		$files = get_included_files();

		print_r($files);

		echo memory_get_peak_usage(true);

		//echo class_trace::debug_console();
		exit;

		*/


		// TODO Это вынести в request.
		if( self::cli() == true ){

			$params = $_SERVER['argv'];

			array_shift( $params );

			foreach( $params as $param ){
				$key = '';
				$value = '';
				list( $key, $value ) = explode('=', $param);
				$_REQUEST[ $key ] = $value;
			}

			unset($params, $param, $key, $value);

		}









		//
		// BEGIN Загрузка модулей.
		//

		// TODO А также автозагрузка из БД

		if( is_array( self::$config['autoload_modules'] ) == true ){

			foreach( self::$config['autoload_modules'] as $module ){

				if( is_array( $module ) == true ){

					// $module[0] - название модуля
					// $module[1] - название приложения
					// $module[2] - состояние модуля

					if( count( $module ) == 1 ){

						self::load_module( $module[0] );

					}
					else if( count( $module ) == 2 ){

						self::load_module( $module[0], $module[1] );

					}
					else if( count( $module ) == 3 ){

						self::load_module( $module[0], $module[1], $module[2] );

					}

				}
				else {

					self::load_module( $module );

				}



			}

		}


		//
		// END Загрузка модулей.
		//








		// TODO Для режима CLI сделать свои обработчики.
		//		if( self::cli() == false ){

		//			if( self::$config['exception_handler'] != null )
		//				set_exception_handler( self::$config['exception_handler'] );

		//			if( self::$config['error_handler'] != null )
		//				set_error_handler( self::$config['error_handler'], self::$config['error_types'] );

		//		}







		// Инициализировать кэш.
		if( self::$config['use_cache'] == true || self::$config['init_subsystems']['cache'] == true ){

			$module = self::get_module('main','kernel');
			require_once( $module->dir . '/cache/cache.php' );

			cache::init( self::$config['cache_engine'] );

		}


		//
		// BEGIN Проверка IP.
		//


		// Тоже самое должно быть и на уровне primary_init но только на файлах
		// app::ban_ip( $_REQUEST['REMOTE_ADDR'], 'Проверка.' );

		if( self::$config['check_ip'] == true && self::$db != null ){

			$banned_ip = app::af_check_ip();

			if( $banned_ip == true ){
				require_once( self::$config['inc_pages']['ip_ban'] );
				exit;
			}

		}



		//
		// END Проверка IP.
		//





		if( self::cli() == false && ( self::$config['use_sessions'] == true || self::$config['init_subsystems']['sessions'] == true ) ){

			$module = self::get_module( 'main', 'kernel' );
			require_once( $module->dir . '/session/session.php' );

			session::init( self::$config['session_engine'] );

			session::start();

		}


		// Установить интерфейс.
		self::set_interface();


		// TODO проверка фактического запуска сессий.


		// use_db deprecated
		if( ( self::$config['use_sessions'] == true || self::$config['init_subsystems']['sessions'] == true ) && ( self::$config['use_db'] == true || self::$config['init_subsystems']['db'] == true ) ){

			$uid = session::get_uid();

			self::$user = new User();

			if( $uid > 0 ) {

				self::$user->init( $uid );
				self::$user->update_request_time();

			}

		}







		if( self::$config['use_template_engine'] == true || self::$config['init_subsystems']['template_engine'] == true ){

			self::$tpl = new TemplateEngine( self::$config['template_engine'] );

		}


		self::init_i18n();

		self::$initialized = true;

		return self::$initialized;

	}


	static public function init_sms_provider(){



	}

	/**
	 * @deprecated
	 */
	static public function init_smarty(){

		// Подключить шаблонный движок Smarty.

		require_once( app::$kernel_dir . '/other/smarty/Smarty.class.php' );

		self::$smarty = new Smarty();

		/*
		if( array_key_exists( 'cache_lifetime', app::$config['smarty'] ) == true ){
			self::$smarty->setCaching( Smarty::CACHING_LIFETIME_SAVED );
			self::$smarty->setCacheLifetime( app::$config['smarty']['cache_lifetime'] );
		}
		*/



		self::$smarty->template_dir = self::$config['dirs']['interfaces'] . '/' . self::$interface . '/templates';
		self::$smarty->compile_dir = self::$config['dirs']['cache'] . '/smarty/templates_c/' . self::$config['name'] . '/interfaces/' . self::$interface;
		self::$smarty->cache_dir = self::$config['dirs']['cache'] . '/smarty/cache';
		self::$smarty->config_dir = self::$config['dirs']['app'];

		$my_security_policy = new Smarty_Security(self::$smarty);
		$my_security_policy->allow_php_tag = true;

		self::$smarty->enableSecurity($my_security_policy);



		//	self::$smarty->registerClass('app', '\bw\application\app');

	}


	static public function init_purifier(){

		require_once( self::$kernel_dir . '/other/htmlpurifier/HTMLPurifier.auto.php' );

		// TODO Вынести в конфиг системы.
		$purifier_config = [
			'HTML.AllowedElements' => null,
			'HTML.Trusted' => false,
			'URI.Base' => self::$config['root_url'],
			'URI.DefaultScheme' => 'http',
			'URI.DisableExternal' => true,
			'Cache.SerializerPath' => self::$config['dirs']['cache']
		];

		$config = HTMLPurifier_Config::createDefault();

		if( is_array( $purifier_config ) == true ){

			foreach( $purifier_config as $config_key => $config_value ){

				$config->set( $config_key, $config_value );

			}

		}

		self::$purifier = new HTMLPurifier( $config );

	}



	static public function autoload( $class_name ){

		// use realpath()

		//$parts = explode('\\',$class_name);
		//$namespace = $parts[0];
		//$module_name = $parts[1];

		// Если класс указан с пространством имён.
		if( preg_match('@^bw\\\\@i', $class_name) == true ){

			$class_name = preg_replace('@^bw\\\\@i', '', $class_name);

			$path = __DIR__ . '/' . $class_name . '.php';

		}
		else if( preg_match('@^class_@i', $class_name) == true ){

			$class_name = preg_replace('@^class_@i', '', $class_name);

			$class_name = 'bw_' . $class_name;

			$path = __DIR__ . '/' . $class_name . '.php';

		}
		else {

			$path = __DIR__ . '/' . $class_name . '.php';

		}


		if( is_file( $path ) == true ){

			require_once( $path );

		}


	}


	/**
	 * Текущий установленный язык интерфейса.
	 */
	static public function get_language(){

		return self::$language;

	}

	static public function get_languages(){

		$languages = cache::get('languages');

		if( $languages === false ){

			$sql = 'SELECT * FROM languages WHERE remove_ts = 0';

			$records = app::$db->get_records( $sql );

			$languages = [];

			foreach( $records as $record ){

				$languages[ $record['lid'] ] = $record;

			}

			cache::set('languages', $languages);

		}

		return $languages;

	}

	/**
	 * Hint: i(NTERNATIONALIZATIO)n = i(18 characters)n
	 */
	static protected function init_i18n(){

		require_once( __DIR__ . '/dictionary.php' );

		self::set_language();

		$lang_functions = __DIR__ . '/i18n/' . self::$language . '_functions.php';

		if( is_file( $lang_functions ) == true ){

			require_once( $lang_functions );

		}

	}


	/**
	 * Метод установки языка приложения.
	 */
	static protected function set_language(){

		// Установить язык.
		if( self::$config['use_db'] == true || self::$config['init_subsystems']['db'] == true ){

			$languages = self::get_languages();

		}

		if( self::$config['ml'] == true ){

			if( isset( $_REQUEST['_language'] ) == true
				&& ( in_array( $_REQUEST['_language'], self::$config['languages'] ) == true
					|| array_key_exists( $_REQUEST['_language'], $languages ) == true )
			){

				self::$language = $_REQUEST['_language'];
				$_SESSION[ self::$config['name'] ]['language'] = self::$language;

			}
			else{

				if( isset( $_SESSION[ self::$config['name'] ]['language'] ) == true ){

					self::$language = $_SESSION[ self::$config['name'] ]['language'];

				}
				else{

					self::$language = self::$config['language'];
					$_SESSION[ self::$config['name'] ]['language'] = self::$language;

				}

			}

		}
		else {

			self::$language = self::$config['language'];
			$_SESSION[ self::$config['name'] ]['language'] = self::$language;

		}


	//	\class_dictionary::init( self::$language );

	}

	static public function is_front_page(){

		return self::front_page();

	}

	static public function front_page(){

		if( array_key_exists( '_route', $_REQUEST ) == false
			&& array_key_exists( '_page', $_REQUEST ) == false
			&& array_key_exists( '_service', $_REQUEST ) == false ){

			$parts = parse_url( $_SERVER['REQUEST_URI'] );

			if( array_key_exists( 'path', $parts ) == true ){
				if( $parts['path'] == '/' ){

					return true;

				}
			}

		}

		return false;

	}


	/**
	 * Метод установки интерфейса приложения.
	 */
	static public function set_interface(){

		if( self::$config['mi'] == true ){

			if( isset( $_REQUEST['_interface'] ) == true && in_array( $_REQUEST['_interface'], self::$config['interfaces'] ) == true ){

				self::$interface = $_REQUEST['_interface'];

				$_SESSION[ self::$config['name'] ]['interface'] = self::$interface;

			}
			else{

				if( isset( $_SESSION[ self::$config['name'] ]['interface'] ) === true ){

					self::$interface = $_SESSION[ self::$config['name'] ]['interface'];

				}
				else{

					self::$interface = self::$config['interface'];
					$_SESSION[ self::$config['name'] ]['interface'] = self::$interface;

				}

			}

		}
		else{

			self::$interface = self::$config['interface'];

			$_SESSION[ self::$config['name'] ]['interface'] = self::$interface;

		}

		$dir = self::$config['dirs']['interfaces'] . '/' . self::$interface;


		// TODO Возможно лучше в другое место вынести.
		self::$interface_path = $dir;

		if( is_dir( $dir ) == false ){

			throw new Exception('The application interface is not found in the path "' . $dir . '".');

		}


	}


	/**
	 * Методы для работы со списками.
	 * Список - обёртка для плоского набора данных "Списковые значения".
	 *
	 * @deprecated
	 */
	static public function get_list($name){

		$name = mb_strtolower($name);

		if( $name == 'логическое' ){
			$arr = [];
			$arr[0] = 'Нет';
			$arr[1] = 'Да';
		}
		elseif( $name == 'типы файлов' ) {
			$arr = [];
			$arr['php'] = '.php';
			$arr['html'] = '.html';
		}
		elseif( $name == 'состояние' ) {
			$arr = [];
			$arr[0] = 'Выключено';
			$arr[1] = 'Включено';
		}

		return $arr;
	}



	/**
	 * Обработка SEF (Search Engines Friendly URL).
	 *
	 * Два взаимодополняющих метода поиска страницы или сервиса.
	 *
	 * 1. Поиск по таблице sef_url.
	 * 2. Поиск по таблице sef.
	 *
	 * Метод анализирует полученный параметр $_REQUEST['_route'],
	 * разбирает его и выносит в ключи $_REQUEST.
	 * По sef определяется страница или сервис.
	 *
	 * Если есть ключ _route в $_REQUEST но ничего не найдено, тогда 404.
	 *
	 * @deprecated
	 * @return boolean
	 *
	 */
	static public function route_handler( &$error404 = false, &$route_record = null ){

		if( self::$pre_initialized == false ){
			throw new Exception('The minimum application initialization has not been performed. Call app::pre_init().');
		}



		$exists = false;

		if( array_key_exists( '_route', $_REQUEST ) == false )
			return false;

		// TODO Проверка набора символов.
		// Ограничить длину.
		$path = substr($_REQUEST['_route'],0,300);

		$path = trim($path, '/');

		$path = mb_strtolower($path);




		//
		// BEGIN
		//

		if( count( app::$config['routes'] ) > 0 ){

			foreach( app::$config['routes'] as $route ){

				$route['url'] = trim( $route['url'], '/' );
				$route['url'] = mb_strtolower( $route['url'] );

				//	echo $path;

				if( $path == $route['url'] ){
					//		print_r($route);

					if( is_array( $route['data'] ) == true ){

						foreach( $route['data'] as $key => $value ){

							$_REQUEST[ $key ] = $value;

						}

					}

					$route_record = $route;

					$exists = true;

					break;

				}


			}

		}

		//
		// END
		//


		if( $exists == true ){

			return $exists;

		}


		app::init_db();




		// Если не была произведена полная инициализация приложения.
		//	if( self::$initialized == false ){
		//		$error404 = true;
		//		return false;
		//	}


		//
		// BEGIN Поиск по таблице sef_url.
		//


		$path = '^/?' . preg_quote( $path ). '/?$';

		$sql = 'SELECT * FROM ?_url WHERE url RLIKE ? AND app = ? AND remove_ts = 0 AND active = 1 LIMIT 1';

		$row = app::$db->selrow($sql, $path, app::$config['name']);

		/*
				print_r($row);
				print_r( app::$db->queries );
				exit;
		*/

		if( $row != null ){

			$row['data'] = @unserialize($row['data']);

			if( is_array( $row['data'] ) == true ){
				foreach( $row['data'] as $key => $value ){
					$_REQUEST[ $key ] = $value;
				}
			}


			// Доп. установить.
			//$_REQUEST['page_id'] = intval( $row['page_id'] );
			//$_REQUEST['record_id'] = intval( $row['record_id'] );
			//$_REQUEST['dataset_id'] = intval( $row['dataset_id'] );

			//		print_r($_REQUEST);
			//		exit;

			$exists = true;
		}

		//
		// END Поиск по таблице sef_url.
		//


		// Пришлось добавить, так как происходит переопределение страницы.
		// Например: страница settings.php имеет адрес /profile/settings и имеется правило разбора "@^profile/([^/]*)/?$@i" для страница profile.php,
		// которое забирает на себя всё.

		if( $exists == true ){
			return true;
		}


		//
		// BEGIN Поиск по таблице sef.
		//

		if( self::$config['cache_engine'] == 'redis' || self::$config['session_engine'] == 'redis' ){

			require_once( self::$kernel_dir . '/modules/cache/redis.php');

		}
		else {

			require_once( self::$kernel_dir . '/modules/cache/bw_cache.php');

		}



		$key = self::$config['name'] . '/sef_list';
		$sef_list = cache::get( $key );

		if( $sef_list == false ){

			$sql = 'SELECT * FROM ?_url_patterns WHERE application = ? AND remove_ts = ?d AND active = ?d ORDER BY weight DESC';

			$sef_list = app::$db->sel(
				$sql,
				self::$config['name'],
				0,
				true
			);
			// TODO Проверить
			//	cache::set( $key, $sef_list );
		}

		// Путём перебора и сопоставления, определить страницу или сервис.
		if( is_array( $sef_list ) == true ){
			foreach( $sef_list as $sef ){

				$matches = [];

				if( @preg_match( $sef['regexp'], $_REQUEST['_route'], $matches ) == true ){

					//
					// BEGIN Установка соответствий.
					//

					$sef['matches'] = unserialize( $sef['matches'] );

					if( is_array( $sef['matches'] ) == true ){

						foreach( $sef['matches'] as $index => $key ){

							if( array_key_exists( $index, $matches ) == true ){

								$_REQUEST[ $key ] = $matches[ $index ];

							}

						}

					}

					//
					// END Установка соответствий.
					//


					//
					// BEGIN Установка дополнительных данных.
					//

					$sef['data'] = unserialize( $sef['data'] );

					if( is_array( $sef['data'] ) == true ){

						foreach( $sef['data'] as $key => $value ){

							$_REQUEST[ $key ] = $value;

						}

					}

					//
					// END Установка дополнительных данных.
					//

					$exists = true;

					break;

				}

			}
		}

		//
		// END Поиск по таблице sef.
		//



		if( $exists == false ){

			$error404 = true;

		}

		return $exists;

	}




	/**
	 * Метод для работы с настройками, которые хранятся в наборе "Настройки".
	 * Позвращает значение указанного параметра.
	 *
	 * @param str $opt Название настройки.
	 * @return str Значение.
	 * @deprecated
	 */
	static public function get_option($opt){
		$value = self::$db->selrow('SELECT value FROM ?_settings WHERE opt=?', $opt);
		return $value['value'];
	}


	/**
	 *
	 *
	 * @param $name
	 * @param string $application
	 * @return null
	 */
	static public function get_option2( $name, $application = null ){

		if( $application == null ){
			$application = app::$name;
		}

		$sql = 'SELECT ov.*, o.view FROM option_value ov LEFT JOIN option o ON (o.id = ov.option_id) WHERE o.name = ? AND ov.application = ?';

		$option = app::$db->selrow( $sql, $name, $application );

		$value = null;

		if( $option != null ){

			// $value = $option['default_value'];


			if( $option['view'] == 2 || $option['view'] == 3 || $option['view'] == 4 ){

				$value = unserialize( $option['value'] );

			}
			else {

				$value = $option['value'];

			}



		}

		return $value;

	}


	static public function set_option2( $name, $value, $application = null ){


		$value = (string) $value;

		if( $application == null ){
			$application = app::$name;
		}

		$sql = 'SELECT ov.* FROM option_value ov LEFT JOIN option o ON (o.id = ov.option_id) WHERE o.name = ? AND ov.application = ?';

		$option = app::$db->selrow( $sql, $name, $application );

		if( $option != null ){

			$upd_data = [];
			$upd_data['value'] = $value;

			$sql = 'UPDATE option_value SET ?l WHERE id = ?d';
			app::$db->q( $sql, $upd_data, $option['id'] );


		}

	}




	/**
	 * Записать новое значение параметра.
	 *
	 * @param str $opt Название настройки.
	 * @param str $val Значение.
	 * @deprecated
	 */
	static public function set_option($opt, $val){
		self::$db->q('UPDATE ?_settings SET value=? WHERE opt=?', $val, $opt);
	}





	static public function include_service( $service_name, $app_name = '' ){

		if( is_servicename( $service_name ) == false ){

			throw new exception( 'Incorrect service name. ' . $service_name );

		}

		if( $app_name == '' ){

			$app_name = app::$config['name'];

		}

		$config = app::get_config( $app_name );


		$exists = false;

		$service_file = $service_name . '.php';

		foreach( $config['services'] as $key => $item ){

			if( is_string( $item ) == true ){

				if( $item == $service_name ){

					$exists = true;

					break;

				}

			}
			else if( is_array( $item ) == true ) {

				if( $item['name'] == $service_name ){

					if( array_key_exists( 'file', $item ) == true ){

						$service_file = $item['file'];

					}

					$exists = true;

					break;

				}

			}

		}




		if( $exists == true ){

			$service_path = $config['dirs']['services'] . '/' . $service_file;


			if( is_file( $service_path ) == true ){

				require( $service_path );

			}
			else {

				throw new ExceptionHTTP(404);

			}

		}
		else {

			throw new ExceptionHTTP(404);

		}

	}




	static public function get_service( $service_name, $app_name = null, $config = null ){

		if( $app_name == null ){

			$app_name = self::$name;

		}

		if( is_array( $config ) == true ){

			$current_config = $config;

		}
		else {

			$current_config = self::get_config( $app_name );

		}

		$service_file = null;

		$service_path = null;

		$service_module = null;

		$service_application = $app_name;

		$exists = false;


		foreach( $current_config['services'] as $key => $item ){

			// deprecated
			if( is_string( $item ) == true ){

				if( $item == $service_name ){

					$service_file = $item . '.php';

					$exists = true;

					break;

				}

			}
			else if( is_array( $item ) == true ) {

				if( $item['name'] == $service_name ){

					if( array_key_exists( 'file', $item ) == true ){

						$service_file = $item['file'];

					}

					if( array_key_exists( 'application', $item ) == true ){

						$service_application = $item['application'];

					}


					if( array_key_exists( 'module', $item ) == true ){

						$service_module = $item['module'];

					}

					$exists = true;

					break;

				}

			}

		}



		if( $exists == true ){

			$config = self::get_config( $service_application );

			if( $service_module !== null ){

				$module = self::get_module( $service_module, $service_application );

				$service_path = rtrim( $module->dir, '/' ) . '/' . ltrim( $service_file, '/' );


			}
			else {

				$service_path = rtrim( $config['dirs']['services'], '/' ) . '/' . ltrim( $service_file, '/' );

			}

		}


		if( is_file( $service_path ) == false ){

			$service_path = null;

		}

		return $service_path;










		if( is_servicename( $service_name ) == false ){

			throw new exception( 'Incorrect service name. ' . $service_name );

		}

		if( $app_name == '' ){

			$app_name = app::$config['name'];

		}

		$config = app::get_config( $app_name );


		$exists = false;

		$service_file = $service_name . '.php';

		foreach( $config['services'] as $key => $item ){

			if( is_string( $item ) == true ){

				if( $item == $service_name ){

					$exists = true;

					break;

				}

			}
			else if( is_array( $item ) == true ) {

				if( $item['name'] == $service_name ){

					if( array_key_exists( 'file', $item ) == true ){

						$service_file = $item['file'];

					}

					$exists = true;

					break;

				}

			}

		}




		if( $exists == true ){

			$service_path = $config['dirs']['services'] . '/' . $service_file;


			if( is_file( $service_path ) == true ){

				require( $service_path );

			}
			else {

				throw new ExceptionHTTP(404);

			}

		}
		else {

			throw new ExceptionHTTP(404);

		}























	}



	/**
	 * Метод возвращает объект страницы.
	 *
	 * @param str $name Название (идентификатор) страницы.
	 * @return Page Возвращает объект или null.
	 */
	static public function get_page( $id, $app_name = null ){

		$page = null;

		$row = null;

		if( preg_match( '/^\d+$/', $id ) == true ){

			$sql = 'SELECT id FROM pages WHERE id = ?d';
			$row = app::$db->select_row_cache( $sql, $id );

		}
		else {

			if( $app_name == null ){

				$app_name = self::$name;

			}

			$sql = 'SELECT id FROM pages WHERE name = ? AND app = ?';
			$row = app::$db->select_row_cache( $sql, $id, $app_name );

		}

		if( $row != null ){

			if( in_array( $row['id'], self::$pages ) === true ) {

				$page = self::$pages[ $row['id'] ];

			}
			else {

				$page = new Page( $row['id'] );

				self::$pages[ $page->id ] = $page;

			}

		}

		return $page;


	}



	static public function get_pages( $where = [], $order = [], $page_number = 1, $limit = 0, $use_cache = false ){

		$list = [];

		$sql = 'SELECT * FROM pages';
		$sql.= ' ' . app::$db->prepare_where( $where );
		$sql.= ' ' . app::$db->prepare_order( $order );
		$sql.= ' ' . app::$db->prepare_limit( $page_number, $limit );

		if( $use_cache == true ){
			$records = app::$db->select_cache( $sql );
		}
		else {
			$records = app::$db->select( $sql );
		}


		if( is_array( $records ) == true ){

			foreach( $records as $record ){

				$page = new Page();
				$page->set_data( $record );

				$list[] = $page;

			}

		}



		return $list;

	}




	/**
	 * Метод возвращает массив с именами сервисов указанного приложения.
	 */
	static public function get_services( $app_name = '' ){
		$arr = [];

		if( self::exists( $app_name, $config ) == true ){
			$dir = $config['dirs']['services'];

			if( is_dir( $dir ) == true ){

				$files = get_dir( $dir );

				$files = $files['files'];

				foreach( $files as $file ){
					$path_parts = pathinfo( $dir . '/' . $file );

					if( is_servicename( $path_parts['filename'] ) == true ){
						$arr[] = $path_parts['filename'];
					}
				}
			}
		}

		return $arr;
	}



	static public function service_exists( $service_name, $app_name = '' ){

		if( $app_name == '' ){

			$app_name = app::$config['name'];

		}

		$config = app::get_config( $app_name );

		$service_file = $config['dirs']['services'] . '/' . $service_name . '.php';

		if( is_file( $service_file ) == true ){

			return true;

		}

		return false;

	}





	/**
	 * Для переходов между действиями используется redirect, с которым
	 * можно передать ключ KEY.
	 *
	 * // action 'save'
	 *
	 * $key = randstr(5); // Xd4rg
	 *
	 * // Проверить, чтобы злоумышленник не переполнил буфер.
	 * app::check_buffer();
	 *
	 * $_SESSION['buffer'][ $key ]['message'] = 'Все изменения сохранены.';
	 *
	 * redirect('http://www.site.ru/?action=edit&_key=' . $key);
	 *
	 * // action 'edit'
	 *
	 * $data = app::get_transit_data();
	 *
	 * if( $data != null )
	 * 		echo $data['message']; // Все изменения сохранены.
	 *
	 * Где KEY = randstr(5);
	 *
	 * Для передачи данных и сообщений между действиями, используется
	 * переменная $_SESSION['buffer'][ KEY ].
	 *
	 * После прочтения, данные уничтожаются из сессии.
	 */
	static public function get_transit_data( $clear = true ){
		$ext_key = get_str('_key');

		$data = null;

		if( preg_match('/^[a-z0-9]{5}$/i', $ext_key) == true && isset( $_SESSION['buffer'][$ext_key] ) == true ){
			$data = $_SESSION['buffer'][$ext_key];
			if( $clear == true )
				unset($_SESSION['buffer'][$ext_key]);
		}

		return $data;
	}

	/**
	 * Возвращает текущий ключ.
	 */
	static public function get_transit_key(){
		$ext_key = get_str('_key');
		$key = null;
		if( is_key( $ext_key, 5 ) == true ){
			$key = $ext_key;
		}
		return $key;
	}


	/**
	 * Метод для проверки существования переданных данных.
	 * @return bool
	 */
	static public function exists_transit_data( &$data = null ){
		$ext_key = get_str('_key');
		$exists = false;
		if( is_key( $ext_key, 5 ) == true && isset( $_SESSION['buffer'][$ext_key] ) == true ){
			$data = app::get_transit_data(false);
			$exists = true;
		}
		return $exists;
	}


	/**
	 * Метод кладёт транзитные данные в ключ.
	 *
	 * @return str $key
	 */
	static public function set_transit_data( $data = [] ){

		app::check_buffer();

		$key = randstr(5);

		$_SESSION['buffer'][$key] = $data;

		return $key;
	}


	/**
	 * Проверить, чтобы злоумышленник не переполнил буфер.
	 * Если данные будут накапливаться, это значит, что
	 * происходит ошибка или кто-то очень старается навредить.
	 *
	 * @todo Очищать от последнего элемента.
	 */
	static public function check_buffer($limit = 3){
		if( count( $_SESSION['buffer'] ) > $limit )
			unset( $_SESSION['buffer'] );
	}


	static public function cons($var){
		error_log( var_export( $var, true ) );
	}


	/**
	 * @param string $url
	 * @param int $weight Порядок, по умолчанию 0. Чем выше порядок, тем первее идёт скрипт/стиль.
	 */
	static public function add_style( $url = '', $weight = 0, $group = 'default', $anticache = true ){

		self::$styles[ $group ][ $url ] = [ $url, $weight, $anticache ];

	}


	/**
	 * @param string $url
	 *      URL к скрипту
	 * @param int $weight
	 *      Приоритет (целое число)
	 * @param bool $wait
	 *      Параметр для $LAB. Если true - блокирующая загрузка, то есть будет дописан .wait(), false - не блокирующая загрузка.
	 */
	static public function add_script( $url = '', $weight = 0, $wait = false, $group = 'default', $anticache = true ){

		self::$scripts[ $group ][ $url ] = [ $url, $weight, $wait, $anticache ];

	}


	/**
	 *
	 * @param $url
	 */
	static public function remove_script( $url ){

		$result = false;

		$url = (string) $url;

		$url = preg_replace( '/^' . preg_quote( self::$url, '/' ) . '/isum', '', $url );

		$url = trim( $url, '/' );

		foreach( self::$scripts as $a => $group ){

			foreach( $group as $b => $item ){

				$item[0] = preg_replace( '/^' . preg_quote( self::$url, '/' ) . '/isum', '', $item[0] );

				if( trim( $item[0], '/' ) === $url ){

					unset( self::$scripts[ $a ][ $b ] );

					$result = true;

				}

			}

		}

		return $result;

	}


	/**
	 * @param $url
	 */
	static public function remove_style( $url ){

		$result = false;

		$url = (string) $url;

		$url = preg_replace( '/^' . preg_quote( self::$url, '/' ) . '/isum', '', $url );

		$url = trim( $url, '/' );

		foreach( self::$styles as $a => $group ){

			foreach( $group as $b => $item ){

				$item[0] = preg_replace( '/^' . preg_quote( self::$url, '/' ) . '/isum', '', $item[0] );

				if( trim( $item[0], '/' ) === $url ){

					unset( self::$styles[ $a ][ $b ] );

					$result = true;

				}

			}

		}

		return $result;

	}


	static public function detach_script( $url ){

		return self::remove_script( $url );

	}


	static public function detach_style( $url ){

		return self::remove_style( $url );

	}


	/**
	 * Иногда нужно получить адрес страницы или записи набора, не создавая при этом соответственного объекта.
	 * URL данной страницы.
	 * @todo Добавить параметр, который будет добавлять ? или ?&, если ссылка ЧПУ. Чтобы не получилось ситуации
	 *
	 * echo app::$page->get_url() . '&par=val';
	 *
	 * /path/to/page/&par=val - ОШИБКА
	 *
	 * /path/to/page/?par=val - ПРАВИЛЬНО
	 *
	 * /index.php?_page=name&par=val - ПРАВИЛЬНО
	 *
	 * См. также page_generate_url();
	 *
	 */
	static public function prepare_url( $params = [], $with_host = true ){

		$url = '';

		if( array_key_exists( 'page_id', $params ) == true ){

			$sql = 'SELECT * FROM ?_pages WHERE id = ?d';
			/*
			$sql = app::$db->prepare_sql( $sql, $params['page_id'] );

			$cache_id = md5( $sql );

			$page = cache::get( $cache_id );

			if( $page === false ){

				$page = app::$db->selrow( $sql );

				cache::set( $cache_id, $page );

			}
			*/


			//$page = app::$db->select_row( $sql, $params['page_id'] );

			$page = app::$db->select_row_cache( $sql, $params['page_id'] );


			if( $page != null ){

				app::exists( $page['app'], $config );

				if( count( $config ) == 0 ){

					return null;

				}


				//echo  $page['app'];
				//	print_r($config);
				//	exit;

				$url = url_add_params( $config['controller_url'], [ '_page' => $page['name'] ] );

				if( $page['url_id'] > 0 ){

					//$sef_url = app::$db->selrow('SELECT * FROM ?_url WHERE id = ?d', $page['url_id']);

					// !!! Не срабатывает кэщ.
					$sef_url = app::$db->select_row_cache('SELECT * FROM ?_url WHERE id = ?d', $page['url_id']);


					// $url = $config['domain'] . '/' . $sef_url['url'];


					if( $sef_url['url'] != '' ) {

						if ( $with_host == true ) {
							$url = rtrim($config['root_url'], '/') . '/' . ltrim($sef_url['url'], '/');
						}
						else {
							$url = '/' . ltrim($sef_url['url'], '/');
						}

						

					}


				}



				// TODO для id
				if( array_key_exists( 'name', $config['default_page'] ) == true ){

					if( $config['default_page']['type'] == 'page' && $config['default_page']['name'] == $page['name'] ){
						$url = $config['root_url'];
					}

				}
				else if( ( $config['default_page'][0] == 'name' && $config['default_page'][1] == $page['name'] )
					|| ( $config['default_page'][0] == 'id' && $config['default_page'][1] == $page['id'] ) ){


					$url = $config['root_url'];

				}


			}

		}
		else if( array_key_exists( 'dataset_id', $params ) == true ){


		}

		return $url;

	}

	static public function is_dev_server(){

		return ( DEV_IP == $_SERVER['SERVER_ADDR'] );

	}


	/**
	 * Метод возвращает объект блока.
	 *
	 *
	 * @param str $name Название (идентификатор) блока.
	 * @return obj Возвращает объект или null.
	 *
	 */
	static public function get_block( $id, $app_name = null ){

		$block = null;

		$row = null;

		if( preg_match( '/^\d+$/', $id ) == true ){

			$sql = 'SELECT * FROM blocks WHERE id = ?d';
			$row = app::$db->select_row_cache( $sql, $id );

		}
		else {


			if( $app_name == null ){

				$app_name = self::$name;

			}

			$sql = 'SELECT * FROM blocks WHERE name = ? AND app = ?';
			$row = app::$db->select_row_cache( $sql, $id, $app_name );

		}

		if( $row != null ){

			$block = new Block( $row['id'] );

		}

		return $block;

	}




	/**
	 * @param $id Числовой или строковый идентификатор.
	 * @param array $params
	 * @param string $app Если указан строковый идентификатор, а он может быть не уникальным в отличии от числового,
	 * для уточнения можно указать ещё и приложение.
	 */
	static public function include_block( $id, $params = [], $app_name = null ){

		$html = '';

		$block = self::get_block( $id, $app_name );


		if( $block != null ){

			$block->data = $params;
			$html = $block->get_html();

		}


		return $html;

	}


	static public function add_handler( $event, $callback = null, $priority = 0 ){

		return self::add_event_listener( $event, $callback, $priority );

	}

	/**
	 * $priority
	 */
	static public function add_event_listener( $event, $callback = null, $priority = 0 ){

		if( is_array( $event ) == true ){

			$listener = [];

			if( array_key_exists( 'name', $event ) == true ){
			}

			if( array_key_exists( 'module', $event ) == true ){
			}

			if( array_key_exists( 'application', $event ) == false ){
				$event['application'] = app::$name;
			}


			$hash = $event['application'] . '/' . $event['module'] . '/' . $event['name'];

			$listener['application'] = $event['application'];
			$listener['module'] = $event['module'];
			$listener['name'] = $event['name'];
			$listener['priority'] = $priority;
			$listener['callback'] = $callback;

			self::$event_listeners[ $hash ][] = $listener;

		}
		else {

			$listener = [];

			$hash = $event;

			$listener['priority'] = $priority;
			$listener['callback'] = $callback;

			self::$event_listeners[ $hash ][] = $listener;

		}


	}


	/**
	 * @param array $event
	 *      name
	 *      module
	 *      application
	 */
	static public function raise_event( $event = null, &$params = null ){

		$hash = '';

		if( is_array( $event ) == true ){
			if( array_key_exists( 'name', $event ) == true ){
			}

			if( array_key_exists( 'module', $event ) == true ){
			}

			if( array_key_exists( 'application', $event ) == false ){
				$event['application'] = self::$name;
			}

			$hash = $event['application'] . '/' . $event['module'] . '/' . $event['name'];

		}
		else {

			$hash = $event;

		}



		if( array_key_exists( $hash, self::$event_listeners ) == true ){

			// TODO Учитывать приоритет.
			foreach( self::$event_listeners[ $hash ] as $listener ){

				// TODO Учитывать разные виды колбэков
				if( is_callable( $listener['callback'] ) == true ){

					$params['_listener'] = $listener;

					$params = call_user_func( $listener['callback'], $params );


					//$listener['callback']( $event, $params );
				}

			}

		}

	}

	/**
	 * Роутинг на основании данных из конфига.
	 *
	 * @return array
	 * @throws Exception
	 */
	// TODO route_rules
	static public function primary_routing(){

		if( self::$pre_initialized == false ){

			throw new Exception('The primary application initialization has not been performed. Call app::primary_init().');

		}


		$route = [];
		$route['status'] = 0;

		// TODO Проверка набора символов.
		// TODO Ограничить длину.
		if( array_key_exists( '_route', $_REQUEST ) == true ) {

			// mb_substr
			$path = substr( $_REQUEST['_route'], 0, 300 );

			$path = trim( $path, '/' );

			if( self::$config['route_case_sensivity'] == false ){

				$path = mb_strtolower( $path );

			}

		}



		if( array_key_exists( '_page', $_REQUEST ) == true ){

			$route = [];
 			$route['type'] = 'page';
			$route['status'] = 200;
			$route['data']['_page'] = $_REQUEST['_page'];

			return $route;

		}
		else if( array_key_exists( '_service', $_REQUEST ) == true ){

			$route = [];
			$route['type'] = 'service';
			$route['data']['_service'] = $_REQUEST['_service'];
			$route['status'] = 200;

			// 17.07.2016 Переход на $config['service']
			/*
			if( self::service_exists( $_REQUEST['_service'] ) == true ){

				if( in_array( $_REQUEST['_service'], self::$config['allowed_services'] ) == true ){

					$route['status'] = 200;

				}
				else {

					$route['status'] = 403;

				}

			}
			else {

				$route['status'] = 404;

			}
			*/

			return $route;
		}
		else if( array_key_exists( '_controller', $_REQUEST ) == true ){

			// TODO
			$route = [];
			$route['type'] = 'controller';
			$route['data']['_controller'] = $_REQUEST['_controller'];

			if( array_key_exists( '_application', $_REQUEST ) == true ){
				$route['data']['_application'] = $_REQUEST['_controller'];
			}

			if( array_key_exists( '_module', $_REQUEST ) == true ){
				$route['data']['_module'] = $_REQUEST['_module'];
			}

			$route['status'] = 200;


			return $route;

		}
		// Страница, контроллер или сервис по умолчанию.
		else if( array_key_exists( '_route', $_REQUEST ) == false || $path == '' ) {

			$route = [];
			$route['status'] = 0;

			if( array_key_exists( 'type', self::$config['default_page'] ) == true ){

				$route['status'] = 200;

				$route['type'] = self::$config['default_page']['type'];

				if( $route['type'] == 'controller' ){
					$route['data']['_controller'] = self::$config['default_page']['name'];
					$route['data']['_module'] = self::$config['default_page']['module'];
				}
				else if( $route['type'] == 'service' ){
					$route['data']['_service'] = self::$config['default_page']['name'];

				}
				else {
					$route['data']['_page'] = self::$config['default_page']['name'];
				}

				foreach( $route['data'] as $key => $value ){
					$_REQUEST[ $key ] = $value;
					$_POST[ $key ] = $value;
					$_GET[ $key ] = $value;
				}

			}
			// Старый способ обращения.
			else {

				$route['type'] = 'page';
				$route['data']['_page'] = self::$config['default_page'][1];
				$route['status'] = 200;

				$_REQUEST['_page'] = self::$config['default_page'][1];
				$_POST['_page'] = self::$config['default_page'][1];
				$_GET['_page'] = self::$config['default_page'][1];

			}


			return $route;

		}


	//	print_r($_REQUEST);print_r($route);exit;


		/*

		if( array_key_exists( '_route', $_REQUEST ) == false && array_key_exists( '_route', $_REQUEST ) == false && $path == '' ) {

			return $route;

		}
		*/




		//
		// BEGIN Роутинг адресов из конфига.
		//



		if( is_array( self::$config['routes'] ) == true ){

			foreach( self::$config['routes'] as $route_record ){

				$route_record['url'] = trim( $route_record['url'], '/' );

				if( self::$config['route_case_sensivity'] == false ){

					$route_record['url'] = mb_strtolower( $route_record['url'] );

				}

				//echo $path;
				//echo $route_record['url'];

				if( $path == $route_record['url'] ){

					//print_r($route_record);
					//exit;

					foreach( $route_record as $key => $value ){
						$route[ $key ] = $value;
					}

					if( is_array( $route_record['data'] ) == true ){

						foreach( $route_record['data'] as $key => $value ){

							$_REQUEST[ $key ] = $value;

						}

					}


					//print_r($route);
					//exit;

					if( array_key_exists( '_page', $route['data'] ) == true ){

						$route['type'] = 'page';

						$route['status'] = 200;

					}
					else if( array_key_exists( '_service', $route['data'] ) == true ){

						$route['type'] = 'service';
						$route['status'] = 200;

						// TODO 200, 403

						// TODO В разных форматах.


						/*

						if( in_array( $route['_service'], self::$config['allowed_services'] ) == true ){

							$route['status'] = 200;

						}
						else {

							$route['status'] = 403;

						}
						*/

					}
					else if( array_key_exists( '_controller', $route['data'] ) == true ){

						$route['type'] = 'controller';

						$controller = $route['data']['_controller'];

						$application = '';

						if( array_key_exists( '_application', $route['data'] ) == true ){
							$application = $route['data']['_application'];
						}

						$module = '';

						if( array_key_exists( '_module', $route['data'] ) == true ){
							$module = $route['data']['_module'];
						}

						$allowed = false;

						// deprecated
						/*
						if( is_array( self::$config['allowed_controllers'] ) == true ) {

							foreach ( self::$config['allowed_controllers'] as $item ) {

								if ( is_array($item) == true ) {

									if ( count($item) == 3 && $module != '' && $controller != '' && $application != '' ) {
										if ( $item[0] === $controller && $item[1] === $module && $item[2] === $application ) {
											$allowed = true;
											break;
										}
									}
									else if ( count($item) == 2 && $module != '' && $controller != '' ) {
										if ( $item[0] === $controller && $item[1] === $module ) {
											$allowed = true;
											break;
										}
									}
									else {
										if ( $item[0] === $controller ) {
											$allowed = true;
											break;
										}
									}

								}
								else {

									// TODO as string

								}

							}

						}
						*/




						if( is_array( self::$config['controllers'] ) == true ) {

							foreach ( self::$config['controllers'] as $item ) {

								if ( is_array( $item ) == true ) {

									$controller = (string) $controller;
									$module = (string) $module;
									$application = (string) $application;

									$item['name'] = (string) $item['name'];
									$item['module'] = (string) $item['module'];
									$item['application'] = (string) $item['application'];

									if( $item['name'] === $controller ){

										if( $item['module'] != '' && $item['application'] != '' ){

											if( $item['module'] === $module && $item['application'] === $application ){

												$allowed = true;

											}

										}
										else if( $item['module'] != '' && $item['application'] == '' ){

											if( $item['module'] === $module ){

												$allowed = true;

											}

										}
										else if( $item['module'] == '' && $item['application'] != '' ){

											if( $item['application'] === $application ){

												$allowed = true;

											}

										}



									}


								}
								else {

									// TODO as string

								}

							}

						}








						if( $allowed == true ){

							$route['status'] = 200;

						}
						else {

							$route['status'] = 403;

						}


						//print_r($route);
						//exit;


					}
					else {

						$route['status'] = 404;

					}





					break;

				}


			}

		}


		//
		// END Роутинг адресов из конфига.
		//



		//
		// BEGIN Роутинг правил из конфига.
		//

		if( is_array( self::$config['routes_rules'] ) == true ){

			foreach( self::$config['routes_rules'] as $rule ){

				$matches = [];



				if( @preg_match( $rule['regexp'], $_REQUEST['_route'], $matches ) == true ){

					//
					// BEGIN Установка соответствий.
					//

					if( is_array( $rule['matches'] ) == true ){

						foreach( $rule['matches'] as $index => $key ){

							if( array_key_exists( $index, $matches ) == true ){

								$_REQUEST[ $key ] = $matches[ $index ];

							}

						}

					}

					//
					// END Установка соответствий.
					//




					//
					// BEGIN Установка дополнительных данных.
					//

					if( is_array( $rule['data'] ) == true ){

						foreach( $rule['data'] as $key => $value ){

							$_REQUEST[ $key ] = $value;

						}

					}

					//
					// END Установка дополнительных данных.
					//



					break;

				}


			}


		}


		//
		// END Роутинг правил из конфига.
		//


	///	print_r($_REQUEST);print_r($route);exit;

		//
		// BEGIN Роутинг адресов из модулей.
		//


		$routes = [];

		if( is_array( app::$config['import_routes'] ) == true ) {

			foreach (app::$config['import_routes'] as $record) {

				$name = '';
				$route_file = '';

				if ( is_array($record) == true ) {

				}
				else {

					$name = $record;

					$route_file = self::$config['dirs']['modules'] . '/' . $name . '/.metadata/routes.php';

				}

				if ( is_file( $route_file ) == true ) {

					require_once( $route_file );


					if( is_array( $routes ) == true ){

						foreach( $routes as $route_item ){

							self::$config['routes'][] = $route_item;

						}

					}

				}

			}

		}



		if( is_array( $routes ) == true ){

			// TODO Проверка набора символов.
			// TODO Ограничить длину.
		//	$path = substr($_REQUEST['_route'],0,300);

		//	$path = trim($path, '/');

		//	$path = mb_strtolower($path);


			foreach( $routes as $route_record ){

				$route_record['url'] = trim( $route_record['url'], '/' );

				if( self::$config['route_case_sensivity'] == false ){

					$route_record['url'] = mb_strtolower( $route_record['url'] );

				}




				//echo $path;
				//exit;
				//echo $route_record['url'];

				if( $path == $route_record['url'] ){

					//print_r($route_record);
					//exit;

					foreach( $route_record as $key => $value ){
						$route[ $key ] = $value;
					}

					if( is_array( $route_record['data'] ) == true ){

						foreach( $route_record['data'] as $key => $value ){

							$_REQUEST[ $key ] = $value;

						}

					}


					//print_r($route);
					//exit;

					if( array_key_exists( '_page', $route['data'] ) == true ){

						$route['type'] = 'page';

						$route['status'] = 200;

					}
					else if( array_key_exists( '_service', $route['data'] ) == true ){

						$route['type'] = 'service';
						$route['status'] = 200;

						// TODO 200, 403

						// TODO В разных форматах.


						/*

						if( in_array( $route['_service'], self::$config['allowed_services'] ) == true ){

							$route['status'] = 200;

						}
						else {

							$route['status'] = 403;

						}
						*/

					}
					else if( array_key_exists( '_controller', $route['data'] ) == true ){

						$route['type'] = 'controller';

						$controller = $route['data']['_controller'];

						$application = '';

						if( array_key_exists( '_application', $route['data'] ) == true ){

							$application = $route['data']['_application'];

						}

						$module = '';

						if( array_key_exists( '_module', $route['data'] ) == true ){

							$module = $route['data']['_module'];

						}

						$allowed = false;

						foreach( self::$config['controllers'] as $item ){

							if( is_array( $item ) == true ){

								if( $item['name'] == $route['data']['_controller'] ){

									$allowed = true;

								}

								/*

								if( count( $item ) == 3 && $module != '' && $controller != '' && $application != '' ){
									if( $item[0] === $controller && $item[1] === $module && $item[2] === $application ){
										$allowed = true;
										break;
									}
								}
								else if( count( $item ) == 2 && $module != '' && $controller != '' ){
									if( $item[0] === $controller && $item[1] === $module ){
										$allowed = true;
										break;
									}
								}
								else {
									if( $item[0] === $controller ){
										$allowed = true;
										break;
									}
								}

								*/
							}
							else {

								// TODO as string

							}

						}



						if( $allowed == true ){

							$route['status'] = 200;

						}
						else {

							$route['status'] = 403;

						}


						//print_r($route);
						//exit;


					}
					else {

						$route['status'] = 404;

					}





					break;

				}


			}

		}



//		print_r($route);
//		exit;


		//
		// END Роутинг адресов из модулей.
		//


		//
		// BEGIN Роутинг правил из модулей.
		//


		$rules = [];

		if( is_array( app::$config['import_routes_rules'] ) == true ) {

			foreach (app::$config['import_routes_rules'] as $record) {

				$name = '';
				$file = '';

				if (is_array($record) == true) {

				}
				else {
					$name = $record;
					$file = self::$config['dirs']['modules'] . '/' . $name . '/.metadata/routes.php';
				}

				if (is_file($file) == true) {
					//require_once( $path );
					require($file);

				}

			}

		}





		foreach( $rules as $rule ){


			$matches = [];


			if( @preg_match( $rule['regexp'], $path, $matches ) == true ){



				//
				// BEGIN Установка соответствий.
				//

				if( is_array( $rule['matches'] ) == true ){

					foreach( $rule['matches'] as $index => $key ){

						if( array_key_exists( $index, $matches ) == true ){

							$_REQUEST[ $key ] = $matches[ $index ];

						}

					}

				}

				//
				// END Установка соответствий.
				//




				//
				// BEGIN Установка дополнительных данных.
				//

				if( is_array( $rule['data'] ) == true ){

					foreach( $rule['data'] as $key => $value ){

						$_REQUEST[ $key ] = $value;

					}

				}

				//
				// END Установка дополнительных данных.
				//


				break;

			}



		}



		$route = [];
		$route['status'] = 0;

		if( array_key_exists( '_page', $_REQUEST ) == true ){

			$route['type'] = 'page';
			$route['status'] = 200;
			$route['data']['_page'] = $_REQUEST['_page'];

			return $route;
		}
		else if( array_key_exists( '_service', $_REQUEST ) == true ){
			$route['type'] = 'service';

			// TODO 200, 403

			// TODO В разных форматах.

			$route['data']['_service'] = $_REQUEST['_service'];

			$route['status'] = 200;
			/*
			if( in_array( $_REQUEST['_service'], self::$config['allowed_services'] ) == true ){

				$route['status'] = 200;

			}
			else {

				$route['status'] = 403;

			}
			*/


			return $route;
		}
		else if( array_key_exists( '_controller', $_REQUEST ) == true ){
			// TODO

			$route['type'] = 'controller';
			$route['data']['_controller'] = $_REQUEST['_controller'];

			if( array_key_exists( '_application', $_REQUEST ) == true ){

				$route['data']['_application'] = $_REQUEST['_controller'];

			}

			if( array_key_exists( '_module', $_REQUEST ) == true ){

				$route['data']['_module'] = $_REQUEST['_module'];

			}

			$route['status'] = 200;

//			print_r($route);exit;

			return $route;

		}




		//
		// END Роутинг правил из модулей.
		//




		//		echo $path;
//		print_r($routes);
		//		print_R($_REQUEST);exit;
//		print_r($route);
//		exit;


		return $route;


	}


	/**
	 * Роутинг на основании данных из БД.
	 *
	 * @return array
	 */
	static public function secondary_routing(){


		// TODO Проверка полной инициализации.
		//if( self::$pre_initialized == false ){
		//	throw new Exception('The primary application initialization has not been performed. Call app::primary_init().');
		//}

		$route = [];
		$route['status'] = 0;



		if( array_key_exists( '_route', $_REQUEST ) == false ) {

			return $route;

		}



		// TODO Проверка набора символов.
		// TODO Ограничить длину.
		$path = substr($_REQUEST['_route'],0,300);

		$path2 = $path;

		$path = trim($path, '/');

		$path = mb_strtolower($path);

		//
		// BEGIN Поиск по таблице url.
		//


		$path = '^/?' . preg_quote( $path ). '/?$';
		$hash = md5( trim( mb_strtolower( $path2 ), '/' ) );

		// TODO убрать RLIKE
//		$sql = 'SELECT * FROM ?_url WHERE ( url RLIKE ? OR hash = ? ) AND app = ? AND remove_ts = 0 AND active = 1 LIMIT 1';
//		$row = app::$db->selrow($sql, $path, $hash, app::$config['name']);

		$sql = 'SELECT * FROM ?_url WHERE app = ? AND hash = ? AND remove_ts = 0 AND active = 1 LIMIT 1';
		$row = app::$db->selrow($sql, app::$config['name'], $hash );



		//		print_r($row);
		//		print_r( app::$db->queries );
		//		exit;



		if( $row != null ){

			$row['data'] = @unserialize($row['data']);

			foreach( $row as $key => $value ){
				$route[ $key ] = $value;
			}


			if( is_array( $row['data'] ) == true ){
				foreach( $row['data'] as $key => $value ){
					$_REQUEST[ $key ] = $value;
				}
			}


			if( array_key_exists( '_page', $route['data'] ) == true ){

				$route['type'] = 'page';

				$route['status'] = 200;

			}
			else if( array_key_exists( '_service', $route['data'] ) == true ){

				$route['type'] = 'service';

				// TODO 200, 403

				// TODO В разных форматах.

				$exists = false;

				foreach( self::$config['services'] as $item ){

					if( is_array( $item ) == true ){

						if( $row['data']['_service'] == $item['name'] ){

							$exists = true;
							break;

						}

					}
					else if( is_string( $item ) == true ) {

						if( $row['data']['_service'] == $item ){

							$exists = true;
							break;

						}

					}

				}


				if( $exists === true ){

					$route['status'] = 200;

				}
				else {

					$route['status'] = 403;

				}



			}
			else if( array_key_exists( '_controller', $route['data'] ) == true ){

				$route['type'] = 'controller';
				$route['status'] = 200;
				// TODO 200, 403
				// TODO В разных форматах.

			}
			else {

				$route['status'] = 404;

			}


			// Доп. установить.
			//$_REQUEST['page_id'] = intval( $row['page_id'] );
			//$_REQUEST['record_id'] = intval( $row['record_id'] );
			//$_REQUEST['dataset_id'] = intval( $row['dataset_id'] );

			//		print_r($_REQUEST);
			//		exit;

			return $route;

			//$exists = true;
		}

		//
		// END Поиск по таблице url.
		//


		// Пришлось добавить, так как происходит переопределение страницы.
		// Например: страница settings.php имеет адрес /profile/settings и имеется правило разбора "@^profile/([^/]*)/?$@i" для страница profile.php,
		// которое забирает на себя всё.

		//if( $exists == true ){
		//	return true;
		//}


		//
		// BEGIN Поиск по таблице sef.
		//

		//if( self::$config['cache_type'] == 'redis' || self::$config['session_type'] == 'redis' ){
		//	require_once( self::$kernel_dir . '/modules/cache/redis.php');
		//}
		//else {
		//	require_once( self::$kernel_dir . '/modules/cache/bw_cache.php');
		//}



		//$key = self::$config['name'] . '/sef_list';
		//$sef_list = cache::get( $key );

		//if( $sef_list == false ){

		$sql = 'SELECT * FROM ?_url_patterns WHERE application = ? AND remove_ts = ?d AND active = ?d ORDER BY weight DESC';

		$sef_list = app::$db->sel(
			$sql,
			self::$config['name'],
			0,
			true
		);
		// TODO Проверить
		//	cache::set( $key, $sef_list );
		//}

		// Путём перебора и сопоставления, определить страницу или сервис.
		if( is_array( $sef_list ) == true ){
			foreach( $sef_list as $sef ){

				//print_r($sef);

				$matches = [];

				if( @preg_match( $sef['regexp'], $_REQUEST['_route'], $matches ) == true ){


					//
					// BEGIN Установка соответствий.
					//

					$sef['matches'] = unserialize( $sef['matches'] );

					if( is_array( $sef['matches'] ) == true ){

						foreach( $sef['matches'] as $index => $key ){

							if( array_key_exists( $index, $matches ) == true ){

								$_REQUEST[ $key ] = $matches[ $index ];

							}

						}

					}

					//
					// END Установка соответствий.
					//


					//
					// BEGIN Установка дополнительных данных.
					//

					$sef['data'] = unserialize( $sef['data'] );

					$route['data'] = $sef['data'];

					if( is_array( $sef['data'] ) == true ){

						foreach( $sef['data'] as $key => $value ){

							$_REQUEST[ $key ] = $value;

						}

					}

					//
					// END Установка дополнительных данных.
					//






					if( array_key_exists( '_page', $route['data'] ) == true ){

						$route['type'] = 'page';

						$route['status'] = 200;

					}
					else if( array_key_exists( '_service', $route['data'] ) == true ){

						$route['type'] = 'service';

						// TODO 200, 403

						// TODO В разных форматах.

						if( in_array( $route['data']['_service'], self::$config['allowed_services'] ) == true ){

							$route['status'] = 200;

						}
						else {

							$route['status'] = 403;

						}

					}
					else if( array_key_exists( '_controller', $route['data'] ) == true ){

						$route['type'] = 'controller';

						// TODO 200, 403
						// TODO В разных форматах.

					}
					else {

						$route['status'] = 404;

					}



					break;
					//return $route;


				}

			}
		}

		//
		// END Поиск по таблице sef.
		//


		if( $route['status'] == 0 && array_key_exists( '_route', $_REQUEST ) == true ){
			$route['status'] = 404;
		}


		//if( $exists == false )
		//	$error404 = true;

		return $route;


	}


	static public function get_content_type( $id ){

		$sql = 'SELECT * FROM content_type WHERE id = ?d';

		$type = app::$db->selrow( $sql, $id );

		return $type;

	}

	static public function check_content_type( $id, $application = null, &$type = null ){

		if( $application == null ){
			$application = app::$name;
		}

		$sql = 'SELECT * FROM content_type WHERE application = ?d AND id = ?d';

		$type = app::$db->selrow( $sql, $application, $id );

		if( $type != null ){
			return true;
		}
		else {
			return false;
		}

	}

	static public function get_all_content_type(){

		$sql = 'SELECT * FROM content_type';
		$records = app::$db->sel( $sql );

		$list = [];

		if( is_array( $records ) == true ){
			foreach( $records as $record ){
				$list[ $record['application'] ][ $record['id'] ] = $record;
			}
		}

		return $list;

	}

	static public function save_tags( $tags = [], $page_id = 0, $dataset_id = 0, $record_type = 0, $record_id = 0 ){



		if( $page_id > 0 ){


			$sql = 'SELECT * FROM tag_record WHERE page_id = ?d';

			$records = app::$db->sel( $sql, $page_id );

			// Установленные для страницы теги.
			$tag_list = [];

			if( $records != null ){

				foreach( $records as $record ){

					$tag_list[] = $record['tag_id'];

				}

			}


			// Пропустить уже существующие теги.
			foreach( $tag_list as $i => $tag_id ){

				if( array_key_exists( $tag_id, $tags ) == true ){

					unset( $tags[ $tag_id ] );

					unset( $tag_list[ $i ] );

				}

			}



			// Теги, которые необходимо удалить.
			if( count( $tag_list ) > 0 ){

				$sql = 'DELETE FROM tag_record WHERE page_id = ?d AND tag_id IN (?a)';
				app::$db->q( $sql, $page_id, $tag_list );

				foreach( $tag_list as $tag_id ){

					try {
						app::$db->q( 'UPDATE tag SET cnt = cnt - 1 WHERE id = ?d', $tag_id );
					}
					catch( Exception $e ){

					}

				}

			}





			if( count( $tags ) > 0 ){


				$sql = 'INSERT INTO tag_record (page_id,tag_id) VALUES';

				$sql_values = [];

				foreach( $tags as $tag_id ){

					$sql_values[] = app::$db->prepare_sql( '( ?d, ?d )', $page_id, $tag_id );

					app::$db->q( 'UPDATE tag SET cnt = cnt + 1 WHERE id = ?d', $tag_id );

				}

				if( count( $sql_values ) > 0 ){

					$sql.= implode( ',', $sql_values );

					//		app::cons($sql);

					app::$db->q( $sql );

				}

			}




		}



	}

	static public function get_interface_description( $interface_name, $app_name = null ){

		$config = app::get_config( $app_name );

		$description_file = $config['dirs']['interfaces'] . '/' . $interface_name . '/.metadata/description.php';

		$description = [];

		if( is_file( $description_file ) == true ){

			require( $description_file );

		}

		return $description;

	}

	static public function generate_code( $name ){
		$code = class_rus::translit( $name );

		//$code = preg_replace('/[^\wА-Яа-яЁё\-]/i', '', $code);
		$code = preg_replace('/[^A-Za-zА-Яа-яЁё0-9\-]/usmi', '', $code);

		$code = preg_replace('/\-+/i', '-', $code);
		$code = mb_strtolower( $code );

		return $code;
	}




	static public function load_dictionary( $dictionary_name, $language = null ){

		if( $language == null ){

			$language = self::$language;

		}

		if( array_key_exists( $dictionary_name, self::$dictionaries ) == true ){

			$dictionary = self::$dictionaries[ $language ][ $dictionary_name ];

		}
		else {

			$dictionary = new Dictionary( $dictionary_name, $language );

			self::$dictionaries[ $language ][ $dictionary_name ] = $dictionary;

		}

		return $dictionary;

	}


	static public function get_dictionary( $relative_path, $language = null ){

		return self::load_dictionary( $relative_path, $language );

	}


	static public function get_file( $file_id ){

		$sql = 'SELECT * FROM files WHERE id = ?d';
		$file = app::$db->get_record( $sql, $file_id );

		if( $file != null ){

			$config = app::get_config( $file['application'] );

			$file['path'] = rtrim( $config['dirs']['uploads'], '/' ) . '/';

			if( $file['sub_dir'] != '' ){

				$file['path'].= trim( $file['sub_dir'], '/' ) . '/';

			}

			$file['path'].= $file['name'];

		}

		return $file;

	}


	static public function save_file( $source_file, $params = [], $move = true ){

		$file_id = 0;

		$default_params = [
			'destination_dir' => app::$config['dirs']['uploads'],
			'file_name' => md5( randstr( 100 ) ),
			'tmp' => false,
			'uid' => 0,
			'original_name' => '',
			'mime' => null,
			// Для совместимости с $_FILES
			'error' => 0,
			'tmp_name' => '',
			'size' => 0,
			'type' => '',
			'name' => null,
			'sid' => '',
			'application' => app::$name,
			'sub_dir' => '',
		];

		$params = set_params( $default_params, $params );

		if( is_file( $source_file ) == false ){

			return $file_id;

		}

		$destination_dir = $params['destination_dir'];


		if( is_dir( $destination_dir ) == false ){

			mkdir( $destination_dir, 0777, true );

		}


		$file_name = $params['file_name'];

		if( $params['mime'] === null ){

			$params['mime'] = get_mime( $source_file );

		}


		if( $params['uid'] == 0 ){

			$params['sid'] = session::get_session_id();

		}


		$destination_file = rtrim( $destination_dir, '/' ) . '/' . $file_name;


		if( $move == true ){

			//$r = move_uploaded_file( $source_file, $destination_file );
			$r = rename( $source_file, $destination_file );

		}
		else {

			$r = copy( $source_file, $destination_file );

		}


		if( $params['name'] != null ){

			$params['original_name'] = $params['name'];

		}


		if( $params['sub_dir'] != '' ){

			$params['sub_dir'] = trim( $params['sub_dir'], '/' );
			$params['sub_dir'] = trim( $params['sub_dir'] );

		}



		if( is_file( $destination_file ) == true ){


			$sql = 'INSERT INTO files SET ?l';

			$ins_data = [];

			$ins_data['name'] = $file_name;
			$ins_data['create_ts'] = time();
			$ins_data['size'] = filesize( $destination_file );
			$ins_data['uid'] = app::$user->id;
			$ins_data['original_name'] = $params['original_name'];
			$ins_data['mime'] = $params['mime'];
			$ins_data['sid'] = $params['sid'];
			$ins_data['width'] = 0;
			$ins_data['height'] = 0;
			$ins_data['application'] = $params['application'];
			$ins_data['sub_dir'] = $params['sub_dir'];

			list( $type, $sub_type ) = explode( '/', $params['mime'] );

			if( $type == 'image' ){

				$arr = getimagesize( $destination_file );

				if( is_array( $arr ) == true ){

					$ins_data['width'] = $arr[0];
					$ins_data['height'] = $arr[1];

				}

			}


			$file_id = app::$db->insert( $sql, $ins_data );


		}

		return $file_id;

	}


	static public function render( $name = null, $params = [], $return = false ){

		if( $name == null ){

			$name = 'default.php';

		}

		$interface_view = app::$config['dirs']['interfaces'] .  '/' . app::$interface . '/renderers/' . $name;

		// Файл представления.
		if( is_file( $interface_view ) == false ){

			$interface_view = app::$config['dirs']['interfaces'] .  '/' . app::$interface . '/views/' . $name;

		}



		if( is_file( $interface_view ) == false ){
			return;
		}




		// Буферизация вывода.
		// Позволяет в коде писать так echo / print.
		ob_start();

		// Исполнение кода представления (view).
		require_once( $interface_view );

		// Получаем содержимое буфера.
		$content = ob_get_contents();

		// Очистка буфера.
		ob_end_clean();

		if( $return == true ){
			return $content;
		}
		else{
			echo $content;
		}

	}


	/**
	 * @param null $interface_name
	 * @param null $template_name
	 * @param null $app_name
	 * @return array
	 * @throws exception
	 */
	static public function get_interface_blocks( $interface_name = null, $template_name = null, $app_name = null ){

		$arr_blocks = [];


		$sql_where = [];

		/*
		if( $template_name != null ){

			$sql_where[] = app::$db->prepare_sql( 'template = ?', $template_name );

		}

		if( $interface_name != null ){

			$sql_where[] = app::$db->prepare_sql( 'interface = ?', $interface_name );

		}

		if( $app_name != null ){

			$sql_where[] = app::$db->prepare_sql( 'interface = ?', $app_name );

		}
		*/






		$sql = 'SELECT * FROM interface_blocks WHERE app = ? AND interface = ? AND template = ? ORDER BY sort ASC';
		$records = app::$db->select_cache( $sql, $app_name, $interface_name, $template_name );


		if( is_array( $records ) == true ){

			foreach( $records as $record ){

				$block = new Block( $record['bid'] );

				if( $block->active == true ){

					$arr_blocks[ $record['position'] ][ $block->id ] = $block;

				}


			}

		}





		//
		// BEGIN Закэшировать связи страниц и блоков, всех приложений.
		//

		// TODO Кэшировать связи Только текущего приложения!!!

		/*
				$cache_id = 'pages_blocks|' . $this->id;

				$pages_blocks = cache::get( $cache_id );

				if( $pages_blocks === false ){
					$pages_blocks = [];

					$sql = 'SELECT pb.pid, b.id FROM ?_pages_blocks pb';
					$sql.= ' LEFT JOIN ?_blocks b ON b.id = pb.bid';
					$sql.= ' WHERE';
					$sql.= ' b.remove_ts = 0';
					$sql.= ' AND pb.pid = ?d';
					$sql.= ' ORDER BY pb.weight DESC';

					$records = app::$db->sel( $sql, $this->id );

					if( is_array( $records ) == true ) {

						foreach ( $records as $record ) {

							$pages_blocks[ $record['id'] ] = $record;

						}

					}

					unset($records);

					cache::set( $cache_id, $pages_blocks );

				}
				*/

		//
		// END Закэшировать связи страниц и блоков, всех приложений.
		//

		// Найти связи текущей страницы с её блоками.

		//	foreach( $pages_blocks as $block ){
		//foreach( $blocks as $block_id => $name ){

		//			$this->blocks[] = new Block( $block['id'] );

		// TODO Exception.
		//$block = $this->get_block( $name );
		//}
		//	}



		return $arr_blocks;

	}


	/**
	 * См. также prepare_url()
	 *
	 * @param $page_str_id
	 * @param int $parent_id
	 * @return string|void
	 */
	static public function page_generate_url( $page_str_id, $parent_id = 0 ){

		$page_str_id = (string) $page_str_id;
		$parent_id = intval( $parent_id );

		if( $page_str_id == '' ){

			return;

		}


		$sql = 'SELECT * FROM pages WHERE id = ?d';
		$parent = app::$db->selrow( $sql, $parent_id );


		$arr = [];

		if( $parent != null ){

			$sql = 'SELECT id, root_id, left_id, right_id, str_id, synonym FROM pages WHERE root_id = ?d AND left_id <= ?d AND right_id >= ?d ORDER BY left_id ASC';
			$pages = app::$db->sel( $sql, $parent['root_id'], $parent['left_id'], $parent['right_id'] );

			if( is_array( $pages ) == true ){

				foreach( $pages as $page ){

					if( $page['str_id'] != '' ){

						$arr[] = $page['str_id'];

					}
					else if( $page['synonym'] != '' ) {

						$arr[] = self::generate_code( $page['synonym'] );

					}

				}

			}

		}


		if( $page_str_id != '' ) {
			$arr[] = self::generate_code( $page_str_id );
		}

		$url = implode( '/', $arr );

		$url = trim( $url, '/' );

		if( $url != '' ) {
			$url = '/' . $url . '/';
		}

		return $url;

	}




	/**
	 * Метод для запоминания посещения.
	 *
	 * $unique_ts - Интервал уникальности в секунах.
	 * $data - Любые данные.
	 * @todo User Agent
	 *
	 * @return boolean true - посетитель учтён, false - не учтён.
	 */
	static public function save_visit( $record_id, $record_type, $unique_ts = 60, $data = [], $dataset_id = 0 ){

		$arr_type = [
			0 => '',
			1 => 'Article'
		];

		$ts = time();


		$ip = bin2hex( inet_aton( $_SERVER['REMOTE_ADDR'] ) );

		if( $unique_ts > 0 ){

			$sql = 'SELECT id FROM ?_statistics WHERE';

			$sql.= ' ?d - ts <= ?d';
			$sql.= ' AND HEX(ip) = ?';
			$sql.= ' AND record_id = ?d';
			$sql.= ' AND record_type = ?d';
			$sql.= ' AND application = ?';
			$sql.= ' AND sid = ?';


			$visit = app::$db->selrow(
				$sql,
				$ts,
				$unique_ts,
				$ip,
				$record_id,
				$record_type,
				app::$config['name'],
				session_id()
			);

			if( $visit != null ){
				return false;
			}

		}


		$sql = 'INSERT INTO ?_statistics SET';
		$sql.= ' sid = ?,';
		$sql.= ' uid = ?d,';
		$sql.= ' ts = ?d,';
		$sql.= ' ip = UNHEX(?),';
		$sql.= ' record_id = ?d,';
		$sql.= ' record_type = ?d,';
		$sql.= ' data = ?,';
		$sql.= ' application = ?,';
		$sql.= ' user_agent = ?';

		app::$db->ins(
			$sql,
			session_id(),
			app::$user->id,
			$ts,
			$ip,
			$record_id,
			$record_type,
			$data,
			app::$config['name'],
			htmlspecialchars( $_SERVER['HTTP_USER_AGENT'], ENT_QUOTES | ENT_SUBSTITUTE )
		);

		return true;

	}





	static public function stat_check_unique(){

	}





	/**
	 * Метод возвращает кол-во просмотров / уникальных посетителей
	 * в промежутке $begin - $end. Если интервал не задан, то происходит запрос
	 * всех посещений.
	 *
	 * @todo Разделение на хиты и хосты.
	 *
	 * @param array $params
	 *
	 * 		$params['id']
	 * 		$params['type']
	 * 		$params['begin'] Начало интервала.
	 * 		$params['end'] Конец интервала.
	 * 		$params['ip'] Массив с ip адресами.
	 *
	 * @return mixed
	 */
	static public function stat_get_count( $params = [] ){


		$params['id'] = intval( $params['id'] );
		$params['type'] = intval( $params['type'] );
		$params['begin'] = intval( $params['begin'] );
		$params['end'] = intval( $params['end'] );


		$where = [];

		$sql = 'SELECT COUNT(id) AS `count` FROM ?_statistics WHERE ';

		$where[] = 'application = "' . app::$config['name'] . '"';

		$where[] = 'record_id = ' . $params['id'];
		$where[] = 'record_type = ' . $params['type'];

		if( $params['begin'] > 0 && $params['end'] > 0 ){

			$where[] = '( ' . $params['begin'] . ' >= ts AND ' . $params['end'] . ' <= ts )';

		}else if( $params['begin'] > 0 && $params['end'] == 0 ){

			$where[] = $params['begin'] . ' >= ts';

		}else if( $params['begin'] == 0 && $params['end'] > 0 ){

			$where[] = $params['end'] . ' <= ts';

		}

		$sql.= implode( ' AND ', $where );



		$row = app::$db->selrow($sql);

		$row['count'] = intval( $row['count'] );

		return $row['count'];

	}


	/**
	 * При создании кэша ($merge == true) все js файлы объединяются.
	 * Если файл не на домене или не удалось его найти на сервере, то он не попадает в кэш,
	 * но подключается как отдельный файл.
	 *
	 * $min - Минимизировать кэшированный-файл с помощью YUI Compressor.
	 *
	 */
	static public function prepare_scripts( $scripts = [], $merge = false, $min = false, &$arr_url = [] ){

		$html = '';


		if( count($scripts) == 0 ){
			return;
		}

		$scripts = _sort( $scripts, 'desc', 1 );


		if( $merge == false ){

			$arr_url = $scripts;

			foreach( $scripts as $script ){

				$url = $script[0];

				$parsed_url = parse_url( $url );

				$current_host = true;


				if( array_key_exists( 'host', $parsed_url ) == true ){

					if( $parsed_url['host'] != self::$config['domain'] ){

						$current_host = false;

					}

				}


				if( $script[3] === true && $current_host == true ){

					$script[0] = $parsed_url['path'];

					$url = $script[0];

					$file = rtrim( app::$dirs['document_root'], '/' ) . '/' . ltrim( $script[0], '/' );

					if( is_file( $file ) == true ){

						$ts = filemtime( $file );

					}


					// TODO url_add_params
					$url.= '?' . $ts;

				}



				$html.= '<script src="' . $url . '" type="text/javascript"></script>' . "\n";
				//		$arr_url[] = $script[0];
			}

		}
		else{

			$str = '';

			$included_scripts = [];
			$excluded_scripts = [];

			foreach( $scripts as $script ){

				$str.= $script[0];

				$url_parts = parse_url( $script[0] );

				if( $url_parts != false ){

					// print_r($url_parts);

					if( array_key_exists( 'host', $url_parts ) == true ){

						/*
						echo self::$url . ' == ' . $url_parts['scheme'] . '//' . $url_parts['host'];
						print_r($url_parts);
						exit;
						*/

						if( self::$config['domain'] == $url_parts['host'] ){

							$file = self::$config['document_root'] . $url_parts['path'];

							if( is_file( $file ) == true ){
								// Включить содержимое файла в кэщ.
								$included_scripts[] = $url_parts['path'];
							}
							else{
								// Файл не найден, поэтому ссылку на него подключить отдельно.
								$excluded_scripts[] = $script[0];
							}

						}
						else{
							// Файл не найден, поэтому ссылку на него подключить отдельно.
							$excluded_scripts[] = $script[0];
						}

						//echo self::$url;

						//echo $url_parts['host'];

						//exit;


					}
					else{

						$file = self::$config['document_root'] . $url_parts['path'];

						//	echo $file . '<br>';

						if( is_file( $file ) == true ){
							// Включить содержимое файла в кэщ.
							$included_scripts[] = $url_parts['path'];
						}
						else{
							// Файл не найден, поэтому ссылку на него подключить отдельно.
							$excluded_scripts[] = $script[0];
						}

					}

				}

			}

			$md5 = md5($str);

			$dir = self::$config['dirs']['pubcache'];

			if( is_dir( $dir ) == false ){
				mkdir( $dir, 0755, true );
			}

			$file = $dir . '/' . $md5 . '.js';
			$min_file = $dir . '/' . $md5 . '.min.js';

			if( $min == true ){
				$url = self::$config['internals_url'] . '/pubcache/' . $md5 . '.min.js';
			}
			else{
				$url = self::$config['internals_url'] . '/pubcache/' . $md5 . '.js';
			}


			$real_file = '';

			if( is_file( $file ) == false ){

				$content = '';

				//print_r($included_scripts);
				//	exit;

				foreach( $included_scripts as $script ){

					$path = self::$config['document_root'] . $script;

					$content.= '//' . "\n";
					$content.= '// BEGIN ' . $script . "\n";
					$content.= '//' . "\n";
					$content.= "\n";

					$content.= read_file( $path );

					$content.= "\n";
					$content.= "\n";
					$content.= '//' . "\n";
					$content.= '// END ' . $script . "\n";
					$content.= '//' . "\n";
					$content.= "\n";
					$content.= "\n";


				}

				//print_R($excluded_scripts);
				//exit;

				write_file( $file, $content );


				if( $min == true ){

					if( self::$config['js_compressor_type'] == 'jsmin' ){

						require_once( self::$kernel_dir . '/other/jsmin.php' );

						$content = JSMin::minify( $content );

						//$content = preg_replace('/(\r?\n)+/','',$content);

						write_file( $min_file, $content );

					}
					else {

						// TODO YUI не удаляет комментарии с восклицательным знаком, пофиксить.
						$cmd = preg_replace(
							[
								'/\{source\}/i',
								'/\{destination\}/i'
							],
							[
								$file,
								$min_file
							],
							self::$config['yui_js_compressor']
						);

						exec( $cmd );

					}




					$real_file = $min_file;


					// Чтобы врагам не досталось.
					// TODO Вынести в конфиг, в раздел безопасности.
					write_file( $file, '' );

					//error_log('Hello');


				}
				else {


					$real_file = $file;

				}


			}
			else {

				$real_file = $file;

			}


			$ts = filemtime( $real_file );

			// TODO url_add_params
			$url.= '?' . $ts;






			$arr_url = [];

			$html = '<script src="' . $url . '" type="text/javascript"></script>' . "\n";

			$arr_url[] = [ $url, 0, false ];

			foreach( $excluded_scripts as $script ){
				$html.= '<script src="' . $script . '" type="text/javascript"></script>' . "\n";
				$arr_url[] = [ $script, 0, false ];
			}


			/*
			foreach( $included_scripts as $script ){
				$arr_url[] = $script;
			}

			foreach( $excluded_scripts as $script ){
				$arr_url[] = $script;
			}
*/


			// exit;

		}



		return $html;

	}


	static public function prepare_styles( $styles = [], $merge = false, $min = false ){

		$html = '';

		if( count($styles) == 0 ){
			return;
		}


		$styles = _sort( $styles, 'desc', 1 );


		if( $merge == false ){

			foreach( $styles as $style ){

				$url = $style[0];


				$parsed_url = parse_url( $url );

				$current_host = true;


				if( array_key_exists( 'host', $parsed_url ) == true ){

					if( $parsed_url['host'] != self::$config['domain'] ){

						$current_host = false;

					}

				}


				if( $style[2] === true && $current_host == true ){

					$style[0] = $parsed_url['path'];
					$url = $style[0];

					$file = rtrim( app::$dirs['document_root'], '/' ) . '/' . ltrim( $style[0], '/' );

					if( is_file( $file ) == true ){

						$ts = filemtime( $file );

					}


					// TODO url_add_params
					$url.= '?' . $ts;

				}

				$html.= '<link href="' . $url . '" type="text/css" rel="stylesheet" />' . "\n";

			}


		}
		else{


			$str = '';

			$included_styles = [];
			$excluded_styles = [];



			foreach( $styles as $style ){

				$str.= $style[0];

				$url_parts = parse_url( $style[0] );



				if( $url_parts != false ){

					//					print_r($url_parts);

					if( array_key_exists( 'host', $url_parts ) == true ){

						/*
						echo self::$url . ' == ' . $url_parts['scheme'] . '//' . $url_parts['host'];
						print_r($url_parts);
						exit;
						*/

						//echo self::$config['domain'] . '==' . $url_parts['host'] . '<br>';

						// if( self::$url == $url_parts['scheme'] . '://' . $url_parts['host'] ){
						if( self::$config['domain'] == $url_parts['host'] ){

							$file = self::$config['document_root'] . $url_parts['path'];

							if( is_file( $file ) == true ){
								// Включить содержимое файла в кэш.
								$included_styles[] = $url_parts['path'];
							}
							else{
								// Файл не найден, поэтому ссылку на него подключить отдельно.
								$excluded_styles[] = $style[0];
							}



						}
						else{
							// Файл не найден, поэтому ссылку на него подключить отдельно.
							$excluded_styles[] = $style[0];
						}

					}
					else {

						$file = self::$config['dirs']['document_root'] . $url_parts['path'];


						if( is_file( $file ) == true ){
							// Включить содержимое файла в кэщ.
							$included_styles[] = $url_parts['path'];

						}
						else{
							// Файл не найден, поэтому ссылку на него подключить отдельно.
							$excluded_styles[] = $style[0];
							// TODO trigger_error
						}



					}

				}

			}





			$md5 = md5( $str );

			$dir = self::$config['dirs']['pubcache'];

			if( is_dir( $dir ) == false ){
				mkdir( $dir, 0755, true );
			}

			$file = $dir . '/' . $md5 . '.css';
			$min_file = $dir . '/' . $md5 . '.min.css';

			if( $min == true ){
				$url = self::$config['internals_url'] . '/pubcache/' . $md5 . '.min.css';
			}
			else{
				$url = self::$config['internals_url'] . '/pubcache/' . $md5 . '.css';
			}


			$real_file = '';



			if( is_file( $file ) == false ){

				$content = '';

				foreach( $included_styles as $style ){

					$path = self::$config['document_root'] . $style;

					$content.= '/**' . "\n";
					$content.= ' * BEGIN ' . $style . "\n";
					$content.= ' */' . "\n";
					$content.= "\n";

					//	$content.= self::prepare_style( $path );


					$css_content = read_file( $path );

					$content.= preg_replace_callback('/url\((.*?)\)/s', function( $value ) use( $path ){

						return css_correct_url( $value, $path );

					}, $css_content);


					$content.= "\n";
					$content.= "\n";
					$content.= '/**' . "\n";
					$content.= ' * END ' . $style . "\n";
					$content.= ' */' . "\n";
					$content.= "\n";
					$content.= "\n";


				}



				write_file( $file, $content );

				if( $min == true ){

					if( self::$config['css_compressor_type'] == 'cssmin' ){


						require_once( self::$kernel_dir . '/other/cssmin.php' );

						$content = CssMin::minify( $content );

						// CSSMin не сжимает цвета вида #ffffff в вид #fff.
						// TODO Выяснить, есть ли там опция.
						$content = preg_replace_callback('/#([0-9A-F]{6})/i', 'hex_color', $content);

						//$content = preg_replace('/(\r?\n)+/','',$content);

						write_file( $min_file, $content );



					}
					else {

						$cmd = preg_replace(
							[
								'/\{source\}/i',
								'/\{destination\}/i'
							],
							[
								$file,
								$min_file
							],
							self::$config['yui_css_compressor']
						);

						exec( $cmd );

					}


					$real_file = $min_file;



					//	exit;

					// Чтобы врагам не досталось.
					// TODO Вынести в конфиг, в раздел безопасности.
					write_file( $file, '' );

				}
				else {

					$real_file = $file;

				}

			}
			else {

				$real_file = $file;

			}



			$ts = filemtime( $real_file );
			// TODO url_add_params
			$url.= '?' . $ts;


			$html = '<link rel="stylesheet" type="text/css" href="' . $url . '" />' . "\n";

			foreach( $excluded_styles as $style ){

				$html.= '<link rel="stylesheet" type="text/css" href="' . $style . '" />' . "\n";

			}



		}

		return $html;

	}


	/**
	 * Система версионирования данных.
	 *
	 * Метод добавляет данные в таблицу версий.
	 * Перед добавлением, осуществляет проверку на дублирование, сравнивая текущие данные с последней записью.
	 *
	 * @param $record_type
	 *
	 *      До 10 системные объекты.
	 *
	 *      1 - Страница.
	 *      2 - Набор данных.
	 *      3-10 Зарезервированно.
	 *
	 *
	 *      Пользовательские от >= 11
	 *
	 *
	 * @param $record_id
	 * @param null $data Старые данные
	 * @return mixed
	 */
	static public function revision_add( $params = [], $data = null ){

		$default_params = [
			'record_type' => 0,
			'record_id' => 0,
			'page_id' => 0,
			'dataset_id' => 0,
			'node_id' => 0,
			'user_id' => 0,
			'file' => '',
		];

		$arr_types = [
			'record_type' => '?d',
			'record_id' => '?d',
			'page_id' => '?d',
			'dataset_id' => '?d',
			'node_id' => '?d',
			'user_id' => '?d',
			'md5_hash' => '?',
			'sha1_hash' => '?',
			'file' => '?',
		];

		$params = set_params( $default_params, $params, false );



		//
		// BEGIN Проверка на дублирование по последней записи.
		//

		$str_data = serialize( $data );

		$md5_hash = md5( $str_data );
		$sha1_hash = sha1( $str_data );


		$sql = 'SELECT * FROM revision';

		$sql_where = [];

		$params['md5_hash'] = $md5_hash;
		$params['sha1_hash'] = $sha1_hash;

		foreach( $params as $key => $val ){

			$sql_part = '?t = ' . $arr_types[ $key ];

			if( $key == 'file' ){

				$key = 'file_path_hash';
				$val = md5( $val );

			}

			$sql_where[] = app::$db->prepare_sql( $sql_part, $key, $val );

		}

		$sql.= ' ' . app::$db->prepare_where( $sql_where );
		$sql.= ' ORDER BY ts DESC';
		$sql.= ' LIMIT 1';

		$revision = app::$db->select_row( $sql );

		if( $revision != null ){

			return $revision['id'];

		}

		//
		// END Проверка на дублирование по последней записи.
		//

		app::$db->start();

		try {

			$ins_data = set_params( $default_params, $params );

			if( $ins_data['file'] != '' ){

				$ins_data['file_path_hash'] = md5( $ins_data['file'] );

			}

			$ins_data['ts'] = time();
			$ins_data['md5_hash'] = $md5_hash;
			$ins_data['sha1_hash'] = $sha1_hash;

			$sql = 'INSERT INTO revision SET ?l';

			$id = app::$db->insert( $sql, $ins_data );


			$sql = 'INSERT INTO revision_data SET ?l';

			if( is_array( $data ) == true ){

				foreach( $data as $key => $value ){

					$ins_data = [];
					$ins_data['revision_id'] = $id;
					$ins_data['field_name'] = $key;
					$ins_data['value'] = serialize( $value );

					app::$db->insert( $sql, $ins_data );

				}

			}
			else {

				$ins_data = [];
				$ins_data['revision_id'] = $id;
				$ins_data['field_name'] = '';
				$ins_data['value'] = $str_data;

				app::$db->insert( $sql, $ins_data );

			}


			app::$db->commit();

		}
		catch( Exception $e ){

			app::$db->rollback();

			$id = null;

		}

		return $id;

	}


	/**
	 * Метод возвращает список версий.
	 */
	static public function version_get_list( $record_type, $record_id ){

		$sql = 'SELECT * FROM ?_versioning';
		$sql.= ' WHERE';
		$sql.= ' record_type = ?d';
		$sql.= ' AND record_id = ?d';
		$sql.= ' ORDER BY ts DESC';

		$records = app::$db->sel(
			$sql,
			$record_type,
			$record_id
		);

		if( $records == null ){
			$records = [];
		}

		foreach( $records as $i => $record ){

			$record['data'] = unserialize( $record['data'] );

			$records[ $i ] = $record;

		}


		return $records;

	}


	/**
	 * Метод возвращает одну версию по коду.
	 *
	 * @return mixed
	 *      array Массив с данными версии.
	 *      null Если версии с указанным кодом не существует.
	 */
	static public function revision_get( $id ){

		$sql = 'SELECT * FROM revision WHERE id = ?d';

		$revision = app::$db->select_row( $sql, $id );

		if( $revision != null ){

			$revision['data'] = [];

			$sql = 'SELECT * FROM revision_data WHERE revision_id = ?d';

			$records = app::$db->select( $sql, $revision['id'] );

			if( is_array( $records ) == true ){

				foreach( $records as $record ){

					if( $record['field_name'] == '' ){

						$revision['data'][] = unserialize( $record['value'] );

					}
					else {

						$revision['data'][ $record['field_name'] ] = unserialize( $record['value'] );

					}

				}

			}

		}


		return $revision;

	}

	/**
	 * Обработка очередей.
	 *
	 * TODO Дата старта. То есть если текущая дата меньше стартовой даты, тогда пропустить такую запись.
	 */
	static public function queue_process(){

		$records = self::get(array(
			                     'processed' => false
		                     ));

		if( $records != null ){

			foreach( $records as $record ){
				$start_ts = time();

				//		app::cons($record);
				//		exit;

				$handler = prepare_callback( $record['handler'] );

				try {

					callback( $handler, $record['data'], $result );

					//	error_log( var_export( $result, true ) );

				}
				catch ( exception $e ){

					print_R($record);
					print_r($e);

				}


				// Если не было ошибок.
				if( $result !== false ){

					if( $result == null ){
						$result = [];
					}

					$finish_ts = time();

					$sql = 'UPDATE ?_queue SET';
					$sql.= ' start_ts = ?d,';
					$sql.= ' finish_ts = ?d,';
					$sql.= ' processed = ?d';
					//	$sql.= ' data = ?';
					$sql.= ' WHERE';
					$sql.= ' id = ?d';

					app::$db->q(
						$sql,
						$start_ts,
						$finish_ts,
						true,

						// Очень странно! :( Почему result должен был перезатирать data.
						// serialize( $result ),
						$record['id']
					);

				}

			}

		}


	}

	/**
	 * Метод возвращает список очередей.
	 *
	 * @param array $params
	 * 		$params['id'] - int or int array
	 * 		$params['type'] - int
	 * 		$params['processed'] boolean
	 */
	static public function queue_get($params = []){
		$default_params = [];
		$default_params['id'] = null;
		$default_params['type'] = null;
		$default_params['processed'] = null;

		$params = set_params($default_params, $params);


		$sql = [];
		$where = [];

		if( $params['type'] != null ){
			$where[] = 'type = ' . intval( $params['type'] );
		}

		if( $params['id'] != null ){
			if( is_int($params['id']) == true ){

				$where[] = 'id = ' . intval($params['id']);

			}else if( is_array($params['id']) == true ){

				$id_list = [];

				foreach( $params['id'] as $id ){
					$id = intval($id);
					$id_list[ $id ] = $id;
				}

				$where[] = 'id IN (' . implode(',', $id_list) . ')';

			}
		}


		if( $params['processed'] == true ){
			$where[] = 'processed = 1';
		}else{
			$where[] = 'processed = 0';
		}



		$sql[] = 'SELECT * FROM ?_queue';

		if( count($where) > 0 ){

			$sql[] = 'WHERE';
			$sql[] = implode(' AND ', $where);

		}

		$sql = implode( ' ', $sql );

		$records = app::$db->sel($sql);

		if( is_array( $records ) == true ){
			foreach( $records as $i => $record ){

				$record['data'] = unserialize( $record['data'] );

				$records[ $i ] = $record;

			}
		}


		//	print_r($records);

		return $records;

	}


	/**
	 * Метод создаёт новую очередь.
	 * Очередь обрабатывается универсальным cron-скриптом, который передаёт управления в указанный handler.
	 *
	 * @param array $params
	 *
	 * 		$params['handler'] - функция или метод обработчик в формате [[app/][module_name/]]callback.
	 *
	 * 				app - необязательная часть. Если приложение не указано, то подразумевается текущее приложение.
	 * 				module_name - необязательная часть. Модуль в котором расположен обработчик.
	 * 				callback - функция, метод класса или объекта.
	 *
	 * 				my_module/my_class::static_method
	 *
	 * 		$params['type'] - тип очереди.
	 * 			1 - рассылка писем.
	 *          2 - SMS.
	 * 			N - что угодно.
	 *
	 * 		$params['data']	Любые данные, которые будут сохранятся в базе в сериализованном виде.
	 *
	 *
	 */
	static public function queue_add($params = []){
		$default_params = [];
		$default_params['handler'] = '';
		$default_params['type'] = 0;
		$default_params['data'] = [];

		$params = set_params($default_params, $params);

		$sql = 'INSERT INTO ?_queue SET';
		$sql.= ' create_ts = ?d,';
		$sql.= ' handler = ?,';
		$sql.= ' type = ?,';
		$sql.= ' processed = ?d,';
		$sql.= ' start_ts = ?d,';
		$sql.= ' finish_ts = ?d,';
		$sql.= ' data = ?';

		$queue_id = app::$db->ins(
			$sql,
			time(),
			$params['handler'],
			$params['type'],
			false,
			0,
			0,
			$params['data']
		);



		return $queue_id;

	}





	static public function log_event( $event_id, $event_data = [] ){

		self::log_add( '', $event_id, $event_data  );

	}

	static public function log_add( $event_text = '', $event_id = 0, $event_data = [] ){

		if( $event_text == '' && $event_id == 0 ){
			return false;
		}

		if( $event_id > 0 ){

			if( array_key_exists( $event_id, self::$log_events ) == false ){
				return false;
			}

			if( $event_id == 5 ){
				$event_text = sprintf( self::$log_events[ $event_id ], $event_data['id'] );
			}
			else {
				$event_text = self::$log_events[ $event_id ];
			}

		}

		$ins_data = [];

		$ins_data['user_id'] = app::$user->id;
		$ins_data['ts'] = time();
		$ins_data['ip'] = ip2long( $_SERVER['REMOTE_ADDR'] );
		$ins_data['event_text'] = $event_text;
		$ins_data['event_id'] = $event_id;
		$ins_data['event_data'] = $event_data;

		$sql = 'INSERT INTO log SET ?l';
		app::$db->ins( $sql, $ins_data );

	}


	/**
	 * Метод принимает массив тегами, а возвращает их коды.
	 * По необходимости добавляет теги в базу.
	 */
	static public function get_tags( $ext_tags ){

		$tags = [];

		$hash_list = [];

		if( is_array( $ext_tags ) == true ) {

			foreach ( $ext_tags as $i => $tag ) {

				// Удалить символы с 0-31.
				$tag = preg_replace( '/[\x00-\x1F]/usim', ' ', $tag );

				$tag = preg_replace( '/(\x20)+/usim', ' ', $tag );

				$tag = trim( $tag );

				if( $tag != '' ){

					$hash = md5( mb_strtolower( $tag ) );

					$tags[ $hash ] = [
						'id' => 0,
						'hash' => $hash,
						'name' => $tag
					];

					$hash_list[ $hash ] = $hash;

				}

			}

		}


		if( count( $tags ) > 0 ){

			$sql = 'SELECT * FROM tag WHERE hash IN (?a)';

			app::$db->field_as_key = 'hash';

			$db_tags = app::$db->sel( $sql, $hash_list );

			if( $db_tags == null ){

				$db_tags = [];

			}


			//$sql = 'INSERT INTO tag SET (hash,name) VALUES';

			//$sql_values = [];

			foreach( $tags as $i => $tag ){

				if( array_key_exists( $tag['hash'], $db_tags ) == true ){

					$tag['id'] = $db_tags[ $tag['hash'] ]['id'];

				}


				// TODO убрать отсюда вставку тегов.
				if( $tag['id'] == 0 ){

					$sql = 'INSERT INTO tag SET ?l';

					$ins_data = [];
					$ins_data['hash'] = $tag['hash'];
					$ins_data['name'] = $tag['name'];

					$tag['id'] = app::$db->ins( $sql, $ins_data );

					//$sql_values[] = app::$db->prepare_sql( '(?,?)', $tag['hash'], $tag['name'] );

				}

				$tags[ $i ] = $tag;

			}

		}


		return $tags;

	}






	/**
	 * Класс для хранения ключей и связанных данных.
	 *
	 * Используется для отслеживания ключей:
	 * 	- активации пользователя
	 *  - сброса пароля
	 *  - и прочих операциях, которые требуют подтверждения.
	 *
	 * Метод создаёт ключ.
	 * Данные ключа устанавливаются при вызове этого метода.
	 * @param const $type тип ключа.
	 * @param int $expiry срок действия ключа. По умолчанию 3-ое суток. Если -1, то ключ бессрочный.
	 * @return mixed
	 * 		str $key имя созданного ключа.
	 * 		bool false
	 *
	 * TODO type - изменить на любой символьный код.
	 */
	static public function create_key($data = [], $type = app::KEY_CUSTOM, $expiry = 0){

		$key = randstr(50);

		$ts = time();

		$expiry = intval($expiry);

		// Установить срок действия ключа.
		if( $expiry == 0 )
			$expiry = $ts + app::$default_expiry;

		$sql = 'INSERT INTO `?_keys` SET';
		$sql.= ' `type` = ?d,';
		$sql.= ' `key` = ?,';
		$sql.= ' ts = ?d,';
		$sql.= ' expiry = ?d,';
		$sql.= ' data = ?';

		$id = app::$db->ins($sql, $type, $key, $ts, $expiry, serialize($data));

		if( $id > 0 ){
			return $key;
		}else{
			return false;
		}

	}

	/**
	 * Метод проверяет существование ключа.
	 * @return
	 * 		true - ключ существует.
	 * 		false - ключ не найден.
	 */
	static public function key_exists( $key ){

		$key = (string) $key;

		self::clear();
		$row = app::$db->selrow('SELECT * FROM `?_keys` WHERE `key` = ? AND remove_ts = 0', $key);

		if( empty($row) == false && $row['key'] == $key ){
			return true;
		}

		return false;
	}


	/**
	 * Получить данные ключа.
	 * @param str $key ключ
	 * @param bool $kill
	 * 		true Ключ будет уничтожен после прочтения.
	 * @return mixed
	 * 		arr $data данные ключа.
	 * 		bool false в случае отсутствия ключа в БД.
	 */
	static public function get_key($key, $kill = false){
		self::clear();
		$data = app::$db->selrow('SELECT * FROM `?_keys` WHERE `key` = ? AND remove_ts = 0', $key);
		if( empty($data) === false ){
			$data['data'] = unserialize($data['data']);
			if( $kill == true ){
				self::delete($key);
			}
			return $data;
		}else{
			return false;
		}
	}


	/**
	 * Удалить ключ.
	 */
	static public function delete_key($key){
		// app::$db->q('DELETE FROM `?_keys` WHERE `key` = ?', $key);
		app::$db->q('UPDATE `?_keys` SET remove_ts = ?d WHERE `key` = ?', time(), $key);
	}


	/**
	 * Очистка от просроченных ключей.
	 * Если expiry:
	 * 		-1 ключ бессрочный.
	 */
	static private function clear_key(){
		// Удалить просроченные записи.
		//app::$db->q('DELETE FROM `?_keys` WHERE expiry > -1 AND expiry < ?d', time());

		$ts = time();

		app::$db->q('UPDATE `?_keys` SET remove_ts = ?d WHERE expiry > -1 AND expiry < ?d', $ts, $ts );

	}




	/**
	 * Проверка происходит по IP.
	 *
	 * TODO + По коду пользователя.
	 * TODO Изменить принцип проверки и добавления в бан.
	 *
	 * @param int $type Тип события (Идентификатор). Например идентификатор формы.
	 * @param int $expiry Срок когда будет разблокирован IP-адрес.
	 * @return bool
	 * 		true - проверка успешно пройдена, можно выполнить действие.
	 * 		false - проверка провалена.
	 */
	static public function af_check( $type = 0, &$expiry = 0, $tries = null, $ban_time = null ){

		$forbidden = false;

		$ip = ip2long( $_SERVER['REMOTE_ADDR'] );

		$ts = time();

		//
		// BEGIN Удалить старые блокировки.
		//

		// TODO Записи других пользователей, не должны обрабатываться за счёт текущего пользователя.
		// TODO СДелать обслуживающий скрипт.
		//$sql = 'DELETE FROM ?_antiflood WHERE expiry > 0 AND expiry < ' . time();


		$sql = 'UPDATE ?_antiflood SET remove_ts = ?d WHERE expiry > 0 AND expiry < ?d';

		app::$db->q(
			$sql,
			$ts,
			$ts
		);


		//
		// END Удалить старые блокировки.
		//


		$sql = 'SELECT * FROM ?_antiflood WHERE type = ? AND ip = ?d AND application = ? AND uid = ?d AND remove_ts = ?d';

		$event = app::$db->selrow(
			$sql,
			$type,
			$ip,
			app::$config['name'],
			app::$user->id,
			0
		);


		if( $event == null ){

			$sql = 'INSERT INTO ?_antiflood SET';
			$sql.= ' type = ?,';
			$sql.= ' ts = ?d,';
			$sql.= ' ip = ?d,';
			$sql.= ' counter = 1,';
			$sql.= ' application = ?,';
			$sql.= ' uid = ?d';

			app::$db->ins(
				$sql,
				$type,
				$ts,
				$ip,
				app::$config['name'],
				app::$user->id
			);


		}
		else{

			$expiry = 0;


			if( $tries > 0 ){
				$cnt = $tries;
			}
			else {
				$cnt = self::$af_limits[ $type ]['counter'];
			}


			if( $event['counter'] >= $cnt ){
				/*
				$diff = time() - $event['expiry'];

				if( $diff < 0 ){

					$diff = abs( $diff );

					$per_unit = self::$limits[$type]['time'] / self::$limits[$type]['counter'];

					$r = $diff % $per_unit;

					$full = ( $diff - $r ) / $per_unit;


					if( $r > 0 ){
						$full++;
					}

					if( $full != $event['counter'] ){

						$sql = 'UPDATE ?_antiflood SET';
						$sql.= ' counter = ?d';
						$sql.= ' WHERE type = ?d AND ip = ?d';
						app::$db->q($sql, $full, $type, $ip);


						app::cons( $full );

					}


				}
				*/


				// app::cons( $event['expiry'] - $event['ts'] );

				$forbidden = true;

				if( $event['expiry'] == 0 ){

					//
					// BEGIN Установка срока блокировки.
					//

					// Срок когда будет разблокирован IP.
					if( $ban_time > 0 ){
						$expiry = $ts + $ban_time;
					}
					else {
						$expiry = $ts + self::$af_limits[ $type ]['time'];
					}




					$sql = 'UPDATE ?_antiflood SET';
					$sql.= ' expiry = ?d';
					$sql.= ' WHERE';
					$sql.= ' id = ?d';


					app::$db->q(
						$sql,
						$expiry,
						$event['id']
					);

					//
					// END Установка срока блокировки.
					//

				}
				else{

					$expiry = $event['expiry'];

				}

			}

			//
			// BEGIN Увеличить счётчик, так как блокировка ещё не включена.
			//

			if( $forbidden == false ){

				$sql = 'UPDATE ?_antiflood SET';
				$sql.= ' counter = counter + 1';
				$sql.= ' WHERE';
				$sql.= ' id = ?d';

				app::$db->q(
					$sql,
					$event['id']
				);

			}

			//
			// END Увеличить счётчик, так как блокировка ещё не включена.
			//


		}

		return !$forbidden;

	}


	/**
	 *
	 */
	static public function af_reset($type){
		$ip = ip2long( $_SERVER['REMOTE_ADDR'] );

		$sql = 'SELECT * FROM ?_antiflood WHERE type = ?d AND ip = ?d';
		$event = app::$db->selrow($sql, $type, $ip);

		if( empty($event) === false ){
			$sql = 'UPDATE ?_antiflood SET';
			$sql.= ' expiry = 0,';
			$sql.= ' counter = 0';
			$sql.= ' WHERE type = ?d AND ip = ?d';
			app::$db->q($sql, $type, $ip);
		}
	}


	/**
	 * Метод проверяет находится ли IP адрес в чёрном списке.
	 * @todo Сделать проверку и хранение IP по маске ddd.ddd.ddd.d**
	 * @todo rename to forbidden_ip
	 * @return boolean true / false
	 */
	static public function af_check_ip( $ip = null ){
		if( $ip == null ){
			$ip = $_SERVER['REMOTE_ADDR'];
		}else{
			if( is_ip( $ip ) == false ){
				return false;
			}
		}

		$ip = ip2long( $ip );

		//$sql = 'SELECT * FROM ?_banned_ip WHERE ip = ?d';
		//$result = app::$db->selrow( $sql, $ip );




		$records = cache::get('banned_ip');



		//cache::delete('banned_ip');
		//exit;
		//print_r($records);

		//$v = app::$redis->exists('banned_ip');
		//print_r($v);
		//echo $v;

		if( $records === false ){
			$sql = 'SELECT * FROM banned_ip';
			$records = app::$db->sel( $sql );
			if( is_array( $records ) == false ){
				$records = [];
			}

			cache::set('banned_ip', $records);
			//	$v = app::$redis->exists('banned_ip');
			//echo $v;
		}

		$forbidden = false;


		foreach( $records as $record ){
			if( $record['ip'] == $ip ){
				$forbidden = true;
				break;
			}
		}

		return $forbidden;


	}

	/**
	 * Метод блокирует IP адрес.
	 */
	static public function af_ban_ip( $ip = null, $reason = '' ){

		if( $ip == null ){
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$result = self::af_check_ip( $ip );

		if( $result == false ){
			$ip = ip2long( $ip );

			$sql = 'INSERT INTO ?_banned_ip SET ip = ?d, ts = ?d, reason = ?';

			app::$db->q(
				$sql,
				$ip,
				time(),
				$reason
			);

		}

	}


}

?>