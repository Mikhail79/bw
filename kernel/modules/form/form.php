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
 *
 * @package BlueWhale PHP Framework
 */



/*
 * Добавить новые типы.
 *
 *
color 	Виджет для выбора цвета.
date 	Поле для выбора календарной даты.
datetime 	Указание даты и времени.
datetime-local 	Указание местной даты и времени.
email 	Для адресов электронной почты.
number 	Ввод чисел.
range 	Ползунок для выбора чисел в указанном диапазоне.
search 	Поле для поиска.
tel 	Для телефонных номеров.
time 	Для времени.
url 	Для веб-адресов.
month 	Выбор месяца.
week 	Выбор недели.
*/


class Form {

	// Свойства формы.
	//public $properties = array(
	protected $properties = array(
		// Тип кодирования данных формы.
		'enctype' => 'multipart/form-data',
		// Показывает форму в нередактируемом виде.
		'preview' => false,
		// Стилевой класс формы.
		'class' => 'bw_form',
		// HTTP-метод передачи формы на сервер.
		'method' => 'post',
		// В каком окне открыть результат отправки формы.
		'target' => '_blank',
		// Имя (name) и идентификатор (id) формы.
		// Используется в JavaScript/jQuery.
		'name' => '',

		// Путь к шаблону формы.
		'template' => '',

		// FIX
		// 'id' => 'form',
		'id' => '',
		
		// Ширина формы.
		'width' => '100%',
		// Скрипт обработчик формы.
		'action' => 'index.php',
		// javascript callback-функция, вызываемая перед отправкой формы.
		'onsubmit' => '',
		'onreset' => '',

		'onchange' => '',

		// javascript-код будет расположен под формой.
		'javascript' => '',


		// Отключает тэги <form></form>
		'wrapper' => true,
		// Способ защиты формы от флуда, брутфорса.
		// При использовании, id формы обязательно должен быть установлен.
		'security_mode' => form_helper::SEC_MODE_OFF,

		// Возможное количество попыток отправить форму.
		// Используется в сочетании с SEC_MODE_ANTIFLOOD или SEC_MODE_MIXED.
		'sm_submit_tries' => 10,
		// Время блокировки. В секундах.
		'sm_ban_time' => 600,

		// Адрес используемый стандартным обработчиком, в случае $form->error == true или $form->security_error == true.
		'fail_redirect_url' => null,

		// Адрес используемый стандартным обработчиком, в случае положительной проверки.
		'success_redirect_url' => null,

		'ajax' => false,

		'attrs' => '',

	);


	/**
	 * Массив для любых транзитных данных.
	 * Например для передачи данных после проверки.
	 * Данные произвольных полей.
	 */
	public $data = null;

	// Признак ошибки, обнаруженой при обработке.
	public $error = false;

	// Признак ошибки безопасности, обнаруженой при обработке.
	public $security_error = false;

	// Для сбора и вывода сообщений ошибок.
	public $messages = [];

	// Доступные режимы отображения формы.
	public $modes = [];

	// Режим по умолчанию.
	public $mode = null;

	// Используется в методе prepare().
	// Если поля имеют одинаковое свойство name, тогда при true, в шаблоне формы,
	// будет выведено только одно поле, другие будут затёрты, так как используется ассоциированный массив, где ключ имя поля.
	// А при false, будут выведены все одноимённые поля, так как будет использован обычный массив.
	// Ассоциативный массив, удобно использовать, когда кастомизируется шаблон формы, и нужно ссылаться на поле по ключу массива.
	public $name_to_key = true;

	/**
	 * @var FormTab[]
	 */
	protected $tabs = [];

	/**
	 * @var FormFieldset[]
	 */
	protected $fieldsets = [];


	public $list_of_classes = [
		'edit' => 'FieldEditbox',
		'textbox' => 'FieldTextbox',
		'wysiwyg' => 'FieldWysiwyg',
		'hidden' => 'FieldHidden',
		'combobox' => 'FieldCombobox',
		'captcha' => 'FieldCaptcha',
		'datetime' => 'FieldDateTime',
		'listbox' => 'FieldListbox',
		'checkbox' => 'FieldCheckbox',
		'file' => 'FieldFile',
		// WTF?
		'image' => 'FieldFile',
		'custom' => 'Field',
		'button' => 'Button',
		'submit' => 'ButtonSubmit',
		'reset' => 'ButtonReset',
		'image_button' => 'ButtonImage',
		'tags' => 'FieldTags',
		'radio' => 'FieldRadiobox',
		'autocomplete' => 'FieldAutocomplete',
		'password' => 'FieldPassword',
		'birthdate' => 'FieldBirthdate',
		'code_editor' => 'FieldCodeEditor',
		'url' => 'FieldUrl',
	];

	// Типы полей.
	protected $list_of_types = array(
		'hidden',
		'textbox',
		'image',
		'file',
		'wysiwyg',
		'custom',
		'password',
		'listbox',
		'combobox',
		'captcha',
		'radio',
		'checkbox',
		'edit',
		'button',
		'submit',
		'reset',
		'image_button',
		'suggestbox',
		'datetime',
		'tags',
		'birthdate',
		'code_editor',
		'url',
	);

	// Поля, которые необходимо пропустить в одном из циклов.
	protected $skip = [
		'hidden',
		'button',
		'submit',
		'reset',
		'image_button'
	];

	// Сообщения для интернационализации.
	public $dictionary = [];

	/**
	 * Массив хранит поля.
	 * @var Field[]
	 */
	protected $fields = [];


	/**
	 *
	 * @param array $properties
	 *
	 */
	public function __construct( $properties = [] ){

		$this->properties = set_params( $this->properties, $properties );

		$this->dictionary = form_helper::$dictionary[ app::$language ];

	}

	public function __set($name, $value){
		if( array_key_exists( $name, $this->properties ) == true ){

			$this->properties[ $name ] = $value;

			//	print_R($this->properties);

			return true;

		}



		throw new exception('The property "' . $name . '" is not exists in form object.');

		//return false;
	}

	public function &__get($name){

		if ( array_key_exists( $name, $this->properties ) == true ){
			return $this->properties[ $name ];
		}

		throw new exception('The property "' . $name . '" is not exists in form object.');

	}


	public function prepare_buttons( $name_to_key = true ){



		$arr = [];

		foreach( $this->fields as $i => $field ){

			if( in_array( $field->type, array('button', 'reset', 'submit', 'image_button'), true ) == false ){
				continue;
			}




			if( $name_to_key == true ){
				$i = $field->name;
			}


			$arr[ $i ]['html'] = $field->get_html();
			$arr[ $i ]['title'] = $field->title;
			$arr[ $i ]['name'] = $field->name;
			$arr[ $i ]['type'] = $field->type;

			$arr[ $i ]['draw'] = $field->draw;
			$arr[ $i ]['onclick'] = $field->onclick;

		}


		return $arr;


	}


	/**
	 * Вернуть данные полей из массива.
	 * Следует учесть, что данные нужно запрашивать после проверки формы.
	 *
	 * @param array $exclude_fields
	 * @return array
	 */
	public function get_data( $exclude_fields = [], $mode = null ){

		if( $mode == null ){

			$mode = $this->mode;

		}

		$data = [];

		foreach( $this->fields as $i => $field ){

			if( in_array( $field->type, [ 'button', 'reset', 'submit', 'image_button', 'custom' ], true ) == true ){

				continue;

			}

			if( in_array( $field->name, $exclude_fields, true ) == true ){

				continue;

			}







			if( $mode != null ){

				if( count( $field->modes ) > 0 ){

					if( in_array( $mode, $field->modes, true ) == true ){


					}
					else {

						continue;

					}

				}
				else {


				}

			}
			else {



			}



			if( $field->type == 'checkbox' ){

				if( $field->multi == true ){

					$data[ $field->name ] = $field->value;

				}
				else {

					$data[ $field->name ] = (boolean) $field->checked;

					if( $data[ $field->name ] == true ){
						$data[ $field->name ] = 1;
					}
					else {
						$data[ $field->name ] = 0;
					}

				}

			}
			else {

				$data[ $field->name ] = $field->value;

			}

		}

		return $data;

	}


	public function set_data( $data = [] ){

		foreach( $this->fields as $i => $field ){

			if( in_array( $field->type, array('button', 'reset', 'submit', 'image_button', 'custom'), true ) == true ){
				continue;
			}


			if( array_key_exists( $field->name, $data ) == true ){

				if( $field->type == 'checkbox' ){

					if( $field->multi == true ){

						$field->value = $data[ $field->name ];

					}
					else {

						$field->checked = $data[ $field->name ];

					}

				}
				else {

					$field->value = $data[ $field->name ];

				}



			}




		}


	}



	/**
	 * Метод обрабатывает поля (все кроме кнопок) и возвращает массив.
	 * Массив содержит свойства поля + html отрисованного поля.
	 * Удобно использовать в шаблонах (декораторах).
	 */
	public function prepare_fields( $name_to_key = true ){

		$arr = [];

		foreach( $this->fields as $i => $field ){

			if( in_array( $field->type, array('button', 'reset', 'submit', 'image_button'), true ) == true ){
				continue;
			}

			if( $field->tab_id != '' ){
				continue;
			}

			if( $name_to_key == true ){
				$i = $field->name;
			}

			$arr_field = $field->prepare();

			$arr[ $i ] = $arr_field;

		}


		
		return $arr;

	}

	/**
	 * Метод формирует массив формы, который включает свойства формы и отрисованные поля.
	 * Массив для передачи в tpl файл. Используется в декораторе.
	 */
	public function prepare(){

		// TODO Исключить некоторые поля.
		$arr = $this->properties;

		// Сообщения формы.
		$arr['messages'] = $this->messages;


		$arr['modes'] = $this->modes;
		$arr['mode'] = $this->mode;

		$arr['fields'] = $this->prepare_fields( $this->name_to_key );

	//print_r($arr['fields']);
	//	exit;

		$arr['buttons'] = $this->prepare_buttons();

		$arr['tabs'] = $this->prepare_tabs();
		$arr['fieldsets'] = $this->prepare_fieldsets();

		$arr['data'] = $this->data;

		if( $this->ajax == true && $this->onsubmit == '' ){

			$arr['onsubmit'] = 'return ajax_submit_form(this)';

		}

		return $arr;

	}


	public function prepare_tabs(){

		$arr = [];

		foreach( $this->tabs as $tab ){

			$arr[] = $tab->prepare();

		}

		return $arr;

	}


	public function prepare_fieldsets(){

		$arr = [];

		foreach( $this->fieldsets as $fieldset ){

			$arr[] = $fieldset->prepare();

		}
		
		return $arr;

	}

	/**
	 * Стандартный метод отрисовки формы.
	 * @deprecated
	 */
	static public function default_decorator( $form ){


		// Если у поля не определено группы, а режим группировки активен, то
		// оно будет выводиться в группе с индексом 0.
		if( count($form->properties['groups']) > 0 ){
			foreach( $form->properties['groups'] as $index => $group_name){
				$js_group_id = $form->properties['name'] . '_fields_group_' . $index;

				$html.= '<fieldset class="minimized">' . "\n";
				$html.= '<legend>' . "\n";

				$html.= '<a class="minimized"';
				$html.= ' href="javascript:void(0);"';
				$html.= ' onclick="fields_group_roll(\'' . $js_group_id . '\')"';
				$html.= '>';
				$html.= $group_name;
				$html.= '</a>' . "\n";

				$html.= '</legend>' . "\n";

				$html.= '<div';
				$html.= ' style="display: none;"';
				$html.= ' id="' . $js_group_id . '"';
				$html.= '>' . "\n";


				$html.= '</div>' . "\n";

				$html.= '</fieldset>' . "\n";
			}
		}





		// javascript отвечающий за начальное состояние групп fieldset'ов
		if( count($form->properties['groups']) > 0 ){
			$html.= '<script language="javascript">' . "\n";
			foreach( $form->properties['groups'] as $index => $group_name){
				$js_group_id = $form->properties['name'] . '_fields_group_' . $index;
				$html.= 'fields_group_init(\'' . $js_group_id . '\');' . "\n";
			}
			$html.= '</script>' . "\n";
		}




	}




	/**
	 * Генерирует HTML-код формы.
	 *
	 * @return string
	 *
	 */
	public function get_html(){

		$vars = [];

		if( $this->ajax == true ){

			$this->action = url_add_params( $this->action, [ 'ajax' => 'true' ] );

		}


	//	$module = app::get_module('frontend','kernel','form');
		$module = app::get_module('form','kernel');





		/*


		if( app::$tpl->name == 'smarty' ){

			$vars['form'] = $this->prepare();

			$template = $module->dir . '/form/form.tpl';

			if( $this->template != null ){
				$template = $this->template;
			}


			$html = file_tpl(
			//app::$kernel_dir . '/interface/templates/form.tpl',
			//$module->dir . '/form/form.tpl',
				$template,
				$vars
			);

		}
		else {

			$vars = $this->prepare();

			$template = $module->dir . '/form/form2.phtml';

			if( $this->template != null ){
				$template = $this->template;
			}

			$html = app::$tpl->fetch( $template, $vars);


		}

		*/


		$vars = $this->prepare();
		$vars['form'] = $this;

		$template = $module->dir . '/form/form2.phtml';

		if( $this->template != null ){

			$template = $this->template;

		}


		$html = app::$tpl->fetch( $template, $vars);

		return $html;

	}

	/**
	 * @param string $name
	 * @return Field
	 */
	public function get_field( $name, $mode = null ){

	//	$mode = (string) $mode;

		foreach ( $this->fields as $field ) {


			if( $mode != null ){

				if( count( $field->modes ) > 0 ){

					if( $field->name == $name && in_array( $mode, $field->modes, true ) == true ) {

						return $field;

					}

				}
				else {

					if( $field->name == $name ) {

						return $field;

					}

				}

			}
			else {

				if( $field->name == $name ) {

					return $field;

				}

			}

		}


		return null;

	}

	/**
	 *
	 * Получить свойство формы.
	 *
	 * @param <type> $prop
	 * @return значение свойства.
	 *
	 */
	public function get_prop( $name ){

		if( array_key_exists( $name, $this->properties ) == true ){
			return $this->properties[ $name ];
		}
		else {
			throw new exception('The property "' . $name . '" not exists in a form.');
		}

	}

	/**
	 * Установить свойство формы.
	 *
	 * Возвращает - сейчас старое значенеи
	 * true - если свойство установлено.
	 * false - не установлено.
	 *
	 * @param <type> $prop
	 * @param <type> $value
	 * @return bool
	 */
	public function set_prop( $name, $value = null ){

		if( array_key_exists( $name, $this->properties ) == false ){
			throw new exception('The property "' . $name . '" not exists in a form.');
		}

		$old_value = $this->properties[ $name ];

		$this->properties[ $name ] = $value;

		return $old_value;

	}

	/**
	 * Обработчик форм. Принимает данные от клиента,
	 * обрабатывает массив $_REQUEST ($_POST/$_GET) и $_FILES.
	 *
	 * Каждое поле может обрабатываться по собственному алгоритму, через
	 * свои обработчики.
	 *
	 * Возвращает результат обработки:
	 *
	 * true - успешная обработка
	 * false - при обработке возникли ошибки
	 *
	 * Note: Note that the parameters for call_user_func() are not passed by reference.
	 *
	 * @return bool
	 *
	 * Стандартный обработчик.
	 *
	 * Принимает данные, приводит их к указанному типу данных.
	 * Проверяет лимиты отправки. Если лимит привышен, устанавливает $form->error и $form->security_error.
	 *
	 * Если задан адрес для редиректа, то в случае $form->error или $form->security_error, происходит редирект.
	 *
	 * @return boolean
	 *      false - найдены ошибки
	 *      true - без ошибок
	 */
	public function handle(){


		$mode = get_str('form_mode');

		if( in_array( $mode, $this->modes, true ) == true ){

			$this->mode = $mode;

		}


		// TODO Лучше использовать get_fields()
		//$names = $this->get_names();





		foreach( $this->get_fields( $this->mode ) as $field ){

			//$field = $this->field( $name );

			$value = null;

			if( $field->type == 'custom' || ( $field->type != 'hidden' && in_array($field->type, $this->skip,true) ) ) {

				continue;

			}

			//
			// BEGIN Принять внешние данные для обработки.
			//


			if( array_key_exists( $field->name, $_REQUEST ) == true || $field->type == 'checkbox' ){

				$field->handle();

			}
			else {

				//
				// BEGIN Проверка наличия обязательного поля.
				//

				if( $field->required == true ){

					//	app::cons( $field->name . ' : ' . $exist);

					// Нет такого поля в $_REQUEST/$_GET/$_POST/$_FILES
					$field->error = true;
					$field->messages[] = [ $this->dictionary[2], app::MES_ERROR ];


				}

				//
				// END Проверка наличия обязательного поля.
				//

			}




			//
			// END Принять внешние данные для обработки.
			//





		}


		//
		// BEGIN Antiflood.
		//


		/**
		 * Проверка вынесена после проверки полей, чтобы форма прошла стандартную обработку, чтобы введённые данные
		 * пользователем не потерялись и остались в форме.
		 */

		if( $this->get_prop('security_mode') == form_helper::SEC_MODE_ANTIFLOOD ){

			$this_id = '';

			if( $this->get_prop('id') != '' ){
				$this_id = $this->get_prop('id');
			}
			else {
				throw new exception('You must specify the ID of the form.');
			}

			$expiry = 0;

			if( app::af_check( $this_id, $expiry, $this->get_prop('sm_submit_tries'), $this->get_prop('sm_ban_time') ) == false ){

				$ts = $expiry - time();

				$str = sprintf( $this->dictionary[19], get_time_str( $ts ) );

				$this->messages[] = [ $str, app::MES_WARN ];

				$this->security_error = true;

				$this->error = true;

			}

		}

		//
		// END Antiflood.
		//


		//
		// BEGIN Редирект имеет смысл использовать только при стандартном обработчике.
		//

		/*
		if( ( $this->security_error == true || $this->error == true ) && $this->fail_redirect_url !== null ){


			$tdata = [];

			$tdata['messages'] = $this->messages;
			$tdata['form'] = serialize( $this );

			$key = app::set_transit_data( $tdata );

			$url = $this->fail_redirect_url . '?_key=' . $key;

			redirect( $url );

		}
		else if( $this->security_error == false && $this->error == false && $this->success_redirect_url !== null ){

			$tdata = [];

			$tdata['messages'] = $this->messages;
			$tdata['form'] = serialize( $this );

			$key = app::set_transit_data( $tdata );

			$url = $this->success_redirect_url . '?_key=' . $key;

		//	redirect( $url );

		}

		*/

		//
		// END Редирект имеет смысл использовать только при стандартном обработчике.
		//


		return !$this->error;

	}


	public function check(){

		return $this->handle();

	}



	/**
	 * Метод осуществляет проверку формы, и в случае ошибок в проверки безопасности, делает редирект.
	 *
	 * TODO Более грамотное дописывание ключа _key к url.
	 * TODO rename to redirect_if_security_error
	 * @param $url
	 */
	public function check_security( $url ){

		if( $this->security_error == true ){

			$tdata = [];

			$tdata['messages'] = $this->messages;
			$tdata['form'] = serialize( $this );

			$key = app::set_transit_data( $tdata );

			$url = $url . '?_key=' . $key;

			redirect( $url );

		}

	}




	public function add_field( Field $field ){
		// TODO is_a - Заменить на get_class
		if( is_object( $field ) && is_a( $field, 'Field' ) == true ){

			$field->set_owner( $this );

			$this->fields[] = $field;

		}

	}

	public function add_button( Button $button ){
		// Для совместимости засунуть кнопки в массив полей.

		$button->set_owner( $this );

		$this->fields[] = $button;

	}


	/**
	 * Метод добавляет поле в форму.
	 *
	 * true - поле добавлено
	 * false - поле не добавлено
	 *
	 * @return bool
	 */
	public function add( $fields = [] ){


		if( is_array( $fields ) == false ){

			$fields = [];

		}


		foreach( $fields as $field ){

//			if( !isset($field['type']) )
//				return false;


			if( is_array( $field ) == true ){

				if( in_array($field['type'], $this->list_of_types,true) ){

					if( array_key_exists( $field['type'], $this->list_of_classes ) == true ){

						$class_name = $this->list_of_classes[ $field['type'] ];
						$this->fields[] = new $class_name( $this, $field );

					}
					else {

						//$field_props = $this->get_default_fields_props($field['type']);

						// Переопределить значения полей.
						//$field_props = set_params( $field_props, $field );

						//$this->fields[] = new form_field($field_props, $this);

					}

				}

			}
			else if( is_object( $field ) && is_a( $field, 'Field' ) == true ) {

				$this->fields[] = $field;

			}

		}

		return true;
	}



	public function delete_field( $name ){

		return $this->drop_field( $name );

	}

	/**
	 * Метод удаляет поле из формы.
	 * @param str $name
	 */
	public function drop_field($name){
		$exist = false;
		foreach ($this->fields as $index => &$field) {
			if( $field->name == $name ){
				$exist = true;
				break;
			}
		}

		if( $exist == true ){
			unset($this->fields[$index]);
			return true;
		}else{
			return false;	
		}
				
		
	}
	
	/**
	 * 
	 */
	public function messages_to_string($messages = null){
		
		$html = '';
		
		if( $messages == null ){
			$messages = $this->data['messages'];
		}

		if( is_array( $messages ) == true ){

			foreach( $messages as $message ){

				$html.= '<div style="margin-bottom: 3px;">' . $message . '</div>';

			}

		}
		
		return $html;
		
	}
	
	
	/**
	 * Метод возвращает имена всех полей в форме.
	 * Пришлось ввести это метод, так как свойство fields приватное.
	 * TODO STL итератор.
	 * @return arr
	 */
	public function get_names(){

		$names = [];

		foreach ($this->fields as $index => &$field) {

			$names[] = $field->name;

		}

		return $names;

	}

	public function get_fields( $mode = null ){

		$arr = [];

		if( $mode != null ){

			foreach( $this->fields as $field ){

				if( count( $field->modes ) > 0 ){

					if( in_array( $mode, $field->modes, true ) == true ){

						$arr[] = $field;

					}

				}
				else {

					$arr[] = $field;

				}

			}

		}
		else {

			$arr = $this->fields;

		}

		return $arr;

	}

	public function get_fieldsets(){

		return $this->fieldsets;

	}


	/**
	 *
	 * @param str $name
	 * @return Field | FieldDateTime
	 */
	public function field( $name, $mode = null ){

		if( $mode == null && $this->mode != null ){

			$mode = $this->mode;

		}

		if( $this->exists( $name, $i, $mode ) == true ){

			return $this->fields[ $i ];

		}
		else {

			throw new Exception('Field "' . $name . '" not found.');

		}

		return null;
	}

	public function exists( $name, &$i = null, $mode = null ){

		/*
		foreach ( $this->fields as $index => $field ) {
			if( $field->name == $name ){
				$i = $index;
				return true;
			}
		}
		return false;
		*/


//		$mode = (string) $mode;

//		if( $mode == null && $this->mode != null ){

//			$mode = $this->mode;

//		}


//		error_log($name .  ' = ' . $mode);

		foreach ( $this->fields as $index => $field ) {

			if( $mode != null && count( $field->modes ) > 0 ){

				if( $field->name == $name && in_array( $mode, $field->modes, true ) == true ) {

					$i = $index;

					return true;

				}

			}
			else {

				if( $field->name == $name ) {

					$i = $index;

					return true;

				}

			}

		}

		return false;

	}


	/**
	 * Метод меняет поля местами (порядок).
	 * @param str $name1 Имя первого поля.
	 * @param str $name2 Имя второго поля.
	 * @return bool
	 * 		true - good
	 * 		false - bad
	 */
	public function swap_fields($name1, $name2){

		$index1 = null;
		$index2 = null;

		foreach( $this->fields as $index => $field ){
			if( $field->name == $name1 ){
				$index1 = $index;
			}else if( $field->name == $name2 ){
				$index2 = $index;
			}
			if( $index1 != null && $index2 != null ){
				break;
			}
		}

		if( $index1 != null && $index2 != null ){
			var_flip( $this->fields[ $index1 ], $this->fields[ $index2 ] );
			return true;
		}else{
			return false;
		}

	}

	/**
	 * Метод меняет индекс последовательности для указанного поля.
	 * Если уже есть поле с указанным индексом, то это поле уходит ниже.
	 */
	public function move_to($name, $index){

		$arr = [];

		if( $this->exists( $name, $current_index ) == false ){
 

			return false;

		}




		if( isset( $this->fields[ $index ] ) == false ){
			$this->fields[ $index ] = $this->fields[ $current_index ];
			unset( $this->fields[ $current_index ] );
		}
		else{

			foreach( $this->fields as $i => $field ){

				if( $current_index == $i )
					continue;

				if( $i == $index ){
					$arr[] = $this->fields[ $current_index ];
				}

				$arr[] = $field;

			}

			$this->fields = $arr;

		}


		ksort($this->fields);

	}



	public function add_tab( FormTab $tab ){

		$tab->set_form( $this );

		$this->tabs[] = $tab;

	}

	public function add_fieldset( FormFieldset $fieldset ){


		$fieldset->set_form( $this );

		$this->fieldsets[] = $fieldset;

	}

	/**
	 * Метод проверяет входит ли поле в текущий режим (состояние) формы.
	 *
	 * В текущий режим, входят поля:
	 * 1. "count( $field->modes ) == 0"
	 * 2. in_array( $mode, $field->modes, true ) == true
	 *
	 *
	 * @param $name
	 * @param null $mode
	 * @return bool
	 */
	public function field_in_mode( $name, $mode = null ){

		if( $mode == null ){

			$mode = $this->mode;

		}


		$field = $this->get_field( $name, $mode );

		if( is_object( $field ) == true ){

			return true;

		}

//		if( in_array( $mode, $field->modes, true ) == true ){

//			return true;

//		}

		return false;


	}

}





class form_helper {

	// Защита формы отключена.
	const SEC_MODE_OFF = 0;

	// После n-количества попыток, форма перестаёт обрабатываться t-время.
	const SEC_MODE_ANTIFLOOD = 1;

	// Форма не обрабатывается только, если ввели не верный код защиты.
	const SEC_MODE_CAPTCHA = 2;

	// ANTIFLOOAD + CAPTCHA
	const SEC_MODE_MIXED = 3;


	static public $dictionary = [
		'ru' => [
			0 => 'Не верный формат даты.',
			1 => 'Системная ошибка. Защитный код не сгенерирован.',
			2 => 'Отсутствует обязательное поле.',
			3 => 'Не подходящий формат. Загрузка такого файла запрещена.',
			4 => 'Ошибка загрузки файла.',
			5 => 'Не верный защитный код.',
			6 => 'Это поле обязательное для заполнения.',
			7 => 'Текст',
			8 => 'HTML-редактор',
			9 => 'Необходимо выбрать значение.',
			10 => 'Строка должна быть не менее %s символов, а у вас %s.',
			11 => 'Строка должна быть до %s символов, а у вас %s.',
			12 => 'чекбоксов',
			13 => 'чекбокс',
			14 => 'чекбокса',
			15 => 'Необходимо выбрать минимум %s %s.',
			16 => 'Максимум можно выбрать %s %s.',
			17 => 'PHP-редактор',
			18 => 'Недопустимое значение.',
			19 => 'Превышен лимит отправки. Попробуйте повторить попытку через %s'
		],
		'en' => [
			0 => 'Не верный формат даты.',
			1 => 'System error.',
			2 => 'Отсутствует обязательное поле.',
			3 => 'Не подходящий формат. Загрузка такого файла запрещена.',
			4 => 'Ошибка загрузки файла.',
			5 => 'Invalid code.', // The wrong security code.
			6 => 'This field is required.',
			7 => 'Plain Text',
			8 => 'HTML-editor',
			9 => 'Необходимо выбрать значение.',
			10 => 'Строка должна быть не менее %s символов, а у вас %s.',
			11 => 'The field length should be up to %s characters, and you have %s.',
			12 => 'checkboxes',
			13 => 'checkbox',
			14 => 'checkboxes',
			15 => 'Необходимо выбрать минимум %s %s.',
			16 => 'Максимум можно выбрать %s %s.',
			17 => 'PHP-editor',
			18 => 'Invalid value.',
			19 => 'You have achieved limit to submit this form. Please try after %s'
		]
	];


}





?>