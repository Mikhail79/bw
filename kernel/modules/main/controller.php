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

class Controller {

	protected $default_action = 'main';

	// Действия, которые разрешено вызывать извне.
    protected $actions = [];

	public function get_actions(){

		return $this->actions;

	}

	public function __construct(){

	}


	public function init(){
	}


	public function main(){

	}

	public function view( $name = 'default.php', $vars = [], $return = false ){


		return app::render( $name, $vars, $return );

		/*
		// Файл представления.
		$interface_view = app::$config['dirs']['interfaces'] .  '/' . app::$interface . '/views/' . $name . '.php';
  

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
		*/

	}

    public function execute(){

	    $ext_action = get_str('_action', $this->default_action);

	    $ext_action = mb_strtolower( $ext_action );

	    $actions = $this->get_actions();

	    $allowed_action = false;

	    $action = $this->default_action;


	    foreach( $actions as $record ){
		    $record = mb_strtolower( $record );
		    if( $record == $ext_action ){
			    $action = $record;
				$allowed_action = true;
			    break;
		    }
		    else if( array_key_exists( $ext_action, $actions ) == true ){
			    $action = $actions[ $ext_action ];
			    $allowed_action = true;
			    break;
		    }
	    }

	    $this->init();

	    if( $allowed_action == false && $ext_action != '' && $ext_action != $this->default_action ){
			throw new ExceptionHTTP(404);
	    }

	    // TODO Проверка существования метода.




	    $this->$action();


    }

}

?>