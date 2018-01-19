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

// Основа модели
class Record {

	// Для транзитных данных.
	public $data = null;

	protected $changed_data = null;

	protected $default_data = [];
	protected $inner_data = [];

	// Признак инициализированности.
	protected $initialized = false;

	function __set( $name, $value ){

		$name = (string) $name;

		if( array_key_exists( $name, $this->inner_data ) == true ){

			$this->inner_data[ $name ] = $value;

			return true;

		}

		throw new exception('The property "' . $name . '" is not exists in object.');

	}

	function __get( $name ){

		$name = (string) $name;

		if ( array_key_exists( $name, $this->inner_data ) == true ){

			return $this->inner_data[ $name ];

		}

		throw new exception('The property "' . $name . '" is not exists in object.');

	}

	protected function check_initialization(){
		if( $this->initialized == false ){

			throw new exception( 'The object is not initialized.' );

		}
	}


	/*
	public function save(){

	}

	public function delete(){

	}

	public function remove(){

	}
	*/

}


?>