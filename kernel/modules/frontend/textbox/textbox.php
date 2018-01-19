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
 *
 */
function textbox( $params = [] ){
	
	$default_params = [];
	$default_params['name'] = '';
	$default_params['id'] = randstr(6);
	$default_params['value'] = '';
	$default_params['attrs'] = '';
	$default_params['rows'] = 5;
	$default_params['expander'] = false;
//	$default_params['decorator'] = '';
	$default_params['placeholder'] = '';
	$default_params['tab'] = false;
	$default_params['error'] = false;
	$default_params['auto_height'] = false;
	$default_params['max_height'] = 0;

	$params = set_params( $default_params, $params );

	/*
	if( $params['decorator'] != null ){

		if( is_array($params['decorator']) == true ){
			// Имя класса.
			$class_name = $params['decorator'][0];
			// Метод отработчик.
			$method = $params['decorator'][1];
			if( is_object($class_name) === true && method_exists($class_name, $method) === true ){
				$html = call_user_func( array( $class_name, $method ), $params);
			}else if( class_exists($class_name) == true && method_exists($class_name, $method) == true ){
				$html = call_user_func($class_name . '::' . $method, $params);
			}
		}else if( function_exists($params['decorator']) == true ){
			$html = call_user_func($params['decorator'], $params);
		}

	}else{ // Стандартный декоратор.
		*/

	$class = 'sk_textbox';

	if( isset($params['error']) && $params['error'] === true ){

		$class .= ' sk_error';

	}

	if( $params['expander'] === true ){

		$class.= ' bw_expander';

	}
		

	$html = '<div class="' . $class . '">';
	$html.= '<textarea placeholder="' . htmlspecialchars( $params['placeholder'], ENT_QUOTES | ENT_SUBSTITUTE ) . '" style="width: 100%;" ' . $params['attrs'] . ' rows="' . $params['rows'] . '" name="' . $params['name'] . '" id="' . $params['name'] . '">';
	$html.= $params['value'];
	$html.= '</textarea>';
	$html.= '</div>';

	$js = '';


	if( $params['expander'] == true ){

		$html.= '<div id="expander_' . $params['name'] . '" data-ta-selector="#' . $params['name'] . '"  class="textbox_expander"></div>';

		$js.= 'bw.set_expander("#expander_' . $params['name'] . '");';

	}

	// Включить табуляцию.
	if( $params['tab'] == true ){

		$js.= 'bw.set_tab_indent("#' . $params['name'] . '");';

	}

	if( $params['auto_height'] == true ){

		$js.= 'bw.set_auto_height("#' . $params['name'] . '" ,{max_height: ' . $params['max_height'] . '  });';

	}



	if( $params['expander'] === true || $params['tab'] == true || $params['auto_height'] == true ){

		$html.= '<script language="javascript">' . "\n";
		$html.= 'bw.ready(function(){';
		$html.= $js;
		$html.= '});';
		$html.= '</script>' . "\n";

	}

	return $html;

}


?>