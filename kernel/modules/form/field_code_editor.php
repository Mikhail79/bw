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
 * Class FieldCodeEditor
 *
 * Редактор программного кода на основе Codemirror.
 */
class FieldCodeEditor extends FieldTextbox {

	public $type = 'code_editor';


	function __construct( $form = null, $properties = [] ){

		parent::__construct( $form, $properties );

//		'php_editor' => true,
//			'php_button' => true,

		$this->inner_data['expander'] = true;
		$this->inner_data['rows'] = 20;
		$this->inner_data['cols'] = 0;
		$this->inner_data['tab'] = false;
		// soft, hard, off
		$this->inner_data['wrap'] = 'off';
		$this->inner_data['readonly'] = false;
		$this->inner_data['disabled'] = false;
		$this->inner_data['min_length'] = 0;
		$this->inner_data['max_length'] = 0;

		$this->title_comment = 'Здесь можно писать HTML, PHP и PHTML. Можете использовать [tab]/[shift]+[tab]. F11 - развернуть редактор на весь экран, Esc - выход из полноразмерного режима.';

		// $field_props['decorator'] = '';

		$this->title = 'Программный код';

		$this->inner_data = set_params( $this->inner_data, $properties );

	}

	public function get_html(){

		$html = textbox([
			                'name' => $this->name,
			                'value' => htmlspecialchars($this->value, ENT_QUOTES),
			                'attrs' => $this->attrs,
			                'rows' => $this->rows,
			                'expander' => $this->expander,
			                'tab' => $this->tab,
			                'error' => $this->error,
			                'placeholder' => $this->placeholder
		                ]);



		$js = '';





		$js.= '$("#expander_' . $this->name . '").css("display","none"); $("#' . $this->name . '").parent().removeClass("sk_textbox");';


		$js.= 'var code_editor = CodeMirror.fromTextArea(document.getElementById("' . $this->name . '"), {';
		$js.= 'mode: "php",';
		// http://codemirror.net/demo/resize.html
		$js.= 'viewportMargin: Infinity,';
		$js.= 'theme: "eclipse",';
		$js.= 'autoRefresh: true,';
		$js.= 'styleActiveLine: true,';
		$js.= 'indentWithTabs: true,';
		$js.= 'lineNumbers: true,';
		$js.= 'lineWrapping: false,';
		$js.= 'smartIndent: true,';
		$js.= 'continueComments: true,';
		$js.= 'extraKeys: {';
		$js.= '"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); },';
		$js.= '"F11": function(cm) { cm.setOption("fullScreen", !cm.getOption("fullScreen")); },';
		$js.= '"Esc": function(cm) { if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false); }';
		$js.= '},';
		$js.= 'foldGutter: true,';
		$js.= 'gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter","CodeMirror-lines"]';
		$js.= '});';

		$js.= 'code_editor.on("change", function(){';
		$js.= 'if( $("#edit_code").get(0).checked == false ){';
		$js.= '$("#edit_code").get(0).checked = true;';
		$js.= '$("#edit_code").prev().addClass("checked")';
		$js.= '}';
		$js.= '});';



		/*
		 *
else if( $this->php_editor == true ){

				// TODO Перенести в FieldCodeEditor

				$html.= '<script type="text/javascript">';
				//$html.= 'php_editor(true,\'' . $field->name . '\');';
				$html.= 'var editor = CodeMirror.fromTextArea(document.getElementById("'.$this->name.'"), {';
				$html.= 'lineNumbers: true,';
				$html.= 'matchBrackets: true,';
				$html.= 'mode: "application/x-httpd-php",';
				$html.= 'indentUnit: 4,';
				$html.= 'indentWithTabs: true,';
				$html.= 'enterMode: "keep",';
				$html.= 'tabMode: "shift",';
				$html.= 'lineWrapping: true';
				$html.= '});';
				$html.= '</script>';

			}
		 *
		 *
		 *
		 */



		app::$page->add_javascript($js);


		return $html;

	}

}

?>