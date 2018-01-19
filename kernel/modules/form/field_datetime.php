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
 * Class FieldDateTime
 * @link http://xdsoft.net/jqplugins/datetimepicker/
 *
 * @todo Отключение времени.
 */
class FieldDateTime extends Field {

	public $type = 'datetime';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		if( $this->id == '' ){
			$this->id = $this->name;
		}

		$this->inner_data['format'] = 'd.m.Y H:i';
		$this->inner_data['width'] = 'auto';
		$this->inner_data['attrs'] = '';
		$this->inner_data['placeholder'] = '';
		$this->inner_data['timepicker'] = true;

		$this->inner_data = set_params( $this->inner_data, $properties );

	}

	public function get_timestamp(){
		$dt = DateTime::createFromFormat( $this->format, $this->value );

		$ts = 0;

		if( $dt !== false ){
			$ts = $dt->getTimestamp();
		}

		return $ts;

	}

	public function get_html(){

		$html = '';

		$params = [];
		$params['name'] = $this->name;
		$params['id'] = $this->id;
		$params['value'] = htmlspecialchars( $this->value, ENT_QUOTES );
		$params['width'] = $this->width;
		$params['attrs'] = $this->attrs;
		$params['error'] = $this->error;
		$params['placeholder'] = $this->placeholder;

		$html = editbox( $params );

		$js = '';


		$js_params = [];
		$js_params['lang'] = 'ru';
		$js_params['validateOnBlur'] = false;
		$js_params['dayOfWeekStart'] = 1;
		$js_params['format'] = $this->format;
		$js_params['timepicker'] = $this->timepicker;

		$js.= '$("#' . $this->id . '").datetimepicker(' . json_encode( $js_params ) . ')';

		/*
		$js.= '$("#' . $this->id . '").datetimepicker({';
		$js.= 'lang: "ru",';
		$js.= 'validateOnBlur: false,';
		$js.= 'dayOfWeekStart: 1,';
		$js.= 'format: "' . $this->format . '"';
		$js.= '});';

		*/

		if( app::$page != null ){
			app::$page->add_javascript( $js );
		}
		else {
			$html.= '<script>';
			$html.= '$(function(){';
			$html.= $js;
			$html.= '});';
			$html.= '</script>';
		}

		return $html;

	}

	public function handle(){

		parent::handle();

		if( $this->error == true ){
			return !$this->error;
		}

		if( $this->value != '' && $this->format != '' ){

			$dt = DateTime::createFromFormat( $this->format, $this->value );

			if( $dt === false ){
				$this->error = true;
				$this->messages[] = [ 'Неверный формат даты.', app::MES_ERROR ];
			}

		}

		return !$this->error;

	}

}




?>