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

class FieldListbox extends Field {

	public $type = 'listbox';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->inner_data['values'] = [];
		$this->inner_data['attrs'] = [];
		$this->inner_data['size'] = 5;
		$this->inner_data['multiple'] = true;
		$this->inner_data['disabled'] = false;

		$this->inner_data = set_params( $this->inner_data, $properties );

	}

	public function get_html(){

	//	app::load_module('bw_html_controls', 'kernel');

		$params = [];
		$params['items'] = $this->values;
		$params['value'] = $this->value;
		$params['size'] = $this->size;
		$params['multiple'] = $this->multiple;

		$params['name'] = $this->name;

		if( $this->multiple == true ){

			$params['name'] = $this->name . '[]';

		}

		$params['attrs'] = $this->attrs;

		// WTF?
		// $params['attrs']['class'] = 'field';

		if( $this->disabled == true ) {

			$params['attrs']['disabled'] = 'true';

		}

		$html = listbox($params);


		return $html;

	}

	public function handle(){

		parent::handle();

		if( $this->error == true ){
			return !$this->error;
		}


		if( is_array( $this->value ) == true ){

			foreach( $this->value as $key ){

				if( array_key_exists( $key, $this->values ) == false ){

					$this->error = true;
					$this->messages[] = [ 'Одно или несколько выбранных значений, не корректные.', app::MES_ERROR ];
					$this->value = [];

					break;

				}

			}

		}






		return !$this->error;

	}

}

?>