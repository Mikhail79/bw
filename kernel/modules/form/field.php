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

// TODO default значение по умолчанию для полей. Чтобы отображалось подставлялись, если не задано значение.
class Field {

	/**
	 * @var object Form
	 */
	protected $owner = null;

	// ! Пока не делать protected, иначе не работает $field->type в prepare_fields
	public $type = 'custom';

	// Поддерживаемые режимы отображения.
	public $modes = [];

	protected $inner_data = [
		'id' => '',
		// Порядок сортировки.
		'order' => 0,
		// true/false "широкий" режим, поле размещается на двух ячейках в таблице-обёртки.
		'wide' => false,

		// deprecate, вернул, чтобы не было сбоя в модуле страниц
//		'group' => null,

		// Название поля.
		'title' => '',
		// Комментарии, располагается под названием поля title,
		// сопроводительный текст к полю.
		'title_comment' => '',
		// Тип поля.
		'type' => 'custom',
		// Описание, дополнительная информация под полем ввода.
		'field_comment' => '',
		// Массив с сообщениями поля.
		// Используется обработчиками полей, указывают найденные ошибки.
		'messages' => [],
		// Значение поля.
		'value' => '',
		// Изначальное значения.
		// Если при проверки, поле будет отсутствовать, подставится это значение.
		'default_value' => null,
		// Название поля для формы, name="" id="".
		'name' => '',
		// Режим предпросмотра формы.
		'preview' => false,
		// Индикатор ошибки в поле.
		'error' => false,
		// true/false признак "обязательного" поля, данные должны
		// быть указаны.
		'required' => false,
		// Параметры, например <input [onclick="..." style="..." и т.д.]
		'attrs' => '',
		// Тип данных
		'dt' => '',

		// Вкладка.
		'tab_id' => null,

		// Набор полей.
		'fieldset_id' => null,

		// Порядок получения фокуса.
		'tabindex' => 0,

		/**
		 * @deprecated
		 */
		// Возможна индивидуальная обработка поля.
	//	'handler' => '',

		/**
		 * @deprecated
		 */
		//
		// Функция, метод класса (статический метод) или метод объекта, для отрисовки формы.
		// Декоратор перекрывает стандартный отрисовщик.
	//	'decorator' => array('form_field', 'default_decorator'),

		'draw' => true,

		// Функция (метод) обработчик.
		// Обработчиком может быть просто функция или
		// статический метод класса.
		// Для вызова метода класса необходимо присвоить массив.
		// Для вызова простой функции передаётся строка.

		// TODO Больше не используется.

		'placeholder' => '',
		// Сейчас используется radio и checkbox.
		'arr_html' => [],
		//			'handler' => array('form', 'default_handler')
		// Для транзитных данных.
		'data' => null,

		// Используется фильтром. Имя поля в БД.
		'sql_name' => '',
	//	'disable_global_decorator' => false


	];

	function __construct( $form = null, $properties = [] ){

		if( is_object( $form ) == true && is_a( $form, 'Form' ) == true  ){

			$this->owner = $form;

		}
//		else {

//			throw new exception('The form (owner) object is null.');

//		}

		$this->inner_data = set_params( $this->inner_data, $properties );

//		$this->owner = $form;

	}

	public function set_owner( $form ){

		$this->owner = $form;

		return true;

	}

	public function get_owner(){

		return $this->owner;

	}

	public function get_type(){

		return $this->type;

	}

	public function get_html(){

		$html = $this->value;

		return $html;

	}

	/**
	 * Метод проверки значения поля.
	 *
	 * @param null $value
	 * @return bool true - в случае успешной обработки, иначе false.
	 */
	public function handle(){

		$value = null;

		if( array_key_exists( $this->name, $_REQUEST ) == true ){

			// Для случаев "...&field[]=A&field[]=B&name=John..."
			if( is_array( $_REQUEST[ $this->name ] ) == true && $this->dt == '' ){

				$value = (array) $_REQUEST[ $this->name ];

			}
			else {

				if( $this->dt == 'int' || $this->dt == 'integer' ){

					$value = get_int( $this->name, $this->default_value );

					// Fix. для radio in_array(,,true) из-за строгой проверки типа. get_int возвращает строку, а не целое из-за обёртки sprintf.
					// А строгую проверку в in_array пришлось добавит вот почему http://kb.designium.ru/In_array
					$value = intval( $value );

				}
				else if( $this->dt == 'float' ){

					$value = get_float( $this->name, $this->default_value );

				}
				else if( $this->dt == 'text' ){

					$value = get_text( $this->name, $this->default_value );

				}
				else if( $this->dt == 'str' || $this->dt == 'string' ){

					$value = get_str( $this->name, $this->default_value );

				}
				else if( $this->dt == 'bool' || $this->dt == 'boolean' ){

					$value = get_bool( $this->name, $this->default_value );

				}
				else {

					$value = (string) $_REQUEST[ $this->name ];

				}

			}

		}
		else {

			//
			// BEGIN Проверка наличия обязательного поля.
			//

			if( $this->required == true ){

				//	app::cons( $field->name . ' : ' . $exist);

				// Нет такого поля в $_REQUEST/$_GET/$_POST/$_FILES
				$this->error = true;
				$this->messages[] = [ $this->owner->dictionary[2], app::MES_ERROR ];

			}

			//
			// END Проверка наличия обязательного поля.
			//


		}

		$this->value = $value;

		return !$this->error;

	}


	public function &__get( $name ){

		if ( array_key_exists( $name, $this->inner_data ) == true ){
			return $this->inner_data[ $name ];
		}

		throw new exception('The property "' . $name . '" is not exists in field object.');

		/*
				if ( array_key_exists($name, $this->properties) === true )
					return $this->properties[$name];

				$trace = debug_backtrace();
				trigger_error(
					'Undefined property via __get(): ' . $name .
						' in ' . $trace[0]['file'] .
						' on line ' . $trace[0]['line'],
					E_USER_NOTICE);

				return null;
		*/
	}

	public function  __set( $name, $value ){
		// Прокинуть ошибку в форму.
		if( $name == 'error' ){
			$this->owner->error = (boolean) $value;
		}
		//	$this->properties[$name] = $value;


		if( array_key_exists( $name, $this->inner_data ) == true ){

			$this->inner_data[ $name ] = $value;

			//	print_R($this->properties);

			return true;

		}



		throw new exception('The property "' . $name . '" is not exists in form object.');

	}


	/**
	 * Функция отрисовывает сообщения для поля.
	 */
	public function get_messages(){

		$str = '';

		if( count( $this->messages ) > 0 ){

			foreach( $this->messages as $message ){

				if( is_array( $message ) == true ){

					$class = '';

					switch( $message[1] ){

						default:
						case app::MES_INFO:

							$class = 'info';

							break;

						case app::MES_WARN:

							$class = 'warning';

							break;

						case app::MES_ERROR:

							$class = 'error';

							break;

					}



					$message[0] = (string) $message[0];

					$str.= '<div class="form_field_message ' . $class . '">' . $message[0] . '</div>';

				}
				else {

					$message = (string) $message;

					$str.= '<div class="form_field_message">' . $message . '</div>';

				}


			}

		}

		return $str;

	}

	/**
	 * Подготовка поля в виде массива.
	 * Используется в get_html() формы.
	 *
	 */
	public function prepare(){

		$arr = [];
		$arr['html'] = $this->get_html();
		$arr['title'] = $this->title;
		$arr['name'] = $this->name;
		$arr['wide'] = $this->wide;
		$arr['type'] = $this->type;
		$arr['tab_id'] = $this->tab_id;
		$arr['fieldset_id'] = $this->fieldset_id;
		$arr['error'] = $this->error;
		$arr['draw'] = $this->draw;
		$arr['value'] = $this->value;
		$arr['required'] = $this->required;
		$arr['data'] = $this->data;

		$modes = [];

		if( is_array( $this->modes ) == true ){

			$modes = $this->modes;

		}
		else if( is_string( $this->modes ) == true ) {

			$modes2 = explode( ',', $this->modes );

			foreach( $modes2 as $i => $mode ){

				$mode = trim( $mode );

				if( $mode != '' ){

					$modes[] = $mode;

				}

			}

		}

		$arr['modes'] = $modes;

		$arr['title_comment'] = $this->title_comment;
		$arr['field_comment'] = $this->field_comment;

		if( count( $this->messages ) > 0 ){
			$arr['field_comment'].= $this->get_messages();
		}

		$arr['arr_html'] = $this->arr_html;


	//	app::cons($this->arr_html);

		return $arr;

	}

}



?>