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

class FieldFile extends Field {

	public $type = 'file';



	function __construct( $form = null, $properties = [] ) {

		parent::__construct( $form, $properties );


		$this->inner_data['readonly'] = false;
		$this->inner_data['disabled'] = false;
		// После вызова обработчика, формируется массив с
		// дополнительной информацией о файле.
		$this->inner_data['data']['type'] = ''; // MIME-тип
		$this->inner_data['data']['size'] = 0;
		$this->inner_data['data']['name'] = '';
		$this->inner_data['multiple'] = false;

		$this->inner_data = set_params( $this->inner_data, $properties );

	}



	public function get_html(){

		$html = '';

		if( $this->value != '' ){

			if( $this->type == 'image' ){
				$url = self::$images_url . '/' . $this->value;
			}else if( $this->type == 'file' ){
				$url = self::$files_url . '/' . $this->value;
			}

			$tmp_name_for_file_info_wrapper = randstr(10);

			$params = [];
			$params['value'] = $this->value;
			$params['attrs'] = 'readonly="true"';

			$params['name'] = $this->name;

			$params['buttons'][] = array(
				'title' => 'Очистить',
				'onclick' => "hide_file_info('" . $this->name . "','" . $tmp_name_for_file_info_wrapper . "');",
				'img' => app::$kernel_url . '/interface/images/mini_button_delete.png'
			);

			$params['buttons'][] = array(
				'title' => 'Открыть',
				'onclick' => "window.open('" . $url . "','');",
				'img' => app::$kernel_url . '/interface/images/mini_button.png'
			);

			$html.= editbox($params);

			if( $this->type == 'image' ){
				$file = self::$images_dir . '/' . $this->value;
				if( is_file($file) ){
					$imageinfo = getimagesize($file);
					$html.= '<div class="file_info" id="' . $tmp_name_for_file_info_wrapper . '">';
					$html.= 'Физический путь: ' . $file . '<br />';
					$html.= 'Габариты (Ш x В): ' . $imageinfo[0] . ' x ' . $imageinfo[1] . ' пикселей<br />';
					$html.= 'Размер: ' . filesize($file) . ' байт';
					$html.= '</div>';
				}
			}else if( $this->type == 'file' ){
				$file = self::$files_dir . '/' . $this->value;
				if( is_file($file) ){
					$html.= '<div class="file_info" id="' . $tmp_name_for_file_info_wrapper . '">';
					$html.= 'Физический путь: ' . $file . '<br />';
					$html.= 'Размер: ' . filesize($file) . ' байт';
					$html.= '</div>';
				}
			}

		}else{
			$html.= '<input';
			$html.= ' class="' . $class . '"';
			$html.= ' id="' . $this->name . '"';
			$html.= ' name="' . $this->name . '"';
			if( $this->disabled )
				$html.= ' disabled="true"';
			$html.= ' type="file"';
			$html.= '/>';
		}

		return $html;

	}


	public function handle() {

		parent::handle();

		if ( $this->error == true ) {
			return !$this->error;
		}



		if( isset($_FILES[$this->name]) ){

			$value = $_FILES[$this->name];
			$exist = true;
			// Значит, если нет в $_FILES,
			// возможно есть в $_REQUEST, но только
			// в виде названия файла, так как был закачан ранее.

		}
		else if( isset($_REQUEST[$this->name]) ){

			$value = $_REQUEST[$this->name];
			$exist = true;

		}


		if( $exist == true ){


			switch( $this->type ){

				case 'file':
				case 'image':

					$value = $this->value;

					if( is_array($value) ){
						if( $value['error'] > 0 && $value['error'] != UPLOAD_ERR_NO_FILE ){
							$this->error = true;
							$this->messages[] = $this->owner->dictionary[4];
						}else if( $value['error'] == 0 ){
							// Обработать имя файла.
							$value['name'] = sp2uc($value['name']);
							$value['name'] = class_rus::translit($value['name']);
							$value['name'] = randstr(10) . '_' . $value['name'];

							$allowed = false;

							if( $this->type == 'image' && is_image($value['type']) ){
								$file = self::$images_dir . '/' . $value['name'];
								$allowed = true;
							}else if( $this->type == 'file' ){
								$file = self::$files_dir . '/' . $value['name'];
								$allowed = true;
							}

							if( $allowed && is_file($value['tmp_name']) ){
								copy($value['tmp_name'],$file);
								unlink($value['tmp_name']);
								$this->value = $value['name'];
								// Информация о файле.
								$this->data['type'] = $value['type'];
								$this->data['size'] = $value['size'];
								$this->data['name'] = $value['name'];
							}

							if( $allowed === false ){
								unlink($value['tmp_name']);
								$this->error = true;
								$this->messages[] = $this->owner->dictionary[3];
							}
						}
					}else{
						// TODO проверка вновь переданного имени файла.
						// Сюда попадает только имя файла.
						$this->value = $value;
					}
					break;
			}



		}



		return !$this->error;

	}

}


?>