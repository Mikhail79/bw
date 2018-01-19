/**
 * BlueWhale PHP Framework
 *
 * @version 0.1.2 alpha (31.12.2017)
 * @author Mikhail Shershnyov <useful-soft@yandex.ru>
 * @copyright Copyright (C) 2006-2017 Mikhail Shershnyov. All rights reserved.
 * @link https://bwframework.ru
 * @license The MIT License https://bwframework.ru/license/
 */

(function( bw ) {
	
	
	var indent_char = '\t';
	
	//indent_char = '*';
	
	
	/**
	 * Функция возвращает массив строк полученный из текста.
	 * Строка (элемент массив) может включать в себя символы \r и \n.
	 *
	 * @param text
	 * @returns {Array}
	 */
	function get_lines( text ) {
		
		var c = 0;
		var start_pos = 0;
		var arr_lines = [];
		
		for ( c = 0; c < text.length; c++ ) {
			
			if ( text[ c ] === '\n' || c + 1 === text.length ) {
				
				arr_lines.push({
					begin: start_pos,
					end: c,
					text: text.substring(start_pos, c + 1)
				});
				
				
				start_pos = c + 1;
				
			}
			
			//	console.log( String.charCodeAt( this.value[ c ] ) );
			
		}
		
		
		return arr_lines;
		
	}
	
	
	var onkeydown = function ( event ) {
		
		if ( event.keyCode === 9 ) {
			
			event.preventDefault();
			
			var boundary = bw.get_selection_boundary(this);
			
			//var selected_text = bw.get_selected_text(this);
			
			// Из текста получить массив строк.
			var arr_lines = get_lines(this.value);
			
			
			// Fix: Курсор выделения может стоять в самом конце текста, за пределами последней строки.
			// В этом случае курсор выделения необходимо подогнать под границы последней строки.
			if ( arr_lines.length > 0 ) {
				
				var last_line = arr_lines[ arr_lines.length - 1 ];
				
				if ( boundary.begin === boundary.end && this.value.length === boundary.begin && last_line.end !== boundary.begin ) {
					
					boundary.begin = last_line.end;
					boundary.end = boundary.begin;
					
				}
				
			}
			
			
			//
			// BEGIN Получить массив строк, которые должны быть обработаны.
			//
			
			
			var c = 0;
			var item;
			var indented_lines = [];
			var arr_lines2 = [];
			
			
			for ( c = 0; c < arr_lines.length; c++ ) {
				
				item = arr_lines[ c ];
				
				if ( (boundary.begin === boundary.end && (item.begin === boundary.begin || item.end === boundary.end))
					|| (item.begin <= boundary.begin && item.end >= boundary.end)
					|| (item.begin >= boundary.begin && item.begin <= boundary.end)
					|| (item.end >= boundary.begin && item.end <= boundary.end)
				
				) {
					
					
					indented_lines.push(item);
					
					arr_lines2.push(c);
					
					
				}
				
			}
			
			
			//
			// END Получить массив строк, которые должны быть обработаны.
			//
			
			
			if ( event.shiftKey === true ) {
				
				
				var re = new RegExp('^\t{1}', 'g');
				
				var c = 0;
				var i = 0;
				var item;
				var str = '';
				var new_text = '';
				
				var replace_count = 0;
				
				for ( c = 0; c < arr_lines2.length; c++ ) {
					
					i = arr_lines2[ c ];
					
					item = arr_lines[ i ];
					
					new_text = item.text.replace(re, '');
					
					if ( item.text != new_text ) {
						
						arr_lines[ i ].text = new_text;
						
						replace_count++;
						
					}
					
				}
				
				
				for ( c = 0; c < arr_lines.length; c++ ) {
					
					str += arr_lines[ c ].text;
					
				}
				
				this.value = str;
				
				if ( replace_count > 0 ) {
					
					boundary.begin = boundary.begin - indent_char.length;
					
					boundary.end = boundary.end - replace_count;
					
				}
				
				//boundary.end = boundary.end - indented_lines.length;
				
				
				if ( boundary.begin < 0 ) {
					
					boundary.begin = 0;
					
				}
				
				if ( boundary.end < 0 ) {
					
					boundary.end = 0;
					
				}
				
				
				bw.select_text2(this, boundary.begin, boundary.end);
				
				
			}
			else {
				
				var str = this.value;
				
				var c = 0;
				
				for ( c = 0; c < indented_lines.length; c++ ) {
					
					item = indented_lines[ c ];
					
					str = bw.insert_string(str, item.begin + (c * indent_char.length), indent_char);
					
				}
				
				
				this.value = str;
				
				boundary.begin = boundary.begin + indent_char.length;
				boundary.end = boundary.end + indented_lines.length;
				
				bw.select_text2(this, boundary.begin, boundary.end);
				
				
			}
			
			
		}
		
	};
	
	
	var onautoheight = function(event){
		
		
		if( this.style.height !== 'auto' ) {
			
			this.style.height = 'auto';
			
		}
		
		var sh = bw.dom(this).scroll_height();
		
		var ch = bw.dom(this).client_height();
		
		
		
		var style = window.getComputedStyle(this);
		
		var offset = '';
		
	//	if ( style.boxSizing === 'border-box' ) {
			
			offset = parseFloat(  style.paddingTop ) + parseFloat( style.paddingBottom );
			
//			offset = -( parseFloat(  style.paddingTop ) + parseFloat( style.paddingBottom ) );
			
//		}
		
		

		
		if( ch < sh ){
			
			
			if( sh > this.bw_auto_height.params.max_height && this.bw_auto_height.params.max_height > 0 ){
				
				sh = this.bw_auto_height.params.max_height;
				
			}
			
			
			var doc_st = bw.dom(document).scrollTop();
			
			
			bw.dom(this).css('height', sh + offset );
			
			
			bw.dom(document).scrollTop(doc_st);
			
		}
		
		
		

		
		
	}
	
	
	/**
	 * TODO
	 *
	 * 1. Когда курсор стоит после последнего символа, то tab должен передавать фокус на следующий контрол.
	 *
	 * @param selector
	 * @param params
	 */
	bw.set_tab_indent = function ( selector, params ) {
		
		bw.foreach(selector, function () {
			
			if ( this.tagName !== 'TEXTAREA' ) {
				
				return;
				
			}
			
			
			if ( this[ 'bw_tab_indent' ] === undefined ) {
				
				this.bw_tab_indent = true;
				
				this.addEventListener('keydown', onkeydown);
				
			}
			
			
		});
		
		
	}
	
	bw.unset_tab_indent = function ( selector ) {
		
		
		bw.foreach(selector, function () {
			
			if ( this.tagName !== 'TEXTAREA' ) {
				
				return;
				
			}
			
			
			if ( this[ 'bw_tab_indent' ] !== undefined ) {
				
				delete this.bw_tab_indent;
				
				this.removeEventListener('keydown', onkeydown);
				
			}
			
		});
		
	}




	var textbox = null;
// Служебные глобальные переменные.
	var start_y = 0;
	var start_height = 0;
	var current_height = 0;
	var old_onmousemove = null;
	var old_onmouseup = null;
	var min_height = 20;




	var textbox_expander_move = function( event ){

		if( event.button <= 1 ){

			event.preventDefault();

			current_height = ( start_height + ( event.clientY - start_y ) );

			if ( current_height < min_height ) {
				current_height = min_height;
			}

			textbox.style.height = current_height + 'px';

		//	return false;

		}

	}

	var textbox_expander_up = function( event ) {

		// Восстанавливаем обработчики.
		document.onmousemove = old_onmousemove;
		document.onmouseup = old_onmouseup;

		// Значения по умолчанию.
		start_y = 0;
		start_height = 0;
		current_height = 0;
		old_onmousemove = null;
		old_onmouseup = null;
		textbox = null;

	}



	var textbox_expander = function( event ){

		event.preventDefault();

		var ta_selector = bw.dom(this).data('ta-selector');

		textbox = bw.get_element(ta_selector);

	//	console.log(textbox,ta_selector);


		start_y = event.clientY;

		start_height = textbox.offsetHeight;




		old_onmousemove = document.onmousemove;
		old_onmouseup = document.onmouseup;

		document.onmousemove = textbox_expander_move;
		document.onmouseup = textbox_expander_up;

		return false;

	}

	
	bw.set_expander = function (selector) {

		bw.foreach(selector, function () {

			if ( this['bw_expander'] === undefined ) {

				this.bw_expander = true;





				this.addEventListener('mousedown', textbox_expander);


			}

		});

	}
	
	bw.unset_expander = function (selector) {

		bw.foreach(selector, function () {

			if ( this['bw_expander'] !== undefined ) {

				delete this.bw_expander;

				this.removeEventListener('mousedown', textbox_expander);

			}

		});

	}
	
	
	bw.set_auto_height = function ( selector, params ) {
		
		var default_params = {
			// Сдвиг в пикселях, на которые будет увеличиваться или уменьшаться высота textarea.
			shift_size: 0,
			min_height: 0,
			max_height: 0
		}
		

		params = bw.set_params( default_params, params );
		
		
		
		bw.foreach( selector, function () {
			
			if ( this.tagName !== 'TEXTAREA' ) {
				
				return;
				
			}
			
			
			if ( this['bw_auto_height'] === undefined ) {
				
				this.bw_auto_height = {
					params: params,
					// Начальная высота.
					height: 0
				};
				
				
				var style = window.getComputedStyle(this);
				
				var font_size = parseFloat( style.fontSize.replace('px', '') );
				var line_height = parseFloat( style.lineHeight.replace('px', '') );
				var height = parseFloat( style.height.replace('px', '') );
				
				this.bw_auto_height.height = height;
				

				if( params.shift_size === 0 ){
					
					if( font_size > line_height ){
						
						params.shift_size = font_size;
						
					}
					else if( font_size < line_height ){
						
						params.shift_size = line_height;
						
					}
					else {
						
						params.shift_size = 16;
						
					}
				
				}
				
				
				
				this.addEventListener('input', onautoheight);
				
				this.addEventListener('keyup', onautoheight);
				
			}
			
			
			
			
			
			
			
		});
		
	
	}
	
	
	
	
	bw.unset_auto_height = function ( selector ) {
		
		
		bw.foreach(selector, function () {
			
			if ( this.tagName !== 'TEXTAREA' ) {
				
				return;
				
			}
			
			
			if ( this['bw_auto_height'] !== undefined ) {
				
				delete this.bw_auto_height;
				
				this.removeEventListener('input', onautoheight);
				
				this.removeEventListener('keyup', onautoheight);
				
			}
			
		});
	
	}



	bw.bw_textbox = function( params ){

		var default_params = {
			'name': '',
			'id': '',
			'container_id': '',
			'data': {},
			'attrs': '',
			'value': '',
			'rows': '5'
		}

		var _params = default_params;

		// Обработка полученных параметров.
		for( var name in params ){

			if( name in default_params ){

				_params[ name ] = params[ name ];

			}

		}


		var o = {

			'params': _params,

			'init': function(){

			},

			'draw': function(){

			},

			'get_html': function(){

				var html = '';

				html+= '<div class="sk_textbox">';
				html+= '<textarea';
				html+= ' name="' + this.params.name + '"';
				html+= ' id="' + this.params.id + '"';
				html+= ' rows="' + this.params.rows + '"';
				html+= ' ' + this.params.attrs + '>';
				html+= this.params.value;
				html+= '</textarea>';
				html+= '</div>';

				return html;

			},

			'set': function( property, value ){
				if( property in this.params ){

					this.params[ property ] = value;

				}
			}

		}

		o.init();

		return o;


	}
	
})( window.bw = window.bw || {} );









