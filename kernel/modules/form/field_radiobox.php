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

class FieldRadiobox extends Field {

	// TODO Сделать
	//public $type = 'radiobox';
	public $type = 'radio';


	function __construct( $form = null, $properties = [] ) {

		parent::__construct($form, $properties);

		$this->inner_data['values'] = [];
		$this->inner_data['columns'] = 2;

		$this->inner_data = set_params( $this->inner_data, $properties );

	}


	public function get_html() {

		$html = '';

		$this->arr_html = [];


		// if( $form->preview ){
		// $html .= $field['values'][$field['value']];
		// }else{


		if( is_array( $this->values ) == true ){

			foreach( $this->values as $value => $title){

				$html2 = '';

				$checked = '';

				if( $this->value == $value ){
					$checked = 'checked';
				}



				$html2.= '<label>';
				$html2.= '<input ' . $checked;

				if( $this->attrs != '' ){

					$html2.= ' ' . $this->attrs;

				}

				$html2.= ' style="vertical-align: middle; margin-top: 0px;"';
				$html2.= ' type="radio"';
				$html2.= ' name="' . $this->name . '"';
				$html2.= ' value="' . $value . '">';
				$html2.= $title;
				$html2.= '</label>' . "\n";

				$this->arr_html[] = $html2;

				$html.= '<div style="margin-bottom: 2px;">';
				$html.= $html2;
				$html.= '</div>' . "\n";
			}

		}
		// }

		return $html;

	}



	public function handle() {

		parent::handle();

		if ( $this->error == true ) {
			return !$this->error;
		}

		$keys = array_keys( $this->values );

		if( in_array( $this->value, $keys ) === false ){

			$this->value = null;

		}


		return !$this->error;

	}

}