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

class FieldTextbox extends Field {

	public $type = 'textbox';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->inner_data['expander'] = true;
		$this->inner_data['rows'] = 5;
		$this->inner_data['cols'] = 0;
		$this->inner_data['tab'] = false;
		$this->inner_data['auto_height'] = false;
		// soft, hard, off
		$this->inner_data['wrap'] = 'off';
		$this->inner_data['readonly'] = false;
		$this->inner_data['disabled'] = false;
		$this->inner_data['min_length'] = 0;
		$this->inner_data['max_length'] = 0;
		$this->inner_data['max_height'] = 0;
		
		

		// $field_props['decorator'] = '';


		$this->inner_data = set_params( $this->inner_data, $properties );

	}


	public function handle(){

		parent::handle();

		if( $this->error == true ){
			return !$this->error;
		}


		$value = $this->value;

		// Проверка мин. длины
		if( $this->min_length > 0 && $value != '' && mb_strlen($value) < $this->min_length ){
			$this->error = true;
			$this->messages[] = sprintf($this->owner->dictionary[10], $this->min_length, mb_strlen($value));
		}

		// Проверка макс. длины
		if( $this->max_length > 0 && mb_strlen($value) > $this->max_length ){
			$this->error = true;
			$this->messages[] = sprintf($this->owner->dictionary[11], $this->max_length, mb_strlen($value));
		}

		if( $value == '' && $this->required ){
			$this->error = true;
			$this->messages[] = [ $this->owner->dictionary[6], app::MES_ERROR ];
		}

		$this->value = $value;

		return !$this->error;

	}


	public function get_html(){

		$html = textbox([
			                'name' => $this->name,
			                'value' => htmlspecialchars($this->value, ENT_QUOTES),
			                'attrs' => $this->attrs,
			                'rows' => $this->rows,
			                'expander' => $this->expander,

//					'decorator' => $field->decorator,
			                'tab' => $this->tab,
							'auto_height' => $this->auto_height,
			                'error' => $this->error,
							'placeholder' => $this->placeholder,
							'max_height' => $this->max_height
		                ]);






		//if( $form->preview ){
		// $html.= rn2br(htmlspecialchars($field->value,ENT_COMPAT));
		//}else{
		//$field->value = htmlspecialchars($field->value, ENT_COMPAT);

		/*

			  $attrs = 'wrap="' . $field->wrap . '"';
			  if( $field->cols > 0 )
				  $attrs.= ' cols="' . $field->cols . '"';
			  if( $field->readonly )
				  $attrs.= ' readonly="true"';
			  if( $field->disabled )
				  $attrs.= ' disabled="true"';

			  $html.= textbox(
				  $field->name,
				  $field->value,
				  $attrs,
				  $field->rows
			  );

			  */
		/*
			  $html.= textbox(array(
				  'name' => $field->name,
				  'value' => htmlspecialchars($field->value, ENT_COMPAT),
				  'attrs' => $attrs,
				  'rows' => $field->rows,
				  'expander' => $field->expander,
				  'decorator' => $field->decorator,
				  'tab' => $field->tab
			  ));
			  */

		/*

			  // Полоска расширяющая поле по вертикали.
			  if( $field->expander ){
				  $html.= '<div';
				  $html.= ' onmousedown="textbox_expander(event, this, \'' . $field->name . '\')"';
				  $html.= ' class="textbox_expander"';
				  $html.= '>';
				  $html.= '</div>' . "\n";
			  }

			  */


		// Включить табуляцию.
//						if( $field->tab ){
//							$html.= '<script language="javascript">' . "\n";
//							$html.= '$("#' . $field->name . '").tabby();' . "\n";
//							$html.= '</script>' . "\n";
//						}

		//unset($attrs);
		//}

		return $html;

	}

}


?>