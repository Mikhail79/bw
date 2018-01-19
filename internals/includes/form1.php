<?

class Form1 extends Form {


	public function __construct( $properties = [] ) {

		parent::__construct( $properties );

		$this->action = '/my-page/?action=save';
		$this->method = 'post';

		$field = new FieldHidden();
		$field->name = 'id';
		$field->dt = 'int';
		$this->add_field( $field );

		$field = new FieldEditbox();
		$field->title = 'ФИО';
		$field->name = 'fio';
		$field->required = true;
		$field->dt = 'str';
		$this->add_field( $field );

		$field = new FieldPhone();
		$field->title = 'Телефон';
		$field->name = 'phone';
		$field->placeholder = '+7 (___) ___-__-__';
		$field->required = true;
		$field->dt = 'str';
		$this->add_field( $field );

		$field = new FieldKeyValue();
		$field->title = 'Какие-то значения';
		$this->add_field( $field );

		$field = new FieldCombobox();
		$field->name = 'cities';
		$field->title = 'Город';
		$field->values = [
			0 => 'Выберите город',
			1 => 'Москва',
			2 => 'Владивосток',
		];
		$this->add_field( $field );

		$field = new FieldPassword();
		$field->title = 'Пароль';
		$field->name = 'password';
		$this->add_field( $field );


		$field = new FieldRadiobox();
		$field->title = 'CPU';
		$field->name = 'cpu';
		$field->values = [
			1 => 'AMD',
			2 => 'Intel',
		];
		$this->add_field( $field );


		$field = new FieldCheckbox();
		$field->title = 'Комплектующие';
		$field->name = 'components';
		$field->multi = true;
		$field->values = [
			1 => 'CPU',
			2 => 'RAM',
			3 => 'Motherboard',
			4 => 'HDD',
			5 => 'DVD',
			6 => 'Case',
			7 => 'Cooler',
			8 => 'VGA',
		];
		$this->add_field( $field );


		$field = new FieldBirthdate();
		$field->title = 'День рождения';
		$field->name = 'birthdate';
		$field->id = 'birthdate';
		$this->add_field( $field );

		$field = new FieldDateTime();
		$field->title = 'Дата прибытия';
		$field->name = 'arrival_date';
		$field->id = 'arrival_date';
		$this->add_field( $field );

		$field = new FieldTextbox();
		$field->title = 'Описание';
		$field->name = 'description';
		$this->add_field( $field );



		$field = new FieldTextbox();
		$field->title = 'Textarea';
		$field->title_comment = 'С поддержкой авторасширения';
		$field->name = 'textarea2';
		$field->auto_height = true;
	//	$field->max_height = 400;
		$field->expander = false;
		$this->add_field( $field );

		$field = new FieldTextbox();
		$field->title = 'Textarea';
		$field->title_comment = 'С поддержкой tab/shift+tab';
		$field->name = 'textarea3';
		$field->tab = true;
		$field->expander = true;
		$field->rows = 10;
		$this->add_field( $field );



		$field = new FieldListbox();
		$field->title = 'Listbox';
		$field->name = 'listbox';
		$field->values = [
			1 => 'Двойная Пиперонни',
			2 => 'Мексика',
			3 => 'Сырный рай',
		];
		$this->add_field( $field );


		$field = new FieldTags();
		$field->title = 'Теги';
		$field->name = 'tags';
		$this->add_field( $field );

		$field = new FieldCaptcha();
		$field->title = '';
		$field->name = 'captcha';
		$this->add_field( $field );

		$field = new FieldUrl();
		$field->title = 'Адрес сайта';
		$field->name = 'url';
		$this->add_field( $field );


		$field = new FieldINN();
		$field->title = 'ИНН';
		$field->name = 'inn';
		$this->add_field( $field );

		$field = new FieldOGRN();
		$field->title = 'ОГРН';
		$field->name = 'ogrn';
		$this->add_field( $field );


		$field = new FieldKPP();
		$field->title = 'КПП';
		$field->name = 'kpp';
		$this->add_field( $field );


		$field = new FieldAvtoNomer();
		$field->title = 'Авто госномер';
		$field->name = 'gosnomer';
		$this->add_field( $field );


		$field = new FieldPassport();
		$field->title = 'Паспорт';
		$field->name = 'passport';
		$this->add_field( $field );


		$field = new FieldSNILS();
		$field->title = 'СНИЛС';
		$field->name = 'snils';
		$this->add_field( $field );

		$field = new FieldEditbox();
		$field->title = 'E-mail';
		$field->name = 'email';
		$this->add_field( $field );

		$field = new FieldEditbox();
		$field->title = 'IP4/6';
		$field->name = 'ip';
		$this->add_field( $field );

		$field = new FieldEditbox();
		$field->title = 'Сумма';
		$field->name = 'sum';
		$this->add_field( $field );

		$field = new FieldEditbox();
		$field->title = 'Интервал дат';
		$field->name = 'interval';
		$this->add_field( $field );

		$field = new FieldEditbox();
		$field->title = 'Colorpicker';
		$field->name = 'color';
		$this->add_field( $field );

		$field = new FieldEditbox();
		$field->title = 'Range (диапазон чисел)';
		$field->name = 'range';
		$this->add_field( $field );


		$field = new FieldEditbox();
		$field->title = 'Число';
		$field->name = 'num';
		$this->add_field( $field );

		$field = new FieldWysiwyg();
		$field->title = 'Статья';
		$field->name = 'article_content';
		$this->add_field( $field );


		$field = new FieldSpinner();
		$field->title = 'Количество';
		$field->name = 'quantity';
		$this->add_field( $field );





		$button = new ButtonSubmit();
		$button->value = 'Отправить';
		$this->add_button( $button );


		$button = new Button();
		$button->value = 'Отправить через AJAX';
		$this->add_button( $button );

	}

	/*
	public function get_html(){

		$vars = [];
		$vars['form'] = $this->prepare();

		$module = app::get_module('frontend','kernel');

		$html = app::$tpl->fetch( $module->dir . '/form/form.tpl', $vars );

		return $html;

	}

	public function handle(){

		// Стандартная проверка.
		parent::handle();

		if( $this->error == true ){
			return false;
		}


		//
		// BEGIN Проверка существования записи.
		//

		$this->data['record'] = null;

		if( $this->field('id')->value > 0 ){

			$this->data['record'] = check_record( $this->field('id')->value, false );

			if( $this->data['record'] == null ){

				$this->error = true;

			}

		}

		//
		// END Проверка существования записи.
		//


		return !$this->error;

	}
*/

}


?>