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

class FieldCombobox extends Field {

	public $type = 'combobox';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->inner_data['optgroup_enabled'] = false;
		$this->inner_data['values'] = [];
		$this->inner_data['onchange'] = '';
		$this->inner_data['onclick'] = '';
		$this->inner_data['h'] = '30px';

		$this->inner_data = set_params( $this->inner_data, $properties );

	}

	public function get_html(){



		$html = combobox([
			'values' => $this->values,
			'value' => $this->value,
			'name' => $this->name,
			'id' => $this->id,
			'onchange' => $this->onchange,
			'clear' => true,
			'item_height' => $this->h,
			'onclick' => $this->onclick,
			'optgroup_enabled' => $this->optgroup_enabled,
			'js_later_binding' => ( $this->owner->ajax == true ? false : true ),
		]);

		return $html;

	}


	public function handle(){

		parent::handle();


		if( $this->error == true ){
			return !$this->error;
		}


		if( $this->optgroup_enabled == true ){

			$arr_keys = [];

			foreach( $this->values as $group ){
				foreach( $group['values'] as $key => $value ){
					$arr_keys[ $key ] = $value;
				}
			}


		}
		else {

			$arr_keys = $this->values;

		}


		if( array_key_exists( $this->value, $arr_keys ) == false ){

			$this->error = true;
			$this->messages[] = array( $this->owner->dictionary[18], app::MES_ERROR );
			$this->value = $this->default_value;

		}

		return !$this->error;

	}

}

?>