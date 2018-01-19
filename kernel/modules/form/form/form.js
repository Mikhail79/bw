/**
 * BlueWhale PHP Framework
 *
 * @version 0.1.2 alpha (31.12.2017)
 * @author Mikhail Shershnyov <useful-soft@yandex.ru>
 * @copyright Copyright (C) 2006-2017 Mikhail Shershnyov. All rights reserved.
 * @link https://bwframework.ru
 * @license The MIT License https://bwframework.ru/license/
 */

/*
 Используется в html_form().
 Служит для обновления CAPTCHA.
 // TODO Смена URL из формы
 */
function captcha_refresh(id){
	// Антикэш.
	var d = new Date();
	//document.getElementById('captcha_'+id).src = '/index.php?_service=captcha&anticache=' + d.getTime();

	bw.get_element('#' + id).src = '/index.php?_service=captcha&anticache=' + d.getTime();

}




function send_form(name){
	var f = document.getElementById(name);
	if( f != null ){
		f.submit();
	}
}

function submit_form( name ){
	send_form( name );
}


function serialize_form( form_id ){

	var arr = $( form_id ).serializeArray();

	var data = {};

	var re = /^(.+)\[\]$/;

	for( var key in arr ) {

		var name = arr[ key ].name;
		var val = arr[ key ].value;

		var matches = name.match(re);

		if( matches != null ){

			name = matches[1];

			if( ( name in data ) == false ){

				data[ name ] = [];

			}

			data[ name ].push( val );

		}
		else {

			data[ name ] = val;

		}


	}



	return data;

}

function ajax_submit_form( form ){

	ajax_action({
		url: $(form).attr('action'),
		data: serialize_form(form)
	});


	return false;

}



/*
 Используется в html_form().
 Служит для сворачивания/разворачивания групп.
 */
function fields_group_roll(id){
	var g = document.getElementById(id);
	var fieldset = $(g).parent();
	var a = $(fieldset).find('legend a');

	if(g.style.display=='block'){
		g.style.display='none';
		// Свёрнуто
		$.cookie(id, 'collapsed');
		$(a).addClass('minimized');
		$(fieldset).addClass('minimized');
	}else{
		g.style.display = 'block';
		// Развёрнуто
		$.cookie(id, 'expanded');
		$(a).removeClass('minimized');
		$(fieldset).removeClass('minimized');
	}
}

function fields_group_init(id){
	var g = document.getElementById(id);
	var fieldset = $(g).parent();
	var a = $(fieldset).find('legend a');

	var state = $.cookie(id);

	if( state == 'collapsed' ){
		g.style.display='none';
		$(a).addClass('minimized');
		$(fieldset).addClass('minimized');
	}else if( state == 'expanded' ){
		g.style.display = 'block';
		$(a).removeClass('minimized');
		$(fieldset).removeClass('minimized');
	}

}

// use in FieldFile
function hide_file_info(n,i){
	$('#'+n).val('');
	$('#'+i).hide();
}


(function( bw ){

	var arr_forms = [];

	function Form( selector, element ){

		var o = this;

		this.element = element;
		this.selector = selector;

		this.set_mode = function( mode ){

			var $input = $(this.element).find('input[name="form_mode"]');

			$input.val( mode );

			var $list = $(this.element).find('.form-mode');

			$list.each(function(){

				if( $(this).hasClass(mode) == true ){

					// TODO Достать из массива отрендеренный html поля.
					var html = form_data[ o.element.getAttribute('id') ][ this.id ];

					$(this).html(html);

					if( this.hasAttribute('data-display') == true ){

						this.style.display = this.getAttribute('data-display');

					}
					else {

						$(this).show();

					}



				}
				else {

					$(this).hide();
					$(this).html('');

				}

			});
 

		}

		return this;

	}

	bw.get_form = function( selector ){

		var el = bw.get_element(selector);

		if( el == null ){

			return null;

		}

		var form = null;

		for( var i = 0; i < arr_forms.length; i++ ){

			var f = arr_forms[ i ];

			if( f.element == el ){

				form = f;

				break;

			}

		}


		if( form == null ){

			form = new Form( selector, el );

			arr_forms.push( form );

		}

		return form;

	}



})( window.bw = window.bw || {} );



function editor_uploader( el, wysiwyg_id, data ){

	if( typeof data == 'undefined' ){

		data = {};

	}

	bw.uploader({
		url: bw.data.controller_url + '?_service=editor_uploader&action=upload',
		files: el.files,
		data: data,
		oncomplete: function( file, files, index, response ){

			if( response.status == 'success' ) {


				// TODO Определять тип редактора.
				var editor = tinyMCE.get(wysiwyg_id);

				if( editor != null ){


					if( response.uploaded_files.length == 1 ){

						var img = editor.getDoc().createElement('img');

						img.addEventListener('load', function(event){

							if( img.width > 200 ){

								img.width = 200;

							}

							editor.execCommand('mceInsertContent', false, img.outerHTML );

						});

						img.src = response.uploaded_files[0].url;



					}



				}



			}

		}
	});

}


function field_url_clear(event){

	event.preventDefault();

	var parent = bw.dom(this).closest('.field_url');

	var input_text = bw.dom(parent).find('input[type="text"]',0);
	var input_hidden = bw.dom(parent).find('input[type="hidden"]',0);

	input_text.value = '';
	input_hidden.value = '';


//	console.log(input_text, input_hidden);


}



function editor3(state,id){



	if(state==true){

//		if( editor != null )
//			editor.toTextArea();

		$('#expander_'+id).css('display','none');
		$('#'+id).parent().removeClass('sk_textbox');
		// Для нового редактора
		tinyMCE.EditorManager.execCommand("mceAddEditor", false, id);
	}else{
		$('#expander_'+id).css('display','block');
		$('#'+id).parent().addClass('sk_textbox');
		tinyMCE.EditorManager.execCommand("mceRemoveEditor", false, id);


	}
}


function tinymce4_config(){

	var conf = {
		menubar: false,
		theme: "modern",
		height: "400px",
		content_css : [
			bw.data.internals_url + "/interfaces/default/css/tinymce_content.css"
		],
		plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker autoresize",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern imagetools codesample toc"
		],
		toolbar1: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | link unlink image media | formatselect fontsizeselect',
		toolbar2: 'table | hr removeformat | subscript superscript | print fullscreen | visualchars visualblocks nonbreaking pagebreak | cut copy paste | outdent indent blockquote | code | forecolor backcolor | codesample',
		toolbar_items_size: 'small',
		language: 'ru',
		relative_urls : false,
		codesample_languages: [
			{text: 'HTML/XML', value: 'markup'},
			{text: 'JavaScript', value: 'javascript'},
			{text: 'CSS', value: 'css'},
			{text: 'PHP', value: 'php'},
			{text: 'Ruby', value: 'ruby'},
			{text: 'Python', value: 'python'},
			{text: 'Java', value: 'java'},
			{text: 'C', value: 'c'},
			{text: 'C#', value: 'csharp'},
			{text: 'C++', value: 'cpp'},
			{text: 'Ini', value: 'ini'},
			{text: 'Apache Configuration', value: 'apacheconf'},
			{text: 'Nginx', value: 'nginx'},
			{text: 'Pure', value: 'pure'},
			{text: 'Smarty', value: 'smarty'},
			{text: 'SQL', value: 'sql'}
		],

//		$js.= 'skin: "light",';
//		image_advtab: true,
//		templates: [
//		$js.= '{title: 'Test template 1', content: 'Test 1'},';
//		$js.= '{title: 'Test template 2', content: 'Test 2'}';
//		]
	}






	return conf;

}


function text_editor2(state,id){

	$('#expander_'+id).css('display','block');
	$('#'+id).parent().addClass('sk_textbox');
	tinyMCE.EditorManager.execCommand("mceRemoveEditor", false, id);


//	if( editor != null )
//		editor.toTextArea();

}
