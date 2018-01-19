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

class FieldBirthdate extends Field {

	protected $months = [];

	protected $days = [];

	protected $years = [];

	public function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->months = [
			0 => color( 'Месяц', '#999' ),
			1 => 'Январь',
			2 => 'Февраль',
			3 => 'Март',
			4 => 'Апрель',
			5 => 'Май',
			6 => 'Июнь',
			7 => 'Июль',
			8 => 'Август',
			9 => 'Сентябрь',
			10 => 'Октябрь',
			11 => 'Ноябрь',
			12 => 'Декабрь'
		];


		$this->days = [
			color( 'День', '#999' ),
			1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
			11, 12, 13, 14, 15, 16, 17, 18, 19,	20,
			21, 22, 23, 24, 25, 26, 27, 28, 29,	30,
			31
		];


		$this->years[] = color( 'Год', '#999' );

		$year = date('Y') - 18;

		for( $y = $year; $y >= 1905; $y-- ){

			$this->years[] = $y;

		}

	}

	public function get_html(){

		$html = '';

		$html.= '<div>';

		$params = [
			'name' => $this->name . '_day',
			'values' => $this->days,
			'value' => 0,
		];

		$html.= '<div style="display: inline-block; width: 100px; vertical-align: top;">';
		$html.= combobox($params);
		$html.= '</div>';


		$params = [
			'name' => $this->name . '_month',
			'values' => $this->months,
			'value' => 0,
		];

		$html.= '<div style="display: inline-block; width: 100px; vertical-align: top;">';
		$html.= combobox($params);
		$html.= '</div>';

		$params = [
			'name' => $this->name . '_year',
			'values' => $this->years,
			'value' => 0,
		];

		$html.= '<div style="display: inline-block; width: 100px; vertical-align: top;">';
		$html.= combobox($params);
		$html.= '</div>';


		$html.= '</div>';



		/*



		$fields[] = array(
			'type' => 'combobox',
			'name' => 'month',
			'values' => $months,
			'value' => 0,
			'draw' => false,
			'wide' => true,
			//		'decorator' => 'd_combobox',
			'required' => true,
			'dt' => 'int',
		);

		$fields[] = array(
			'type' => 'combobox',
			'name' => 'day',
			'values' => $days,
			'value' => 0,
			'draw' => false,
			'wide' => true,
			//		'decorator' => 'd_combobox',
			'required' => true,
			'dt' => 'int',
		);

		$fields[] = array(
			'type' => 'combobox',
			'name' => 'year',
			'values' => $years,
			'value' => 0,
			'draw' => false,
			'wide' => true,
			//	'decorator' => 'd_combobox',
			'required' => true,
			'dt' => 'int',
		);

		*/


		return $html;

	}


	public function handle(){

		// Стандартная проверка.
		parent::handle();

		if( $this->error == true ){
			return false;
		}






	//	checkdate(  );



		return !$this->error;

	}

}

?>