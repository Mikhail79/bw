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

// Наследование от Field, для совместимости.
class Button extends Field {

	public $type = 'button';

	public $html5 = true;

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->inner_data['onclick'] = '';

		$this->inner_data = set_params( $this->inner_data, $properties );

	}


	public function get_html(){

		$html = '';


		if( $this->html5 == true ){

			$html.= '<button';
			$html.= ' name="' . $this->name . '"';

			$html .= ' type="' . $this->type . '"';

			if( $this->onclick != '' ) {
				$html .= ' onclick="' . $this->onclick . '"';
			}

			$html.= '>';
			$html.= $this->value;
			$html.= '</button>';



		}
		else {

			$html.= '<input';
			$html.= ' name="' . $this->name . '"';

			if( $this->type == 'image_button' ) {
				$html .= ' type="image"';
			}
			else {
				$html .= ' type="' . $this->type . '"';
			}


			if( $this->type == 'image_button' ){
				$html.= ' src="' . $this->src . '"';
			}

			$html.= ' value="' . $this->value . '"';

			if( $this->onclick != '' ) {
				$html .= ' onclick="' . $this->onclick . '"';
			}

			$html.= '/>';

		}

		return $html;

	}

}

class ButtonSubmit extends Button {

	public $type = 'submit';

}

class ButtonImage extends Button {

	public $type = 'image_button';

}

class ButtonReset extends Button {

	public $type = 'reset';

}



?>