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

class TemplateEngine {

	/**
	 * @var null|Smarty
	 */
	public $engine = null;

	public $template_extension = 'phtml';

	public $name = null;

	protected $template_dir = '';

	protected function init_smarty(){

		require_once( app::$kernel_dir . '/other/smarty/Smarty.class.php' );

		$this->template_dir = app::$config['dirs']['interfaces'] . '/' . app::$interface . '/templates';

		$this->engine = new Smarty();
		$this->engine->template_dir = app::$config['dirs']['interfaces'] . '/' . app::$interface . '/templates';
		$this->engine->compile_dir = app::$config['dirs']['cache'] . '/smarty/templates_c/' . app::$config['name'] . '/interfaces/' . app::$interface;
		$this->engine->cache_dir = app::$config['dirs']['cache'] . '/smarty/cache';
		$this->engine->config_dir = app::$config['dirs']['app'];

		app::$smarty = $this->engine;

	}

	protected function init_native(){

		$this->template_dir = app::$config['dirs']['interfaces'] . '/' . app::$interface . '/templates';

	}

	function __construct( $engine = 'native' ){

		$properties = [];

		$default_properties = [];
		// smarty | native
		$default_properties['engine'] = $engine;

		$properties = set_params( $default_properties, $properties );

		$this->name = $properties['engine'];

		if( $this->name == 'smarty' ){

			$this->init_smarty();

		}
		else if( $this->name == 'native' ){

			$this->init_native();

		}
		// mixed
		else {

			$this->init_smarty();

			$this->init_native();

		}



	}


	public function get_html( $template, $data = [], $key_as_varname = false ){

		return $this->fetch( $template, $data, $key_as_varname );

	}

	/**
	 * @param $template Путь к шаблону, абсолютный или относительный. Если в начале пути, не указан слэш, тогда
	 * будет использован шаблон расположенный в директории текущего интерфейса.
	 * @param array $data
	 * @return string
	 */
	public function fetch( $template, $data = [], $key_as_varname = false, $use_cache = true ){

		$template = (string) $template;


		if( $this->template_dir != '' ){
			if( mb_substr( $template, 0, 1 ) != '/' ){
				$template = $this->template_dir . '/' . $template;
			}
		}

		$engine_type = $this->name;

		if( $engine_type == 'mixed' ){

			$extension = pathinfo( $template, PATHINFO_EXTENSION );

			if( $extension == 'php' || $extension == 'phtml' ){

				$engine_type = 'native';

			}
			else if( $extension == 'tpl' ){

				$engine_type = 'smarty';

			}

		}


		if( $engine_type == 'smarty' ){

			$tpl_data = $this->engine->createData();

			if( $key_as_varname == true ){

				foreach( $data as $key => $value ){

					$tpl_data->assign( $key, $value );

				}

			}
			else {

				$tpl_data->assign( 'vars', $data );

			}

			/*
			if( count( $data ) > 0 ){
				foreach( $data as $key => $value ){
					$tpl_data->assign( $key, $value );
				}
			}
			*/

			$tpl = $this->engine->createTemplate( $template, $tpl_data );

			$content = $tpl->fetch();

			unset($tpl_data);

		}
		else if( $engine_type == 'native' ){

			/*
			if( mb_substr( $template, 0, 1 ) != '/' ){
				$template = $this->template_dir . '/' . $template;
			}
			*/


			$content = load_template( $template, $data, $use_cache );



		}


		return $content;

	}

	public function render( $template, $data = [] ){

		return $this->fetch( $template, $data );

	}

	public function display( $template, $data = [] ){

		echo $this->fetch( $template, $data );

	}

}

?>