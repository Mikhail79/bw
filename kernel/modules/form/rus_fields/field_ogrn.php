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
 * Class FieldOGRN
 *
 *
 * Информация по ОГРН.
 *
 * @link https://goo.gl/A43UsN
 *
 * Информация по ОГРНИП.
 *
 * @link https://goo.gl/ZjWrJC
 */
class FieldOGRN extends FieldEditbox {
	
	public $type = 'ogrn';
	
	function __construct( $form = null, $properties = [] ){
		
		parent::__construct( $form, $properties );
		
		/**
		 * Тип:
		 *
		 * 0 - Смешанный, маска может быть 13 или 15 символов.
		 * 1 - ОГРНИП, маска 15 символов.
		 * 2 - ОГРН, маска 13 символов.
		 *
		 */
		$this->inner_data['type'] = 0;
		
		
		$this->mask = true;
		$this->mask_format = '999999999999999';
		
	}
	
	
	
	public function get_html(){
		
		if( $this->id == '' ){
			
			$this->id = 'ogrn_' . randstr(6);
			
		}
		
		return parent::get_html();
		
	}
	
}


?>