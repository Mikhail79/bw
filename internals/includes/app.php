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

defined('KERNEL_DIR') ?: define( 'KERNEL_DIR', $_SERVER['DOCUMENT_ROOT'] . '/kernel' );

require_once( KERNEL_DIR . '/modules/main/web_application.php' );

class app extends WebApplication {


	/**
	 * Метод для любых завершающих операций.
	 */
	static public function finish(){

		// Закрыть соединение с БД.

		// Записать лог.

	}

	/**
	 * Вызывается каждый раз по завершению скрипта.
	 *
	 * TODO Может быть стоит совместить finish и shutdown.
	 */
	static public function shutdown(){

//		error_log('SHUTDOWN');

		// Для ловли ошибок и исключений, которые нельзя захватить через try-catch
		// Официальная рекомендация от PHP.
		$error = error_get_last();

		if( $error !== null ){

			$arr = [
				E_ERROR,
				E_CORE_ERROR,
				E_USER_ERROR,
				E_COMPILE_ERROR,
				E_RECOVERABLE_ERROR,
				E_PARSE
			];


			if( in_array( $error['type'], $arr, true ) == true ){

				if( app::$config['debug'] == true ) {

					$traces = debug_backtrace();
					print_r($traces);
					print_r($error);

				}
				else {


					// Показать стилизованную страницу Service Temporarily Unavailable.
					require_once( __DIR__ . '/http_pages/503.php' );


				}

			}


		}

	}


	/**
	 *
	 * @param Exception | ExceptionHTTP $exception
	 *
	 *
	 */
	// Было неожиданностью, сюда же попадают объекты типа Error.
	//	static public function exception_handler( Exception $exception ){
	static public function exception_handler( $exception ){

		if( get_class( $exception ) == 'ExceptionHTTP' ){

			if( $exception->getCode() == 404 ){

				require_once( __DIR__ . '/http_pages/404.php');
				exit;

			}
			else if( $exception->getCode() == 403 ){

				require_once( __DIR__ . '/http_pages/403.php' );
				exit;

			}
			else if( $exception->getCode() == 500 ){

				require_once( __DIR__ . '/http_pages/500.php' );
				exit;

			}

		}

		ob_end_clean();

		if( app::$config['debug'] == true ) {

			echo $exception->getMessage();

			print_r($exception->getTrace());

		}
		else {

			error_log($exception->getMessage());

			require_once( __DIR__ . '/http_pages/503.php' );

		}



	}

 
	/**
	 *
	 * @param $name
	 */
	static public function start( $name ){

		// set_error_handler( [ __CLASS__, 'error_handler' ] );

		// Обработчик исключений, которые не попали в try.
		set_exception_handler( [ __CLASS__, 'exception_handler' ] );

		// Функция, которая выполняется после завершения работы скрипта.
		// Используется для ловли исключений и ошибок, которые не попадают в exception_handler.
		register_shutdown_function( [ __CLASS__, 'shutdown' ] );

		// Автоматическая загрузка классов.
		spl_autoload_register( [ __CLASS__, 'autoload' ], true);

		// Проверить существование директорий.
		//self::check_dirs();


		// Первичная (минимальная) инициализация приложения без: БД, сессий, шаблонизатора (Smarty), кэша.
		self::primary_init( $name );

		// Роутинг на основании данных из конфига.
		$route = self::primary_routing();



		if( self::$config['always_full_init'] == true || $route['status'] == 0 || ( $route['status'] == 200 && $route['type'] == 'page' ) ){

			// Вторичная (полная) инициализация приложения.
			self::secondary_init();

		}

		if( $route['status'] == 0 && self::$config['init_subsystems']['db'] == true ){

			// Роутинг на основании данных из БД.
			$route = self::secondary_routing();

		}


/*
		dbm::add_dbo(
			app::$db,
			'master'
		);

		$records = db('master')->select( 'SELECT * FROM users' );
		print_r($records);
		exit;
*/

		//	self::raise_event('after_routing', $route);


//		print_r($_REQUEST);
//		print_r($route);
//		exit;



		self::$data['route'] = $route;



		// TODO Во все методы execute Добавить ExceptionHTTP500, 404, 403


		if( $route['status'] == 200 ){


	//		print_r(get_included_files());
	//		exit;


			if( $route['type'] == 'page' ){

				// Получить объект страницы.
				self::$page = self::get_page( $route['data']['_page'] );

				if( self::$page->active == false ){

					self::$page = null;

				}

				if( self::$page == null ){

					throw new ExceptionHTTP(404);

				}

				// Выполнить программный код страницы.
				self::$page->execute();

				// Отобразить страницу.
				self::render( self::$page->view_file );

			}
			else if( $route['type'] == 'controller' ){

				$controller = self::get_controller2( $route['data']['_controller'], null, self::$config );

				if( $controller == null ){

					throw new ExceptionHTTP(404);

				}

				$controller->execute();

			}
			else if( $route['type'] == 'service' ){

				$service_path = app::get_service( $route['data']['_service'], null, self::$config );

				if( $service_path == null ){

					throw new ExceptionHTTP(404);

				}

				require_once( $service_path );

			}


		}
		else if( $route['status'] == 404 || $route['status'] == 0 ){

			throw new ExceptionHTTP(404);

		}
		else if( $route['status'] == 403 ){

			throw new ExceptionHTTP(403);

		}


		self::finish();

	}


	/**
	 * Для запуска приложения из одиночных скриптов, без роутинга.
	 *
	 * @param $name
	 */
	static public function script_start( $name ){


		// Обработчик исключений, которые не попали в try.
		set_exception_handler( [ __CLASS__, 'exception_handler' ] );

		// Функция, которая выполняется после завершения работы скрипта.
		// Используется для ловли исключений и ошибок, которые не попадают в exception_handler.
		register_shutdown_function( [ __CLASS__, 'shutdown' ] );

		// Автоматическая загрузка классов.
		spl_autoload_register( [ __CLASS__, 'autoload' ], true);

		// Вторичная (полная) инициализация приложения.
		self::secondary_init( $name );


	}


	/**
	 * Для автозагрузки классов.
	 */
	static public function autoload( $class_name ){

		parent::autoload( $class_name );

	}

}





?>