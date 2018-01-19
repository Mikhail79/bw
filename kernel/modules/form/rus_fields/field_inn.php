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
 * Class FieldINN
 *
 *
 * Идентификационный Номер Налогоплательщика (ИНН).
 *
 * @link https://goo.gl/C7hcjd
 *
 */
class FieldINN extends FieldEditbox {
	
	public $type = 'inn';
	
	function __construct( $form = null, $properties = [] ){
		
		parent::__construct( $form, $properties );
		
		/**
		 * Тип ИНН
		 *
		 * 0 - Смешанный, маска может быть 10 или 12 символов.
		 * 1 - Для физического лица, маска 12 символов.
		 * 2 - Для юридического лица, маска 10 символов.
		 *
		 */
		$this->inner_data['type'] = 0;
		
		
		$this->mask = true;
		$this->mask_format = '999999999999';
		
	}
	
	
	
	public function get_html(){
		
		if( $this->id == '' ){
			
			$this->id = 'inn_' . randstr(6);
			
		}
		
		return parent::get_html();
		
	}
	
}


?>