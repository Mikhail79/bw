/**
 * BlueWhale PHP Framework
 *
 * @version 0.1.2 alpha (31.12.2017)
 * @author Mikhail Shershnyov <useful-soft@yandex.ru>
 * @copyright Copyright (C) 2006-2017 Mikhail Shershnyov. All rights reserved.
 * @link https://bwframework.ru
 * @license The MIT License https://bwframework.ru/license/
 */

(function( bw ){

	// https://stackoverflow.com/questions/704564/disable-drag-and-drop-on-html-elements
	// https://bertrandg.github.io/html5-disable-drop-on-input/

	
	/**
	 * TODO:
	 *
	 * + Не фиксированная маска.
	 * + Опция, чтобы при наборе дойдя до последнего символа, не переходило до начала.
	 * + Опция, поведение delete, как и backspace.
	 * + Опция установка курсора в начало редактирования первого символа.
	 */


	function MaskClass( el, params ){
		
		var o = this;
	
		this.element = el;
		
		this.params = {};
		
		// Обработанная маска в виде массив.
		this.parsed_mask = [];
		
		
		var default_params = {
			// rename to input_placeholder
			char: '_',
			placeholders: {
				'9': '[0-9]',
				'z': '[A-Za-zА-Яа-яЁё]',
				'*': '[A-Za-zА-Яа-яЁё0-9]'
			},
			mask: '',
			// TODO
			input_format: ''
		};
		
		
		
		// Маска для отображения в value.
		var mask = '';
		
		var min_pos = null;
		
		var max_pos = null;
		
		// Регулярное выражение, которым проверяется маска.
		var re;
		
		// Массив содержит введённые символы.
		var arr_data = [];
		
		
		
		

		
		
		
		function prepare_arr_data( parsed_mask ){
			
			// var prev_char = null;
			var char = null;
			var c = 0;
			var arr_data = [];
			
			
			for( c = 0; c < parsed_mask.length; c++ ){
				
				char = parsed_mask[ c ];
				
				if( char.length === 1 ){
					
					if( char in o.params.placeholders ){
						
						arr_data.push({
							position: c,
							mask: char,
							value: ''
						});
						
					}
					
				}
				
			}
			
			return arr_data;
			
		}
		
		
		

		
		
		
		
		
		//	el.addEventListener('dragstart', function(event){
		
		//		event.preventDefault();
		
		//	});
		
		
		//	el.addEventListener('change', function(event){
		
		//	});
		
		
		/**
		 * Примечание: обработчик использует приватные свойства объекта:
		 *
		 * mask
		 * params
		 *
		 *
		 * @param event
		 * @returns {boolean}
		 */
		var onkeypress = function( event ){
			
			
			var pos = get_position.call(this);
			
			
			// Delete
			if( event.keyCode === 46 ){
				
				event.preventDefault();
				
				var boundary = bw.get_selection_boundary(this);
				
				var r = boundary.end - boundary.begin;
				
				if( r > 0 ){
					
					clear_data( boundary.begin, boundary.end );
					
				}
				else {
					
					clear_data( pos );
					
				}
				
				
				if( r === 0 ) {
					
					pos = get_next_position( pos );
					
				}
				
				
				// Показать.
				show_value();
				
				bw.set_cursor( this, pos );
				
				return false;
				
			}
			// Backspace
			else if( event.keyCode === 8 ){
				
				event.preventDefault();
				
				
				var boundary = bw.get_selection_boundary(this);
				
				var r = boundary.end - boundary.begin;
				
				
				pos = get_prev_position( pos );
				
				if( r > 0 ){
					
					clear_data( boundary.begin, boundary.end );
					
				}
				else {
					
					clear_data( pos );
					
				}
				
				
				
				if( r > 0 ){
					
					pos = boundary.begin;
					
					if( pos < min_pos ){
						
						pos = min_pos;
						
					}
					
				}
				
				
				
				
				
				// Показать.
				show_value();
				
				bw.set_cursor( this, pos );
				
				return false;
				
			}
			
			
			// Например обработать Ctrl + A.
			if( event.ctrlKey === true
				|| ( event.shiftKey === true && event.charCode === 0 )
				|| event.altKey === true ) {
				
				return true;
				
			}
			
			
			
			if( event.charCode > 0 ) {
				
				event.preventDefault();
				
				//var pos = get_cursor(this);
				
				
				var new_char = String.fromCharCode( event.charCode );
				
				var p = null;
				var item = null;
				var re = null;
				var success = false;
				var matches;
				var next_pos = null;




				for( p in arr_data ){
					
					item = arr_data[ p ];
					
					
					if( item.position === pos ){
						
						re = new RegExp( '^' + o.params.placeholders[ item.mask ] + '$', 'g' );
						
						matches = new_char.match(re);
						
						if( matches !== null ){
							
							success = true;
							
							arr_data[ p ].value = new_char;
							
						}
						
						
						
					}
					
				}
				
				
				
				if( success === false ){
					
					return false;
					
				}
				
				
				
				this.value = bw.replace_string(
					this.value,
					pos,
					new_char
				);
				
				

				
				for( c = pos + 1; c < mask.length; c++ ) {
					
					
					if( mask[ c ] === o.params.char ){
						
						next_pos = c;
						
						break;
						
					}
					
				}
				
				if( next_pos == null ){
					
					next_pos = min_pos;
					
				}
				
				bw.set_cursor( this, next_pos );
				
			}
			
			
			
		};
		
		
		
		
		var onkeydown = function(event){
			
			if( event.shiftKey === false ) {
				
				// left
				if ( event.keyCode === 37 ) {
					
					event.preventDefault();
					
					var cur_pos = bw.get_cursor( this );
					
					cur_pos = get_prev_position( cur_pos );
					
					bw.set_cursor( this, cur_pos );
					
				}
				// right
				else if ( event.keyCode === 39 ) {
					
					event.preventDefault();
					
					var cur_pos = bw.get_cursor( this );
					
					cur_pos = get_next_position( cur_pos );
				
					
					bw.set_cursor( this, cur_pos );
					
				}
				// up
				else if ( event.keyCode === 38 ) {
					
					event.preventDefault();
					
					bw.set_cursor(this, max_pos);
					
				}
				// down
				else if ( event.keyCode === 40 ) {
					
					event.preventDefault();
					
					bw.set_cursor(this, min_pos);
					
				}
				
			}
			
		};
		
		
		
		var onfocus = function(event){
			
			show_value();
			
			bw.set_cursor( this, min_pos );
			
		};


		/**
		 * Функция проверяет значение, на соответствие маске.
		 */
		function check_value(){

			var matches;

			var val = String( o.element.value );

			matches = val.match(re);

			if( matches === null ){

				clear_data();

				o.element.value = '';

			}

		}
		
		
		var onblur = function(event){

			check_value();
			
		};
		
		
		var ondrop = function(event){
			
			event.preventDefault();
			
		};
		
		var oncut = function(event){
			
			event.preventDefault();
		
		};
		
		var onpaste = function(event){

			event.preventDefault();

			clear_data();

			var clipboard_data = event.clipboardData || event.originalEvent.clipboardData || window.clipboardData;
			var pasted_data = clipboard_data.getData('text');

			prepare_value( pasted_data );

		};
		
		
		//	el.addEventListener('click', function(){
		
		// установка курсора
		
		//	});
		
		
		
		function parse_mask( mask ){
			
			var char = null;
			var c = 0;
			var str;
			var parsed_mask = [];
			
			for( c = 0; c < mask.length; c++ ) {
				
				char = mask[ c ];
				
				if( char === '\\' ){
					
					str = char;
					
					if( c + 1 < mask.length ){
						
						if( mask[ c + 1 ] === ' ' ){
							
							str += '\\';
							parsed_mask.push( str );
							parsed_mask.push( mask[ c + 1 ] );
							
						}
						else {
							
							str +=  mask[ c + 1 ];
							
							parsed_mask.push( str );
						}
						
						
					}
					
					
					
					c++;
					
				}
				else {
					
					parsed_mask.push( char );
					
				}
				
			}
			
			
			return parsed_mask;
			
		}
		
		
		
		/**
		 * Функция заменяет в маске плейсхолдеры (9, z, *) на "_" для отображения в input/textarea.
		 *
		 * @param mask
		 */
		function prepare_mask( parsed_mask ){
			
			var char = null;
			var c = 0;
			var mask = '';
	
			
			for( c = 0; c < parsed_mask.length; c++ ){
				
				char = parsed_mask[ c ];
				
				if( char.length === 2 ){
					
					
					
					if( char[0] === '\\' ){
						
						mask += char[1];
						
					}
//				params.placeholders[ char ];
				
				}
				else {
					
					if( char in o.params.placeholders ){
						
						mask += o.params.char;
						
					}
					else {
						
						mask += char;
						
					}
					
				}
				
			}
			
			return mask;
			
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		function get_next_position( current_position ){
			
			var c = 0;
			
			var char = null;
			
			var next_pos = null;
			
			for( c = current_position + 1; c < mask.length; c++ ) {
				
				char = mask[ c ];
				
				if( char === o.params.char ){
					
					next_pos = c;
					
					break;
					
				}
				
			}
			
			if( next_pos === null ){
				
				next_pos = min_pos;
				
			}
			
			
			return next_pos;
			
		}
		
		
		function get_prev_position( current_position ){
			
			var c = 0;
			
			var char = null;
			
			var prev_pos = null;
			
			for( c = 0; c < mask.length; c++ ) {
				
				char = mask[ c ];
				
				if( char === o.params.char ){
					
					if( c < current_position ){
						
						prev_pos = c;
						
					}
					
				}
				
			}
			
			
			// Перевести курсор в начало.
			if( prev_pos == null ){
				
				prev_pos = max_pos;
				
			}
			
			
			if ( prev_pos < min_pos ) {
				
				prev_pos = min_pos;
				
			}
			
			return prev_pos;
			
		}
		
		
		/**
		 * Использует приватные свойства:
		 *
		 * mask
		 * params
		 * arr_data
		 *
		 */
		function show_value(){
			
			var k = 0;
			
			var val = mask;
			
			
			var item = null;
			
			
			for( k in arr_data ){
				
				item = arr_data[ k ];
				
				if( item.value === '' ){
					
					item.value = o.params.char;
					
				}
				
				val = bw.replace_string( val, item.position, item.value );
				
			}
			
			o.element.value = val;
			
		}
		
		
		
		function clear_data(){
			
			var k = null;
			
			if( arguments.length === 0 ){
				
				for( k in arr_data ) {
					
					arr_data[ k ].value = '';
					
				}
				
			}
			else if( arguments.length === 1 ){
				
				var pos = bw.intval( arguments[0] );
				
				for( k in arr_data ){
					
					if ( arr_data[ k ].position === pos ) {
						
						arr_data[ k ].value = '';
						
						break;
						
					}
					
				}
				
			}
			else if( arguments.length === 2 ){
				
				var begin = bw.intval( arguments[0] );
				var end = bw.intval( arguments[1] );
				var item = null;
				
				for( k in arr_data ){
					
					item = arr_data[ k ];
					
					if ( item.position >= begin && item.position < end ) {
						
						arr_data[ k ].value = '';
						
					}
					
				}
				
			}
			
		}
		
		
		
		/**
		 * Получить допустимую позицию.
		 *
		 * get_position() вызывается через get_position.call(), таким образом внутренний this ссылается на input/textarea.
		 *
		 * @returns {*}
		 */
		function get_position(){
			
			var c = 0;
			
			var pos = bw.get_cursor( this );
			
			for( c = 0; c < mask.length; c++ ) {
				
				
				if( pos === c && mask[ c ] !== o.params.char ){
					
					pos++;
					
				}
				
				
			}
			
			
			if( pos < min_pos ){
				
				pos = min_pos;
				
			}
			
			if( pos > max_pos ){
				
				pos = min_pos;
				
			}
			
			return pos;
			
			
		}
		
		
		/**
		 * Вычислить минимальную и максимальную позицию для курсора в input/textarea.
		 */
		function get_cursor_bound( mask ){
			
			var c = 0;
			var min_pos = null;
			var max_pos = null;
			
			for( c = 0; c < mask.length; c++ ) {
				
				if( mask[ c ] === o.params.char ){
					
					if( min_pos === null ){
						
						min_pos = c;
						
					}
					
					max_pos = c;
					
				}
				
			}
			
			return {
				min_pos: min_pos,
				max_pos: max_pos
			}
			
			
		}
		
		
		/**
		 * Функция подготавливает регулярное выражение для маски.
		 *
		 * @param parsed_mask
		 * @returns {*}
		 */
		function get_reg_exp( parsed_mask ){
			
			var c = 0;
			var char = null;
			var reg_exp = '';
			var re = null;
			
			for( c = 0; c < parsed_mask.length; c++ ){
				
				char = parsed_mask[ c ];
				
				if( char.length === 2 ){
					
					reg_exp += bw.preg_quote( char[1] );
					
				}
				else {
					
					if( char in o.params.placeholders ){
						
						reg_exp += o.params.placeholders[ char ];
						
					}
					else {
						
						reg_exp += bw.preg_quote( char );
						
					}
					
				}
				
			}
			
			
			re = new RegExp( '^' + reg_exp + '$', 'g' );
			
			return re;
			
			
		}
		
		
		function prepare_value( value ){

			if( value === undefined ){

				value = o.element.value;

			}

			var c = 0;
			var parsed_value = [];
			var item;
			var v = null;
			var re;
			var matches;


			parsed_value = bw.explode( '', value );


			if( parsed_value.length === arr_data.length ){

				for( c = 0; c < arr_data.length; c++ ){

					item = arr_data[ c ];

					re = new RegExp( '^' + o.params.placeholders[ item.mask ] + '$', 'g' );

					if( c in parsed_value ){

						v = parsed_value[ c ];

						matches = v.match(re);

						if( matches !== null ){

							arr_data[ c ].value = v;

						}

					}

				}

			}
			else if( parsed_value.length === o.parsed_mask.length ){

				for( c = 0; c < arr_data.length; c++ ){

					item = arr_data[ c ];

					re = new RegExp( '^' + o.params.placeholders[ item.mask ] + '$', 'g' );

					if( item.position in parsed_value ){

						v = parsed_value[ item.position ];

						matches = v.match(re);

						if( matches !== null ){

							arr_data[ c ].value = v;

						}

					}

				}

			}



			show_value();

			check_value();

			show_value();

		}
		
		
		this.init = function( params ){
			
			this.params = bw.set_params( default_params, params );
			
			this.params.mask = String( this.params.mask );
		
			this.parsed_mask = parse_mask( this.params.mask );
			
			
			mask = prepare_mask( this.parsed_mask );
			
			
			
			arr_data = prepare_arr_data( this.parsed_mask );
			
			
			re = get_reg_exp( this.parsed_mask );
			
			var pos = get_cursor_bound( mask );
			
			
			min_pos = pos.min_pos;
			
			max_pos = pos.max_pos;
			
			
			this.element.addEventListener('keypress', onkeypress);
			
			this.element.addEventListener('keydown', onkeydown);
			
			this.element.addEventListener('focus', onfocus);
			
			this.element.addEventListener('blur', onblur);
			
			this.element.addEventListener('drop', ondrop);
			
			this.element.addEventListener('cut', oncut);
			
			this.element.addEventListener('paste', onpaste);
			




			if( this.element.value != '' ){

				prepare_value();




			}





			
		};
		

		
		
		
		this.destructor = function(){
		
			this.element.removeEventListener('keypress', onkeypress);
			
			this.element.removeEventListener('keydown', onkeydown);
			
			this.element.removeEventListener('focus', onfocus);
			
			this.element.removeEventListener('blur', onblur);
			
			this.element.removeEventListener('drop', ondrop);
			
			this.element.removeEventListener('cut', oncut);
			
			this.element.removeEventListener('paste', onpaste);
		
		};
		

		
		
		this.init( params );

		
		return this;
		
	}
	
	
	
	
	
	
	
	/**
	 * Чтобы в маске показать цифру "9", букву "a" или "*", необходимо написать так: \9, \a, \*.
	 *
	 * @param selector
	 * @param params
	 */
	bw.set_mask = function( selector, params ){



		bw.foreach(selector, function(){
			
			if( this.tagName !== 'TEXTAREA' && ( this.tagName !== 'INPUT' && this.type !== 'text' ) ){
				
				return;
				
			}
			
			
			if( this['bw_mask'] === undefined ){

				this.bw_mask = new MaskClass( this, params );
				
			}



		});

		
		
	};
	
	
	bw.unset_mask = function( selector ){
		
		
		bw.foreach(selector, function(){
			
			if( this.tagName !== 'TEXTAREA'	&& ( this.tagName !== 'INPUT' && this.type !== 'text' ) ){
				
				return;
				
			}
			
			
			if( this['bw_mask'] !== undefined ){
				
				this.bw_mask.destructor();
				
				delete this.bw_mask;
				
			}
			
		});
		
		
	};
	

	
	
	
})( window.bw = window.bw || {} );