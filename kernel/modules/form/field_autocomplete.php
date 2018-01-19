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

class FieldAutocomplete extends Field {

	public $type = 'autocomplete';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		/*

						$field_props['values'] = [];
				$field_props['width'] = 100;
				$field_props['height'] = 22;

*/
		$this->inner_data['items'] = [];
		$this->inner_data['hook'] = '';

		$this->inner_data = set_params( $this->inner_data, $properties );

	}

	public function get_html(){

		/*

						$html = suggestbox(array(
					'values' 		=> $field->values,
					'value' 		=> $field->value,
					'name' 		    => $field->name,
					'width' 		=> $field->width,
					'height' 		=> $field->height,
					'error' 		=> $field->error,

					//'item_height' 	=> $field->h,

				));


		*/


		$js_later_binding = true;

		if( count( $this->modes ) > 0 || $this->owner->ajax == true ){

			$js_later_binding = false;

		}




		$html = autocomplete([
			'items' => $this->items,
			'name' => $this->name,
			'id' => $this->id,
			'value' => $this->value,
			'js_later_binding' => $js_later_binding,
			'hook' => $this->hook,
		]);

		return $html;

	}


	public function handle(){

		parent::handle();

		if( $this->error == true ){
			return !$this->error;
		}


		if( $this->required == true ){

			$exists = false;

			if( is_array( $this->items ) == true ){

				foreach( $this->items as $item ){

					if( $item['id'] == $this->value ){

						$exists = true;
						break;

					}

				}

			}

			if( $exists == false ){

				$this->error = true;
				$this->messages[] = array( $this->owner->dictionary[18], app::MES_ERROR );
				$this->value = $this->default_value;


			}

		}


		/*




						if( array_key_exists( $value, $field->values ) == true ){

							$field->value = $value;

						}
						else {

							$field->error = true;
							$field->messages[] = array( $this->dictionary[18], app::MES_ERROR );

						}


		*/


		/*
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

		*/


		return !$this->error;

	}


}


?>