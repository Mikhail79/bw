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
 * TODO Смена порядка через drag and drop.
 */
class FieldKeyValue extends Field {

	public $type = 'kv';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->value = [];

	}

	public function get_html(){

		$vars = [];
		$vars['html_id'] = randstr(6);
		$vars['name'] = $this->name;


		if( is_array( $this->value ) == false ){

			$this->value = [];

		}

		$vars['list'] = $this->value;

		$html = app::$tpl->get_html( __DIR__ . '/field_key_value/template.phtml', $vars );

		return $html;

	}


	public function handle() {

		parent::handle();

		if ( $this->error == true ) {

			return !$this->error;

		}



		$arr_props = [];

		$ext_props = get_array('props');

		foreach( $ext_props as $item ){

			if( array_key_exists( 'name', $item ) == true && array_key_exists( 'value', $item ) == true ){

				$item['name'] = (string) $item['name'];
				$item['value'] = (string) $item['value'];

				$item['name'] = trim( $item['name'] );

				if( $item['name'] != '' ){

					$arr_props[ $item['name'] ] = $item['value'];

				}

			}

		}

		$this->value = $arr_props;


		return !$this->error;

	}

}


?>