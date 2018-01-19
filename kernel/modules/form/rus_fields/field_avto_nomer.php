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
 * Class FieldAvtoNomer
 *
 *
 * Регистрационные знаки транспортных средств в России.
 *
 * @link https://goo.gl/JZtTFa
 *
 * TODO
 *
 * 1. Переводить в верхний регистр.
 * 2. Выбор типа номера: гражданский, прицепы и т.п.
 * 3. Контроль ввода, например проверять допустимые буквы.
 *
 */
class FieldAvtoNomer extends FieldEditbox {
	
	public $type = 'avto_nomer';
	
	function __construct( $form = null, $properties = [] ){
		
		parent::__construct( $form, $properties );
		
		$this->mask = true;
		$this->mask_format = 'z999zz 999';
		
	}
	
	
	
	public function get_html(){
		
		if( $this->id == '' ){
			
			$this->id = 'an_' . randstr(6);
			
		}
		
		return parent::get_html();
		
	}
	
}


?>