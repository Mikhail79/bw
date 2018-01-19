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


class FieldPassword extends Field {

	public $type = 'password';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );




		$this->inner_data['width'] = 'auto';
		$this->inner_data['attrs'] = '';

		$this->inner_data['min_length'] = 0;
		$this->inner_data['max_length'] = 0;

		$this->inner_data['placeholder'] = 'Пароль';


	}

	public function get_html(){

		/*
		$params = [];
		$params['name'] = $this->name;
		$params['value'] = $this->value;
		$params['width'] = $this->width;
		$params['attrs'] = $this->attrs;
		$params['error'] = $this->error;
		$params['placeholder'] = $this->placeholder;
		$params['password'] = true;
		$params['show_button'] = true;

		$html = editbox($params);

		return $html;
		*/



		$this->value = htmlspecialchars($this->value);


		$params = [];

		$params['name'] = $this->name;
		$params['value'] = $this->value;
		$params['width'] = $this->width;
		$params['attrs'] = $this->attrs;
		$params['error'] = $this->error;
		$params['tabindex'] = $this->tabindex;
		$params['show_button'] = true;
		$params['placeholder'] = $this->placeholder;

		$html = password( $params );

		return $html;

	}

	public function handle() {

		parent::handle();

		if ( $this->error == true ) {
			return !$this->error;
		}
		
		
		
		// Проверка мин. длины
		// if( $field->min_length > 0 && $value != '' && mb_strlen($value) < $field->min_length ){
		

		$value = $this->value;
		
		
		
		if( $this->error == false ){
			
			if( $this->min_length > 0 && mb_strlen($value) < $this->min_length ){
				$this->error = true;
				$str = sprintf($this->owner->dictionary[10], $this->min_length, mb_strlen($value));
				$this->messages[] = array( $str, app::MES_ERROR );
			}
			
		}
		
		if( $this->error == false ){
			
			// Проверка макс. длины
			if( $this->max_length > 0 && mb_strlen($value) > $this->max_length ){
				$this->error = true;
				$str = sprintf($this->owner->dictionary[11], $this->max_length, mb_strlen($value));
				$this->messages[] = array( $str, app::MES_ERROR );
			}
			
		}
		
		
		
		
		if( $value == '' && $this->required ){
			$this->error = true;
			$this->messages[] = [ $this->owner->dictionary[6], app::MES_ERROR ];
		}



		$this->value = $value;

		return !$this->error;

	}

}


?>