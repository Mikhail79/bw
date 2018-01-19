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

class FieldCheckbox extends Field {

	public $type = 'checkbox';


	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->inner_data['native'] = false;

		$this->inner_data['checked'] = false;
		$this->inner_data['values'] = [];
		$this->inner_data['columns'] = 2;
		$this->inner_data['min'] = 0;
		$this->inner_data['max'] = 0;
		// для одного чекбокса
		$this->inner_data['id'] = '';
		$this->inner_data['label'] = '';
		$this->inner_data['onclick'] = '';
		$this->inner_data['multi'] = false;

		$this->inner_data = set_params( $this->inner_data, $properties );

	}

	public function get_html(){


		// TODO переделать для одного чекбокса и группы.
		//if( is_array($this->values) && count($this->values) > 0){
		if( $this->multi == true ){

			if( is_array($this->values) == false ){
				$this->values = [];
			}

			$count = count($this->values);
			// "лишнии" записи раскидываются по колонкам.
			$remainder = $count % $this->columns;
			$count_per_column = ($count - $remainder) / $this->columns;
			// $column_width_remainder - отдаётся последней колонке.
			$column_width_remainder = 100 % $this->columns; // в процентах.
			$column_width = (100 - $column_width_remainder) / $this->columns;

			$index = 1;

			if( $remainder > 0 ){
				$remainder--;
				$count_per_column_x = $count_per_column + 1;
			}else{
				$count_per_column_x = $count_per_column;
			}

			$column_array = [];

			$i = -1;

			$this->arr_html = [];

			foreach( $this->values as $value => $title ){
				$i++;
				$checked = '';
				$state = false;
				if(is_array($this->value)){
					foreach( $this->value as $v ){
						if( $v == $value ){
							$state = true;
							$checked = 'checked';
							break;
						}
					}
				}

				$count_per_column_x--;
				$checkbox_name = $this->name . '[]';
				$checkbox_id = $this->name . '_' . $i;



				$html2 = checkbox(array(
					'name' => $checkbox_name,
					'id' => $checkbox_id,
					'value' => $value,
					'label' => $title,
					'state' => $state
				));

				$this->arr_html[] = $html2;


				$column_array[$index][] = $html2;

				if($count_per_column_x==0){
					$index++;
					if($remainder>0){
						$remainder--;
						$count_per_column_x = $count_per_column + 1;
					}else{
						$count_per_column_x = $count_per_column;
					}
				}
			}

			$html = '';

			$html.= '<div';
			if( $this->error )
				$html.= ' class="sk_error" style="padding: 10px 10px 2px 10px;"';
			else
				$html.= ' style="padding-top: 0px;"';
			$html.= '>';

			foreach($column_array as $index => $column){
				$width = $column_width;
				// если последняя колонка, отдать ей остаток $column_width_remainder
				if( $index == $this->columns ){
					$width = $column_width + $column_width_remainder;
				}
				$html.= '<div style="float: left; width: '.$width.'%">';
				foreach($column as $checkbox){
					$html.= '<div style="margin-bottom: 7px;">' . $checkbox . '</div>';
				}
				$html.= '</div>';
			}
			$html.= '<div style="clear:both"></div>';
			$html.= '</div>';

			unset(
				$value,
				$title,
				$v,
				$checked,
				$count,
				$remainder,
				$count_per_column,
				$column_width_remainder,
				$column_width,
				$column_array,
				$count_per_column_x,
				$index,
				$width
			);
			/*
								print_r($this->arr_html);
								exit;
			*/


		}
		else { // Один чекбокс.

			$html = checkbox(array(
				'name' => $this->name,
				'id' => $this->id,
				'value' => $this->value,
				'label' => $this->label,
				'onclick' => $this->onclick,
				'state' => $this->checked
			));

		}

		return $html;

	}

	public function prepare(){

		$arr = parent::prepare();

		if( $this->type == 'checkbox' ){

			$arr['checked'] = $this->checked;

		}

		return $arr;

	}

	public function handle() {

		// Пришлось закомментировать, так как сбрасывается value.
	//	parent::handle();



		if ( $this->error == true ) {
			return !$this->error;
		}




		if( $this->multi == true ){

			// Отмеченные чекбоксы.
			$selected = [];


			$this->value = get_array( $this->name );

			if( is_array( $this->value ) == true ){

				foreach( $this->value as $key ){

					$key = (string) $key;

					if( array_key_exists( $key, $this->values ) == true ){
						$selected[] = $key;
					}

				}

				$cnt = count($selected);


				//
				// BEGIN Проверка минимального выбора.
				//

				if( $cnt < $this->min && $this->min > 0 ){
					$this->error = true;
					$str = sprintf(
						$this->owner->dictionary[15],
						$this->min,
						datext::proceedTextual(
							$this->min,
							$this->owner->dictionary[12],
							$this->owner->dictionary[13],
							$this->owner->dictionary[14]
						)
					);
					$this->messages[] = [ $str, app::MES_ERROR ];
				}

				//
				// END Проверка минимального выбора.
				//


				//
				// BEGIN Проверка максимального выбора.
				//

				if( $cnt > $this->max && $this->max > 0 ){
					$this->error = true;
					$str = sprintf(
						$this->owner->dictionary[16],
						$this->max,
						datext::proceedTextual(
							$this->max,
							$this->owner->dictionary[12],
							$this->owner->dictionary[13],
							$this->owner->dictionary[14]
						)
					);
					$this->messages[] = [ $str, app::MES_ERROR ];
				}

				//
				// END Проверка максимального выбора.
				//

				//
				// BEGIN Проверка обязательного выбора.
				//

				if( $this->required && $cnt == 0 ){
					$this->error = true;
					$this->messages[] = [ $this->owner->dictionary[9], app::MES_ERROR ];
				}

				//
				// END Проверка обязательного выбора.
				//

			}

			$this->value = $selected;

		}
		else {

			// TODO сделать required проверку, так как parent::handle() закомментирован.

			// $this->value = $value;
			$this->checked = get_boolean( $this->name );


		}		
		
		
		return !$this->error;

	}

}




?>