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

class FormTab {

	public $id;

	/**
	 * @var Form
	 */
	protected $form = null;

	public $title = '';

	public $text = '';

	public $selected = false;

	public function set_form( $form ){

		$this->form = $form;

	}

	public function get_fields( $fieldset_id = null ){

		$list = [];

		foreach( $this->form->get_fields() as $field ){

			if( $field->tab_id == $this->id && $fieldset_id == $field->fieldset_id ){

				$arr_field = $field->prepare();

				$list[] = $arr_field;

			}

		}

		return $list;

	}

	public function get_fieldsets(){

		$list = [];

		foreach( $this->form->get_fieldsets() as $fieldset ){

			if( $fieldset->tab_id == $this->id ){

				$arr_fieldset = $fieldset->prepare();

				$list[] = $arr_fieldset;

			}

		}

		return $list;

	}

	public function prepare(){

		$arr = [];

		$arr['title'] = $this->title;
		$arr['text'] = $this->text;
		$arr['selected'] = $this->selected;
		$arr['id'] = $this->id;

		$arr['fields'] = $this->get_fields();
		$arr['fieldsets'] = $this->get_fieldsets();

		return $arr;

	}

}

?>