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

class FieldWysiwyg extends Field {

	public $type = 'wysiwyg';

	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

		$this->data['uploader_params'] = [];

		$this->inner_data['expander'] = true;
		$this->inner_data['rows'] = 5;
		$this->inner_data['cols'] = 0;
		$this->inner_data['tab'] = true;
		// soft, hard, off
		$this->inner_data['wrap'] = 'off';
		$this->inner_data['readonly'] = false;
		$this->inner_data['disabled'] = false;
		$this->inner_data['editor_init'] = '';

		$this->inner_data['state'] = true;
		$this->inner_data['min_length'] = 0;
		$this->inner_data['max_length'] = 0;
		$this->inner_data['buttons'] = true;
		$this->inner_data['php_editor'] = false;
		$this->inner_data['php_button'] = false;

		// native | tinymce3 | tinymce4
		$this->inner_data['engine'] = null;

		// 3 | 4
		/**
		 * @deprecated
		 */
		$this->inner_data['tinymce'] = 3;

		$this->inner_data = set_params( $this->inner_data, $properties );

	}


	public function handle(){

		parent::handle();

		if( $this->error == true ){
			return !$this->error;
		}

		$value = $this->value;

		// Проверка мин. длины
		if( $this->min_length > 0 && $value != '' && mb_strlen($value) < $this->min_length ){
			$this->error = true;
			$this->messages[] = sprintf($this->owner->dictionary[10], $this->min_length, mb_strlen($value));
		}

		// Проверка макс. длины
		if( $this->max_length > 0 && mb_strlen($value) > $this->max_length ){
			$this->error = true;
			$this->messages[] = sprintf($this->owner->dictionary[11], $this->max_length, mb_strlen($value));
		}

		if( $value == '' && $this->required ){
			$this->error = true;
			$this->messages[] = [ $this->owner->dictionary[6], app::MES_ERROR ];
		}

		$this->value = $value;

		return !$this->error;

	}



	public function get_html(){

		$html = '';

		if( $this->engine == null ){

			$this->engine = app::$config['wysiwyg'];

		}

		if( $this->buttons == true ){


			if( $this->engine == 'tinymce4' ) {

				$html.= '<div style="margin-bottom: 4px;">';

				$html.= '<a href="javascript:" onclick="text_editor2(false,\'' . $this->name . '\')">';
				$html.= $this->owner->dictionary[7];
				$html.= '</a>';
				$html.= ' | ';
				$html .= '<a href="javascript:" onclick="editor3(true,\'' . $this->name . '\')">';
				$html.= $this->owner->dictionary[8];
				$html.= '</a>';

				$html.= ' | ';
				$str_id = $this->name . '_uploader';
				$html .= '<label class="label_link" for="' . $str_id . '">Загрузить картинку</label>';
				$html.= '<script>var params_' . $str_id . ' = ' . json_encode( $this->data['uploader_params'] ) . '</script>';
				$html.= '<input id="' . $str_id . '" type="file" style="display: none;" accept="image/*,image/jpeg" onchange="editor_uploader(this,\'' .  $this->name . '\',params_' . $str_id . ');" />';

				$html.= '</div>' . "\n";


			}
			else if( $this->engine == 'tinymce3' ) {

				$html.= '<div style="margin-bottom: 4px;">';

				$html.= '<a href="javascript:" onclick="text_editor(false,\'' . $this->name . '\')">';
				$html.= $this->owner->dictionary[7];
				$html.= '</a>';
				$html.= ' | ';
				$html .= '<a href="javascript:" onclick="editor2(true,\'' . $this->name . '\')">';
				$html.= $this->owner->dictionary[8];
				$html.= '</a>';

				$html.= ' | ';
				$str_id = $this->name . '_uploader';
				$html.= '<script>var params_' . $str_id . ' = ' . json_encode( $this->data['uploader_params'] ) . '</script>';
				$html .= '<label class="label_link" for="' . $str_id . '">Загрузить картинку</label>';
				$html.= '<input id="' . $str_id . '" type="file" style="display: none;" accept="image/*,image/jpeg" onchange="editor_uploader(this,\'' .  $this->name . '\',params_' . $str_id . ');" />';


				$html.= '</div>' . "\n";


			}


		}




		if( $this->engine == 'tinymce3' ){


		//	$this->value = htmlspecialchars( $this->value, ENT_QUOTES | ENT_SUBSTITUTE );



			$this->value = htmlspecialchars( $this->value, ENT_COMPAT );






			$attrs = 'wrap="' . $this->wrap . '"';
			if( $this->cols > 0 )
				$attrs.= ' cols="' . $this->cols . '"';
			if( $this->readonly )
				$attrs.= ' readonly="true"';
			if( $this->disabled )
				$attrs.= ' disabled="true"';

			$html.= wysiwyg(
				$this->name,
				$this->value,
				0,
				$attrs,
				$this->rows,
				'wysiwyg tinymce3'
			);


			// Полоска расширяющая поле по вертикали.
			if( $this->expander ){
				$html.= '<div';
				$html.= ' id="expander_' . $this->name . '"';
				$html.= ' onmousedown="textbox_expander(event, this, \'' . $this->name . '\')"';
				$html.= ' class="textbox_expander"';
				$html.= '>';
				$html.= '</div>' . "\n";
			}






			if( app::$page != null ){

				app::add_script( app::$kernel_url . '/other/tinymce3/tiny_mce.js' );

				$js = '';
				$js.= 'tinyMCE.init(def_init());';


				if( $this->editor_init != '' ){

					$js.= $this->editor_init;

				}

				// Включить табуляцию.
				if( $this->tab == true ){

		//			$js.= '$("#' . $this->name . '").tabby();';
					$js.= 'bw.set_tab_indent("#' . $this->name . '");';
				}

				// Состояние при появлении.
				if( $this->state == true ){

					$js.= 'editor2(true, "' . $this->name . '");';

				}

				app::$page->add_javascript( $js, 'default' );

			}
			else {


				$js = 'function(){';

				$js.= 'tinyMCE.init(def_init());';

				// Состояние при появлении.
				if( $this->state == true ){

					$js.= 'editor2(true, "' . $this->name . '");';

				}

				$js.= '}';



				$html.= '<script>';

				$html.= 'bw.load_js(\'' . app::$kernel_url . '/other/tinymce3/tiny_mce.js' . '\', \'head\', ' . $js . ' );';

				// Включить табуляцию.
				if( $this->tab == true ){

					//$html.= '$("#' . $this->name . '").tabby();';
					$html.= 'bw.set_tab_indent("#' . $this->name . '");';

				}

				if( $this->editor_init != '' ){

					$html.= $this->editor_init;

				}


				$html.= '</script>';

			}


		}
		else if( $this->engine == 'tinymce4' ){




			$this->value = htmlspecialchars( $this->value, ENT_COMPAT );






			$attrs = 'wrap="' . $this->wrap . '"';
			if( $this->cols > 0 )
				$attrs.= ' cols="' . $this->cols . '"';
			if( $this->readonly )
				$attrs.= ' readonly="true"';
			if( $this->disabled )
				$attrs.= ' disabled="true"';

			$html.= wysiwyg(
				$this->name,
				$this->value,
				0,
				$attrs,
				$this->rows,
				'wysiwyg tinymce4'
			);


			// Полоска расширяющая поле по вертикали.
			if( $this->expander ){
				$html.= '<div';
				$html.= ' id="expander_' . $this->name . '"';
				$html.= ' onmousedown="textbox_expander(event, this, \'' . $this->name . '\')"';
				$html.= ' class="textbox_expander"';
				$html.= '>';
				$html.= '</div>' . "\n";
			}



			// $this->id
		//	$html.= '<textarea id="' . $this->name . '" name="' . $this->name . '" style="width:100%;">' . htmlspecialchars($this->value, ENT_QUOTES) . '</textarea>';


			if( app::$page != null ){

				app::add_script( app::$kernel_url . '/other/tinymce4/tinymce.min.js' );


				$js = '';
				$js.= 'tinymce.init(tinymce4_config());';

				///$html.= '<script>' . $js . '</script>';

				// Состояние при появлении.
				if( $this->state == true ){

					$js.= 'editor3(true, "' . $this->name . '");';

				}



				// Включить табуляцию.
				if( $this->tab == true ){

					//$js.= '$("#' . $this->name . '").tabby();';
					$js.= 'bw.set_tab_indent("#' . $this->name . '");';
					
					
				}

				if( $this->editor_init != '' ){

					$js.= $this->editor_init;

				}


				app::$page->add_javascript($js);


			}
			else {


				$js = 'function(){';
				$js.= 'tinymce.init(tinymce4_config());';

				// Состояние при появлении.
				if( $this->state == true ){

					$js.= 'editor3(true, "' . $this->name . '");';

				}

				$js.= '}';




				$html.= '<script>';

				$html.= 'bw.load_js(\'' . app::$kernel_url . '/other/tinymce4/tinymce.min.js' . '\', \'head\', ' . $js . ' );';


				// Включить табуляцию.
				if( $this->tab == true ){

					//$html.= '$("#' . $this->name . '").tabby();';
					$html.= 'bw.set_tab_indent("#' . $this->name . '");';

				}

				if( $this->editor_init != '' ){

					$html.= $this->editor_init;

				}

				$html.= '</script>';


			}



			return $html;

		}
		else {




		}






		return $html;

	}


}


?>