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

class FieldHidden extends Field {

	public $type = 'hidden';

	public function get_html(){

		$html = '<input';
		$html.= ' type="hidden"';
		$html.= ' name="' . $this->name . '"';
		$html.= ' id="' . $this->name . '"';
		$html.= ' value="' . htmlspecialchars( $this->value, ENT_QUOTES ) . '"';
		$html.= '/>' . "\n";

		return $html;

	}

}

?>