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

class FieldUrl extends Field {

	public $type = 'url';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->inner_data['field_name'] = '';
		$this->inner_data['url'] = '';
		//$this->inner_data['url_id'] = 0;

		$this->inner_data = set_params( $this->inner_data, $properties );

	}

	public function get_html(){

		//$this->value = htmlspecialchars($this->value,ENT_QUOTES);

		$params = [];
		$params['name'] = $this->name . '_url';

		if( $this->field_name != '' ){
			$params['name'] = $this->field_name;
		}

		$params['value'] = htmlspecialchars( $this->url, ENT_QUOTES );

		$params['attrs'] = $this->attrs;
		$params['error'] = $this->error;


		$id = randstr(10);
		$div_id = 'element_' . $id;

		$html = '';

		$html.= '<div class="field_url" id="' . $div_id . '">';
		$html.= editbox($params);
		$html.= '<input type="hidden" name="' . $this->name . '" value="' . htmlspecialchars( $this->value, ENT_QUOTES | ENT_SUBSTITUTE ) . '" />';
		$html.= '<a href="#" class="clear_button"></a>';
		$html.= '</div>';

		$html.= '<script>';
		$html.= 'bw.ready(function(){';

		$html.= 'bw.dom("#' . $div_id . ' .clear_button").addEventListener("click", field_url_clear)';

		$html.= '});';
		$html.= '</script>';

		return $html;

	}

	public function handle(){

		parent::handle();

		if( $this->error == true ){
			return !$this->error;
		}

		// TODO Подумать над $this->owner->dictionary

		$value = $this->value;

		if( $this->field_name == '' ){

			$this->field_name = $this->name . '_url';

		}

		$this->url = get_str( $this->field_name );


		if( $value == '' && $this->required == true ){
			$this->error = true;
			$this->messages[] = [ $this->owner->dictionary[6], app::MES_ERROR ];
		}


		return !$this->error;

	}

}


?>