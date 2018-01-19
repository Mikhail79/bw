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

class Module {

	public $name = '';

	protected $meta_dir = '.metadata';

	protected $initialized = false;

	protected $settings_file = '';

	public $description = [];

	/**
	 * @var array Dictionary
	 */
	public $dictionaries = [];

	public $app_name = '';

	// URL к файлам модуля.
	public $url = null;

	public $dir = null;

	// Массив с файлами для переопредления.
	public $files = [];

	// Загруженные состояния.
	protected $loaded_states = [];

	public $params = array(
		'interface' => '',
		'interface_dir' => 'interface'
	);

	public $interface_url = null;

	public $template_dir = null;

	// Для предотвращения зацикливания при обработке зависимостей.
	public $loading = false;

	public function __construct( $module_name, $app_name, $params = null ){

		if( $this->initialized == true )
			return true;

		if( $app_name == 'kernel' ){

			$this->dir = app::$kernel_dir . '/modules/' . $module_name;

		}
		else {

			$config = app::get_config( $app_name );

			$this->dir = $config['dirs']['modules'] . '/' . $module_name;

		}


		$this->name = $module_name;
		$this->app_name = $app_name;

		$description_file = $this->dir . '/' . $this->meta_dir . '/description.php';

		if( is_file($description_file) == true ){

			$default_description = [
				'title' => '',
				'description' => '',
				'author' => '',
				'version' => '',
				// Модуль имеет установщик.
				'install' => true,
				// Модуль имеет деинсталлятор.
				'uninstall' => true,
				// Модуль имеет страницу настроек.
				'settings' => true,
				'settings_file' => $this->meta_dir . '/settings.php',
				'install_file' => $this->meta_dir . '/install.php',
				'uninstall_file' => $this->meta_dir . '/uninstall.php',
			];

			//$module = [];
			$description = [];

			require_once($description_file);
			//$this->description = $module;

			$this->description = set_params( $default_description, $description );

			//$this->description = $description;
			// fix
			//$params['interface_dir'] = $module['config']['dirs']['interface_dir'];
			$params['interface_dir'] = $description['config']['dirs']['interface_dir'];
		}

		if( $this->description['settings'] == true ){
			$this->settings_file = $this->dir . '/settings.php';
		}


		$this->params = set_params( $this->params, $params );


		if( $app_name == 'kernel' ){
			$this->url = app::$kernel_url . '/modules/' . $module_name;
		}else{
			$this->url = $config['internals_url'] . '/modules/' . $module_name;
		}





		//echo $module_name;
		//print_r($config);
		//exit;


		$this->interface_url = $this->url . '/' . $this->params['interface_dir'] . '/' . $this->params['interface'];

		if( $this->params['interface'] != '' ){

			$this->template_dir = $this->dir . '/' . $this->params['interface_dir'] . '/' . $this->params['interface'] . '/templates';

		}
		else {

		//	$this->template_dir = $this->dir . '/' . $this->params['interface_dir'] . '/templates';
			$this->template_dir = $this->dir . '/interface/templates';

		}


		// Загрузка словаря.
//		$dict_file = $this->dir . '/dictionaries/' . app::$language . '/module.php';

//		if( is_file($dict_file) == true ){

//			dict::load_file( $dict_file );

//		}


		$file_list = $this->dir . '/' . $this->meta_dir . '/files.php';

		if( is_file( $file_list ) == true ){

			$files = [];

			require( $file_list );

			$this->files = $files;

		}


		if( array_key_exists( 'overrides', app::$config ) == true ){

			if( array_key_exists( 'modules', app::$config['overrides'] ) == true ){

				if( array_key_exists( $this->name, app::$config['overrides']['modules'] ) == true ){

					foreach( app::$config['overrides']['modules'][ $this->name ] as $key => $value ){

						$this->files[ $key ] = $value;

					}

				}

			}

		}





		$this->initialized = true;

		return true;

	}




	public function load_dictionary( $dictionary_name, $language = null ){

		if( $language == null ){

			$language = app::$language;

		}

		if( array_key_exists( $dictionary_name, $this->dictionaries ) == true ){

			$dictionary = $this->dictionaries[ $language ][ $dictionary_name ];

		}
		else {

			$dictionary = new Dictionary( $dictionary_name, $language, $this->dir . '/dictionaries/' );

			$this->dictionaries[ $language ][ $dictionary_name ] = $dictionary;

		}

		return $dictionary;

	}


	public function get_dictionary( $relative_path, $language = null ){

		return $this->load_dictionary( $relative_path, $language );

	}

	public function t( $text ){

		$translated_text = '';

		foreach( $this->dictionaries as $language => $dictionaries ){

			foreach( $dictionaries as $dictionary ){

				$translated_text = $dictionary->translate( $text );

				if( $translated_text != '' ){

					break 2;

				}

			}

		}

		return $translated_text;

	}


	/**
	 * TODO Зависимости для состояний.
	 */
	public function load_dependencies(){

		$deps_file = $this->dir . '/' . $this->meta_dir . '/deps.php';

		if( is_file( $deps_file ) == true ){

			require_once( $deps_file );

		}

	}

	public function load_state( $state = 'default' ){


		if( in_array( $state, $this->loaded_states ) == true ){

			return true;

		}

		// Чтобы в init и structure можно было обратиться к объекту модуля не только по $this, но и по $module.
		$module = $this;

		//
		// BEGIN Подключить структурный файл.
		//

		if( $state == 'default' ){
			$structure_file = $this->dir . '/' . $this->meta_dir . '/structure.php';
		}
		else {
			$structure_file = $this->dir . '/' . $this->meta_dir . '/structure.' . $state . '.php';
		}

		if( is_file( $structure_file ) == true ){

			$structure = [];

			require_once( $structure_file );

			if( is_array( $structure ) == true ){

				foreach( $structure as $file ){

					$file = $this->dir . '/' . $file;

					require_once( $file );

				}

			}

		}

		//
		// END Подключить структурный файл.
		//

		//
		// BEGIN Подключить файл инициализации.
		//

		if( $state == 'default' ){
			$init_file = $this->dir . '/' . $this->meta_dir . '/init.php';
		}
		else {
			$init_file = $this->dir . '/' . $this->meta_dir . '/init.' . $state . '.php';
		}

		if( is_file( $init_file ) == true ){

			require_once( $init_file );

		}

		//
		// END Подключить файл инициализации.
		//


		$this->loaded_states[] = $state;

	}

	public function get_states(){
		return $this->loaded_states;
	}


	public function install(){

		//
		// BEGIN Стандартная установка: создание таблиц.
		//

		$database_file = $this->dir . '/' . $this->meta_dir . '/database.php';

		if( is_file( $database_file ) == true ) {

			$tables = [];

			require( $database_file );


			if( is_array( $tables ) == true ) {

				foreach ( $tables as $table ) {

					$sql = sql_array_to_scheme($table);
					app::$db->q( $sql );

				}

			}

		}

		//
		// END Стандартная установка: создание таблиц.
		//


		//
		// BEGIN Стандартная установка: создание записи модуля.
		//

		$sql = 'INSERT INTO module SET application = ?, name = ?, installed = 1';
		$module_id = app::$db->ins( $sql, $this->app_name, $this->name );

		//
		// END Стандартная установка: создание записи модуля.
		//


		//
		// BEGIN Стандартная установка: обработка SQL-файла.
		//


		$install_sql_file = $this->dir . '/' . $this->meta_dir . '/install.sql';

		if( is_file( $install_sql_file ) == true ){

			$queries = sql_parser( read_file( $install_sql_file ) );

			if( is_array( $queries ) == true ) {

				foreach ( $queries as $sql ) {

					app::$db->q($sql);

				}

			}

		}

		//
		// END Стандартная установка: обработка SQL-файла.
		//



		//
		// BEGIN Установка разработчика.
		//


		$install_file = $this->dir . '/' . $this->meta_dir . '/install.php';

		$result = false;

		if( is_file( $install_file ) == true ){

			$result = require( $install_file );

		}

		//
		// END Установка разработчика.
		//

		return $result;

	}

	public function uninstall(){

		$install_file = $this->dir . '/' . $this->meta_dir . '/uninstall.php';

		$result = false;

		if( is_file( $install_file ) == true ){

			$result = require( $install_file );

		}

		return $result;

	}


	/**
	 * Метод для вхождения в интерфейс с настройками.
	 *
	 * @TODO Протестировать
	 */
	public function settings($base_url = ''){

		if( $this->initialized == false ){
			throw new exception('The module not initialized.');
		}

		$html = '';

		if( is_file($this->settings_file) == true ){
			// Буферизация вывода.
			// Позволяет в коде писать так echo / print,
			ob_start();
			require( $this->settings_file );
			$html = ob_get_contents();
			// Очистка буфера.
			ob_end_clean();
		}

		return $html;

	}

}

?>