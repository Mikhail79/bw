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

class FieldEditbox extends Field {

	public $type = 'edit';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->inner_data['mask'] = false;
		$this->inner_data['mask_format'] = '';
		// Временно
		$this->inner_data['mask_engine'] = '';

		$this->inner_data['datetime_input'] = false;
		$this->inner_data['date_input'] = false;
		$this->inner_data['date_picker'] = false;
		$this->inner_data['datetimepicker'] = false;
		// Формат даты (регулярное выражение).
		// TODO Сделать поддержку формата date.
		$this->inner_data['date_format'] = '/\d\d\.\d\d\.\d\d\d\d/';

		$this->inner_data['width'] = 'auto';
		$this->inner_data['attrs'] = '';

		$this->inner_data['native'] = false;

		$this->inner_data['min_length'] = 0;
		$this->inner_data['max_length'] = 0;

		$this->inner_data['buttons'] = [];

		$this->inner_data['placeholder'] = '';
		$this->inner_data['autocomplete'] = false;

		$this->inner_data = set_params( $this->inner_data, $properties );

	}

	public function get_html(){

		//$this->value = htmlspecialchars($this->value,ENT_QUOTES);


		if( $this->native == true ){

			$html = '<input type="text"';

			if( $this->value != '' ) {

				$html .= ' value="' . htmlspecialchars( $this->value, ENT_QUOTES | ENT_SUBSTITUTE ) . '"';

			}

			if( $this->placeholder != '' ){

				$html.= ' placeholder="' . htmlspecialchars( $this->placeholder, ENT_QUOTES | ENT_SUBSTITUTE ) . '"';

			}

			if( $this->autocomplete == true ){

				$html.= ' autocomplete="' . ( $this->autocompete == true ? 'on' : 'off' ) . '"';

			}

			if( $this->max_length > 0 ){

				$html.= ' maxlength="' . $this->max_length . '"';

			}


			$html.= ' name="' . $this->name . '"';

			if( $this->id != '' ) {

				$html .= ' id="' . $this->id . '"';

			}

			$html.= ' ' . $this->attrs;
			$html.= ' />';

		}
		else {

			$params = [];
			$params['name'] = $this->name;
			$params['id'] = $this->id;

			if( is_array( $this->value ) == true ){


				$params['value'] = htmlspecialchars( serialize( $this->value ), ENT_QUOTES | ENT_SUBSTITUTE );

			}
			else {

				$params['value'] = htmlspecialchars( $this->value, ENT_QUOTES | ENT_SUBSTITUTE );

			}

			$params['width'] = $this->width;
			$params['attrs'] = $this->attrs;
			$params['error'] = $this->error;
			$params['tabindex'] = $this->tabindex;
			$params['buttons'] = $this->buttons;
			$params['placeholder'] = $this->placeholder;
			$params['maxlength'] = $this->max_length;



			$html = editbox($params);

			if( $this->date_picker ){
				$html.= '<script language="javascript">' . "\n";
				$html.= '$(document).ready(function(){';
				//$html.= '$("#' . $field->name . '").date_input();' . "\n";
				$html.= '$("#' . $this->name . '").datepicker();' . "\n";
				$html.= '});';
				$html.= '</script>' . "\n";
			}else if( $this->datetimepicker ){

				$html.= '<script language="javascript">';
				$html.= '$(document).ready(function(){';
				$html.= '$("#' . $this->name . '").datetimepicker();';
				$html.= '});';
				$html.= '</script>';

			}

			if( $this->mask == true ){

				/*
				$html.= '<script>';
				$html.= '$(document).ready(function(){';
				$html.= '$("#' . $this->id . '").mask(\'' . $this->mask_format . '\');';
				$html.= '});';
				$html.= '</script>';
				*/

				$html.= '<script>';
				$html.= 'bw.ready(function(){';
				$html.= 'bw.set_mask("#' . $this->id . '",{mask:"' . $this->mask_format . '"});';
				$html.= '});';
				$html.= '</script>';

			}


		}



		return $html;

	}

	public function handle(){

		parent::handle();

		if( $this->error == true ){
			return !$this->error;
		}

		// TODO Подумать над $this->owner->dictionary

		$value = $this->value;

		// Проверка мин. длины
		if( $this->min_length > 0 && $value != '' && mb_strlen($value) < $this->min_length ){
			$this->error = true;
			$this->messages[] = [ sprintf($this->owner->dictionary[10], $this->min_length, mb_strlen($value)), app::MES_ERROR ];
		}

		// Проверка макс. длины
		if( $this->max_length > 0 && mb_strlen($value) > $this->max_length ){
			$this->error = true;
			$this->messages[] = [ sprintf($this->owner->dictionary[11], $this->max_length, mb_strlen($value)), app::MES_ERROR ];
		}

		if( $value == '' && $this->required == true ){
			$this->error = true;
			$this->messages[] = [ $this->owner->dictionary[6], app::MES_ERROR ];
		}

		if( $this->date_picker ){
			if( preg_match($this->date_format, $value) ){
				$this->value = $value;
			}
			else{
				$this->error = true;
				$this->messages[] = [ $this->owner->dictionary[0], app::MES_ERROR ];
			}
		}
		else{
			$this->value = $value;
		}


		return !$this->error;

	}

}


?>