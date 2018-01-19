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

class FieldCaptcha extends Field {

	public $type = 'captcha';


	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->inner_data['values'] = [];
		$this->inner_data['onchange'] = '';
		$this->inner_data['onclick'] = '';
		$this->inner_data['h'] = '30px';
		//$this->inner_data['clear'] = true;


		$this->inner_data = set_params( $this->inner_data, $properties );

	}

	public function get_html(){

		$html = '';

		$html.= '<table>';
		$html.= '<tr>';

		$html.= '<td style="width: 120px;">';

		$html.= '<div style="margin-bottom: 3px;">';

	//	$id = 'captcha_' . $this->name;
		$id = 'captcha_' . randstr(6);

		$html.= '<img';
		$html.= ' id="' . $id . '"';

		$src = app::$controller_url . '?_service=captcha&anticache=' . time();

		//$src = app::$controller_url . '?_service=captcha' ;

		//error_log( $src );

		$html.= ' src=""';
		$html.= ' align="absmiddle"';
		$html.= ' alt="' . $this->title . '"';
		$html.= ' title="' . $this->title . '"';
		$html.= ' width="120"';
		$html.= ' height="60"';
		$html.= ' onclick="captcha_refresh(\'' . $id . '\');"';
		$html.= ' style="cursor: pointer;"';
		$html.= '/>';

		//		$html.= '<script>$(document).ready(function(){ captcha_refresh(\'' . $field->name . '\'); });</script>';

		$html.= '</div>';

		$html.= '<div style="text-align: right;">';

		$html.= '<a';
		$html.= ' href="javascript: void(0);"';
		$html.= ' onclick="captcha_refresh(\'' . $id . '\')"';
		$html.= ' style="font-weight: bold;"';
		$html.= '>';
		$html.= ( app::$language == 'ru' ? 'Обновить' : 'Refresh' );
		$html.= '</a>';

		$html.= '</div>';

		$html.= '</td>';

		$html.= '<td style="vertical-align: top; width: 200px; padding-left: 6px;">';

		$html.= editbox( array( 'name' => $this->name, 'error' => $this->error, 'width' => '100' ));




		$str = '';

		foreach( $this->messages as $message ){
			if( $message[1] == app::MES_ERROR ){
				$str.= '<div style="color: red;">' . $message[0] . '</div>';
			}
			else {
				$str.= '<div>' . $message[0] . '</div>';
			}

		}

		$html.= '<div class="field_comment">' . $str . '</div>';

//		$html.= '<div class="field_comment">';
	//	$html.= form::d_field_messages( $this->messages );
//		$html.= '</div>';

		$html.= '</td>';

		$html.= '</tr>';
		$html.= '</table>';

		$html.= '<script>';
		//$html.= 'window.onload=function(){';
		$html.= 'bw.ready(function(){';
		$html.= 'bw.get_element("#' . $id . '").src = "' . $src . '";';
		$html.= '});';
		$html.= '</script>';


		return $html;

	}


	public function handle(){

		parent::handle();



		if( $this->error == true ){

			return !$this->error;

		}


		// echo $_SESSION['captcha_keystring'] . ' = ' . $value;

		// Это поле обязательное.
		if( $this->value == '' ){
			$this->error = true;
			$this->messages[] = [ $this->owner->dictionary[6], app::MES_ERROR ];// [ dict::$dictionary['forms.this_field_is_required'], app::MES_ERROR ];
		}

		if( $this->error == false ){



			if( array_key_exists( 'captcha_keystring', $_SESSION ) == true ){

				if( $_SESSION['captcha_keystring'] != $this->value ){

					$this->error = true;
					$this->messages[] = [ $this->owner->dictionary[5], app::MES_ERROR ];

				}

				// Ликвидировать CAPTCHA.
			//	unset( $_SESSION['captcha_keystring'] );

				$_SESSION['captcha_keystring'] = '';

			}
			else {

				// TODO Отправка сообщения администратору, почему не был сгенерирован код.

				$this->error = true;
				$this->messages[] = [ $this->owner->dictionary[1], app::MES_ERROR ];

			}
		}







		return !$this->error;

	}

}


?>