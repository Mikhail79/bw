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

class FieldSpinner extends Field {

	public function get_html(){

		$html = '';

		if( $this->id == '' ){

			$this->id = 'spinner_' . randstr(6);

		}

		$html.= '<input name="' . $this->name . '" id="' . $this->id . '" />';

		$html.= '<script>';
		$html.= 'bw.ready(function(){';
		$html.= 'bw.spinner("#' . $this->id . '");';
		$html.= '});';
		$html.= '</script>';

		return $html;

	}

}

?>