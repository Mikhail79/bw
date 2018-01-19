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
 * Class FieldSNILS
 *
 * Страховой Номер Индивидуального Лицевого Счёта (СНИЛС).
 *
 * @link https://goo.gl/BVgsw4
 */
class FieldSNILS extends FieldEditbox {
	
	public $type = 'snils';
	
	function __construct( $form = null, $properties = [] ){
		
		parent::__construct( $form, $properties );
		
		$this->mask = true;
		$this->mask_format = '999-999-999-99';
		
	}
	
	
	
	public function get_html(){
		
		if( $this->id == '' ){
			
			$this->id = 'snils_' . randstr(6);
			
		}
		
		return parent::get_html();
		
	}
	
}


?>