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
 * Блок
 */
class Block {

	/**
	 * Числовой идентификатор.
	 */
//	public $id = 0;


	/**
	 * Текстовый идентификатор.
	 */
//	public $name = '';




	/**
	 * Массив свойств (из БД).
	 */
	public $properties = [];


	/**
	 * Массив для любых транзитных данных.
	 * Например для передачи данных от страницы к блокам.
	 */
	public $data = null;


	/**
	 * Состояние, будет ли content обёрнут в шаблон.
	 */
	public $interface_state = true;



	/**
	 * Признак выполненности.
	 * Используется, когда сущность должна выполнятся только раз.
	 */
//	private $executed = false;


	/**
	 * Список текстов, которые имеются в сущности.
	 * Используется в многоязычности.
	 */
	static public $dictionary = [];

	/**
	 * Признак инициализированности.
	 */
	protected $initialized = false;


//	protected $file = '';

	public $url = '';

	public $dir = '';



	public function __construct( $id = 0 ){


		if( $id > 0 ){

			$this->load( $id );

		}


	}


	protected function load( $id = 0 ){

		$sql = 'SELECT * FROM blocks WHERE id = ?d';
		$row = app::$db->select_row_cache( $sql, $id );

		if( $row != null ){

			$this->properties = $row;

			$config = app::get_config( $this->app );

			$this->dir = dirname( $config['dirs']['blocks'] . '/' . $this->file );

			$this->url = $config['blocks_url'] . '/' . dirname( $this->file );


		}


	}





	/**
	 * Метод инициализации.
	 *
	 * @param string $logical_path Логический путь к блоку.
	 *
	 * application:module/block Блок в указанном приложении, из указанного модуля.
	 * application:block Блок в указанном приложении.
	 * module/block Блок в текущем приложении из указанного модуля.
	 * block Блок в текущем приложении.
	 *
	 */
	public function init( $logical_path, $params = [] ){

		return;

		if( $this->initialized === true )
			return $this->initialized;

		$this->properties = $params;

		$this->id = $data['id'];

//		$this->name = $data['name'];








		if( $this->initialized == true )
			return;

		$this->params = $params;

		$logical_path = (string) $logical_path;

		$app_name = app::$config['name'];
		$module_name = '';
		$block_name = '';

		$matches = [];

		$path = '';



		// application:module/block
		if( preg_match('/^(.+)\:(.+)\/(.+)$/',$logical_path,$matches) == true ){
			$app_name = $matches[1];
			$module_name = $matches[2];
			$block_name = $matches[3];
			$variant = 4;
		}
		// application:block
		elseif( preg_match('/^(.+)\:(.+)$/',$logical_path,$matches) == true ){
			$app_name = $matches[1];
			$block_name = $matches[2];
			$variant = 3;
		}
		// module/block
		elseif( preg_match('/^(.+)\/(.+)$/',$logical_path,$matches) == true ){
			$module_name = $matches[1];
			$block_name = $matches[2];
			$variant = 2;
		}
		// block
		else {
			$block_name = $logical_path;
			$variant = 1;
		}



		$dir = '';
		$dir2 = '';

		$url = '';
		$url2 = '';

		if( $app_name == 'kernel' ){

			app::load_module( $module_name, $app_name );

			$url = app::$kernel_url . '/modules/' . $module_name . '/blocks/';
			$dir = app::$kernel_dir . '/modules/' . $module_name . '/blocks/';
			$path = $dir . $block_name . '.php';

			$url2 = app::$kernel_url . '/modules/' . $module_name . '/blocks/' . $block_name . '/';
			$dir2 = app::$kernel_dir . '/modules/' . $module_name . '/blocks/' . $block_name . '/';
			$path2 = $dir2 . $block_name . '.php';

		}
		else {

			if( app::exists( $app_name, $config ) == false ){
				return;
			}

			if( $variant == 1 || $variant == 3 ){

				$url = $config['modules_url'];
				$dir = $config['dirs']['blocks'] . '/';
				$path = $dir . $block_name . '.php';

				$url2 = $config['modules_url'] . '/' . $block_name . '/';
				$dir2 = $config['dirs']['blocks'] . '/' . $block_name . '/';
				$path2 = $dir2 . $block_name . '.php';

			}
			elseif( $variant == 2 || $variant == 4 ){

				app::load_module( $module_name, $app_name );

				$url = $config['modules_url'] . '/' . $module_name . '/blocks/';
				$dir = $config['dirs']['modules'] . '/' . $module_name . '/blocks/';
				$path = $dir . $block_name . '.php';

				$url2 = $config['modules_url'] . '/' . $module_name . '/blocks/' . $block_name . '/';
				$dir2 = $config['dirs']['modules'] . '/' . $module_name . '/blocks/' . $block_name . '/';
				$path2 = $dir2 . $block_name . '.php';

			}

		}




		/*
		echo 'APP:' . $app_name . '<br />';
		echo 'MOD:' . $module_name . '<br />';
		echo 'BLOCK:' . $block_name . '<br />';
		echo 'VAR:' . $variant . '<br />';
		*/
		//	print_r($config);





		//		echo $path;

		if( is_file( $path ) == true ){
			$this->file = $path;
			$this->dir = $dir;
			$this->url = $url;
			$this->initialized = true;
			//			echo $path;
		}
		elseif( is_file( $path2 ) == true ){
			$this->file = $path2;
			$this->dir = $dir2;
			$this->url = $url2;
			$this->initialized = true;
			//	echo $path2;
		}




		return $this->initialized;








	}




	public function get_html(){

		return $this->execute();

	}


	/**
	 * Метод выполняющий код блока.
	 *
	 * Используйте в теле сервиса echo/print, если
	 * нужно вывести HTML и прочие строки.
	 *
	 */
	public function execute(){

		$config = app::get_config( $this->app );

		$file = $config['dirs']['blocks'] . '/' . $this->file;


		ob_start();

		if( is_file( $file ) == true ){

		//	$params = $this->params;

			$params = $this->data;


			require( $file );

		}
		else {

			throw new exception('The block file not found in "' . $file . '".');

		}

		$content = ob_get_contents();

		ob_end_clean();


	//	$content = '<div style="border:red solid 1px;">' . $content . '</div>';

		return $content;




		/*

		// Получить содержимое блока.
		$block_file = app::$config['dirs']['blocks'] . '/' . $this->properties['file'] . '.' . $this->properties['store'];

		if( is_file( $block_file ) === true ){
			if( $this->properties['store'] == 'html' ){
				$this->content = read_file($block_file);
			}else if($this->properties['store'] == 'php'){
				// Буферизация вывода.
				// Позволяет в коде писать так echo / print,
				// вместо $this->content = ''.
				ob_start();
				// Исполнение кода php-блока.
				require_once($block_file);
				// Получаем содержимое буфера.
				$this->content = ob_get_contents();
				// Очистка буфера.
				ob_end_clean();
			}
		}else{
			// Файл блока не найден.
			throw new exception('The block file is not found.');
		}
		*/

	}



	public function __set( $name, $value ){

		if( array_key_exists( $name, $this->properties ) == true ){

			$this->properties[ $name ] = $value;

			//	print_R($this->properties);

			return true;

		}



		throw new exception('The property "' . $name . '" is not exists in Block() object.');

		//return false;

	}

	public function __get( $name ){
		if ( array_key_exists( $name, $this->properties ) == true )
			return $this->properties[ $name ];

		throw new exception('The property "' . $name . '" is not exists in Block() object.');

		/*
		$trace = debug_backtrace();

		$message = 'Undefined property via __get(): ' . $name;
		$message.= ' in ' . $trace[0]['file'];
		$message.= ' on line ' . $trace[0]['line'];

		trigger_error( $message, E_USER_NOTICE );
		*/

		//return null;

	}


	public function get_dir(){

		return $this->dir;

	}


	public function get_url(){

		return $this->url;

	}


}


?>