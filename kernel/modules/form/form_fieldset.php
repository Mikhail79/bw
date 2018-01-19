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

class FormFieldset {

	public $tab_id;

	public $id;

	/**
	 * @var Form
	 */
	protected $form = null;

	/**
	 * @var FormTab
	 */
	protected $tab = null;

	public $legend = '';
	public $title = '';

	public function set_tab( $tab ){

		$this->tab = $tab;

	}


	public function set_form( $form ){

		$this->form = $form;

	}

	public function prepare(){

		$arr = [];

		$arr['legend'] = $this->legend;
		$arr['tab_id'] = $this->tab_id;
		$arr['id'] = $this->id;
		$arr['title'] = $this->title;

		$arr['fields'] = $this->get_fields();

		return $arr;

	}

	public function get_fields(){

		$list = [];

		foreach( $this->form->get_fields() as $field ){

			if( $field->fieldset_id == $this->id ){

				$arr_field = $field->prepare();

				$list[] = $arr_field;

			}

		}

		return $list;

	}

}


?>