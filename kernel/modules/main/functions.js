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

	// Типы сообщений.

	// Позитивная информация, успешное выполнение операции.
	bw.MES_INFO = 2;

	// Ошибка, не удачное выполнение операции.
	bw.MES_ERROR = 1;

	// Важная информация, предупреждение, не критическая ошибка.
	bw.MES_WARN = 3;

	// Успешное выполнение операции.
	bw.MES_OK = 4;


	bw.debug = true;

	bw.data = bw.data || {};

	bw.module = bw.module || {};

	bw.in_array = function( val, arr ){

		var result = false;

		for( var i = 0; i < arr.length; i++ ){
			if( arr[i] == val ){
				result = true;
				break;
			}
		}

		return result;

	}


	bw.unset = function( arr, index ){

		arr.splice( index, 1 );

		return arr;

	}


	bw.get_hash = function(){

		var hash = location.hash.substring(1);

		if( hash == '' ) {

			hash = null;

		}

		return hash;

	}


	bw.implode = function( glue, arr ){

		return arr.join( glue );

	}


	bw.explode = function( delimeter, str ){

		if( typeof delimeter == 'undefined' ){

			delimeter = ',';

		}

		str = String(str);

		if( str == '' ) {

			return str;

		}

		return str.split( delimeter );

	}


	bw.set_hash = function( hash ){

		location.hash = hash;

	}


	bw.get_hash_as_object = function(){

		var data = {};

		var hash = this.get_hash();

		var matches = null;

		// var1=val1&var2=val2&...
		var regexp = /([^&;=]+)=?([^&;]*)/g;

		var key = null;

		if( hash != null ) {

			while (matches = regexp.exec(hash)) {


				key = _get_hash_as_object(matches[ 1 ]);

				data[ key ] = _get_hash_as_object(matches[ 2 ]);
			}

		}

		return data;

	}


	bw.add_data = function( params ){

		if( typeof params != 'object' ){
			params = {}
		}

		// Обработка полученных параметров.
		for( var name in params ){

			this.data[ name ] = params[ name ];

		}

		return this.data;

	}


	bw.set_params = function( default_params, params ){

		if( typeof default_params != 'object' ){
			default_params = {}
		}

		if( typeof params != 'object' ){
			params = {}
		}

		// Обработка полученных параметров.
		for( var name in default_params ){
			if( name in params ){
				default_params[ name ] = params[ name ];
			}
		}

		return default_params;

	}


	bw.get_browser = function() {

		var ua = navigator.userAgent;

		var list = {
			'MSIE': 'Internet Explorer',
			'Firefox': 'Firefox',
			'Opera': 'Opera',
			'Chrome': 'Google Chrome',
			'Safari': 'Safari',
			'Konqueror': 'Konqueror',
			'Iceweasel': 'Debian Iceweasel',
			'SeaMonkey': 'SeaMonkey',
			'Gecko': 'Gecko'
		};

		var browser_name = null;

		for( var key in list ){

			var re =  new RegExp(key);

			if( ua.search( re ) != -1) {

				browser_name = list[ key ];
				break;

			}

		}

		return browser_name;

	}


	bw.htmlspecialchars = function( html ) {

		html = html.replace(/&/g, '&amp;');
		html = html.replace(/</g, '&lt;');
		html = html.replace(/>/g, '&gt;');
		html = html.replace(/"/g, '&quot;');
		html = html.replace(/'/g, '&apos;');

		return html;

	}




	bw.base64_encode = function( str ){

		str = encodeURIComponent( str ).replace(/%([0-9A-F]{2})/g, function toSolidBytes(match, p1) {

			return String.fromCharCode('0x' + p1);

		});

		str = btoa( str );

		return str;


	}


	bw.base64_decode = function( str ){

		str = String( str );

		var arr = atob( str ).split('');

		arr = arr.map(function(c) {

			return '%' + ( '00' + c.charCodeAt(0).toString(16) ).slice(-2);

		});

		str = arr.join('');

		str = decodeURIComponent( str );

		return str;

	}



	bw.pluralize = function( num, one, two, many ){

		num = parseInt( Math.abs( num ) );

		remainder10 = num % 10;

		remainder100 = num % 100;

		if( remainder100 == 1 || ( remainder100 > 20 && remainder10 == 1 ) ){

			return one;

		}

		if( remainder100 == 2 || ( remainder100 > 20 && remainder10 == 2 ) ){

			return two;

		}

		if( remainder100 == 3 || ( remainder100 > 20 && remainder10 == 3 ) ){

			return two;

		}

		if( remainder100 == 4 || ( remainder100 > 20 && remainder10 == 4 ) ) {

			return two;

		}

		return many;

	}


	bw.strip_tags = function( str ){

		return str.replace(/<\/?[^>]+>/gi, '');

	}


	bw.bytes_to_str = function( bytes ){

		var megabyte = 1048576;
		var kilobyte = 1024;

		var str = '';

		bytes = parseInt( bytes );

		if( bytes < megabyte ){

			str = Math.round( bytes / kilobyte ) + ' Kb';

		}
		else if( bytes >= megabyte ){

			str = Math.round( bytes / megabyte ) + ' Mb';

		}

		return str;

	}


	bw.key_exists = function( key, object ){

		if( key in object && object[ key ] != null ){

			return true;

		}
		else{

			return false;

		}

	}


	/**
	 * Метод считает кол-во свойств (элементов) в объекте.
	 * Для объектов свойство length не предусмотрено.
	 *
	 * @param obj
	 * @returns {number}
	 */
	bw.obj_length = function( obj ){

		var count = 0;

		for( var key in obj ){
			count++;
		}

		return count;

	}


	/**
	 * Выравнивание элемента по центру экрана с позиционированием fixed/absolute.
	 *
	 * @param id
	 */
	bw.box_to_center = function( id ){

		var id = '#' + id;

		var w = bw.dom( id ).outerWidth(true);
		var h = bw.dom( id ).outerHeight(true);

		var sw = bw.dom( window ).width();
		var sh = bw.dom( window ).height();

		var left = sw / 2 - w / 2;
		var top = sh / 2 - h / 2;

		bw.dom( id ).css('left', left);
		bw.dom( id ).css('top', top);

	}


	bw.box_to_center2 = function( selector, offset ){

		if( typeof offset == 'undefined' ){

			offset = 0;

		}

		var w = bw.dom( selector ).outerWidth(true);


		var sw = bw.dom( window ).width();

		var left = sw / 2 - w / 2;
		var top = bw.dom(window).scrollTop() + offset;

		bw.dom( selector ).css('left', left);
		bw.dom( selector ).css('top', top);

	}


	/**
	 * Генерация HEX-кода цвета вида #000000-#FFFFFF
	 *
	 * @returns {string}
	 */
	bw.get_random_color = function() {

		var color = '#' + ( ( 1 << 24 ) * Math.random() | 0 ).toString(16);

		return color;

	}



	// TODO Оптимизировать.
	bw.stringify = function( data ){


		var arr = [];

		var str = null;

//		console.log(data);

		function stringify_helper( data, path ){

			if( data == null || data == undefined ){

				data = {}

			}

			if( data.constructor == Array ){

				for ( var i in data ) {

					i = encodeURIComponent( String( i ) );

					var value = data[ i ];

					if( value.constructor == Object || value.constructor == Array ){

						if( path == undefined ){

							stringify_helper( value, 'arr[' + i + ']' );

						}
						else {

							stringify_helper( value, path + '[]' );

						}


					}
					else {

						value = encodeURIComponent( String( value ) );

						if( path == undefined ){

							arr.push( 'arr[' + i + ']=' + value );

						}
						else {

							arr.push( path + '[]' + '=' + value );

						}

					}



				}


			}
			else if( data.constructor == Object ){

				for ( var key in data ) {

					key = encodeURIComponent( String( key ) );
					var value = data[ key ];

					if( value === undefined ){

						value = '';

					}

					if( value.constructor == Object || value.constructor == Array ){

						if( path == undefined ){

							stringify_helper( value, key );

						}
						else {

							stringify_helper( value, path + '[' + key + ']' );

						}


					}
					else {

						value = encodeURIComponent( String( value ) );

						if( path == undefined ){

							arr.push( key + '=' + value );

						}
						else {

							arr.push( path + '[' + key + ']' + '=' + value );

						}

					}

				}


			}

		}


		stringify_helper( data );



		if( arr.length > 0 ){

			str = arr.join('&');

		}

		return str;

	}




	bw.mt_rand = function( min, max ){
		var range = max - min + 1;
		var n = Math.floor( Math.random() * range ) + min;
		return n;
	}


	bw.load_css = function( href, container_selector ){

		if( container_selector == undefined ){

			container_selector = 'head';

		}

		var container = document.querySelector(container_selector);

		var link = document.createElement('link');
		link.rel  = 'stylesheet';
		link.type = 'text/css';
		link.href = href;
		link.media = 'all';

		container.appendChild(link);

	}



	// Вспомогательный массив, хранит скрипты загруженные через load_js().
	// Позволяет избежать ситуации, когда на странице несколько раз подряд вызывается load_js(), но ещё не был
	// загружен скрипт по первому вызову.
	var load_js_list = [];



	bw.load_js = function( src, container_selector, callback, ignore_previous ){


		if( typeof container_selector == 'undefined' ){

			container_selector = 'head';

		}

		var container = document.querySelector(container_selector);

		var exists = false;

		if( ignore_previous != true ) {

			var scripts = document.querySelectorAll('script');

			for ( var i = 0; i < scripts.length; i++ ) {

		//		console.log( scripts[ i ].src );

				// TODO Решить проблему когда передан адрес без хоста или относительный.
				if ( scripts[ i ].src == src ) {

					exists = true;
					break;

				}

			}

			/*


			if( exists == false ){

				load_js_list.push({
					src: src,
					loaded: false,
					error: false,
					callback: callback
				});

			}

			*/

		}


		var script_index = null;

		for( var i = 0; i < load_js_list.length; i++ ){

			if ( load_js_list[ i ].src == src ) {

				script_index = i;

				break;

			}

		}


		var add_script = false;

		if( script_index === null ){

			var index = load_js_list.push({
				src: src,
				loaded: false,
				error: false,
				callbacks: []
			});

			script_index = index - 1;

			add_script = true;

		}



		if( script_index !== null ){

			var item = {
				executed: false,
				callback: callback
			}

			load_js_list[ script_index ].callbacks.push( item );

		}




	//	console.log('I = ' + index, 'Exists ' + exists);



		if( script_index !== null ){

			var script = load_js_list[ script_index ];

			if( script.loaded == true ){

				for( var i = 0; i < load_js_list[ script_index ].callbacks.length; i++ ){

					if( load_js_list[ script_index ].callbacks[ i ].executed == false ){

						var func = load_js_list[ script_index ].callbacks[ i ].callback;

						if( typeof func == 'function'){

							load_js_list[ script_index ].callbacks[ i ].executed = true;

							func();

						}

					}


				}


			}


		}




		if( exists == true ){

			if( typeof callback == 'function'){

				callback();

			}

		}
		else if( add_script == true ) {

			var script = document.createElement('script');

			script.type = 'text/javascript';

			// При false, гарантируется порядок загрузки.
			script.async = false;

			script.addEventListener('error', function(){

				load_js_list[ script_index ].error = true;

				console.log('error');

			});

			script.addEventListener('load', function(){


//				console.log(load_js_list[ script_index ].callbacks);

				load_js_list[ script_index ].loaded = true;

				for( var i = 0; i < load_js_list[ script_index ].callbacks.length; i++ ){

					if( load_js_list[ script_index ].callbacks[ i ].executed == false ){

						var func = load_js_list[ script_index ].callbacks[ i ].callback;

						if( typeof func == 'function'){

							load_js_list[ script_index ].callbacks[ i ].executed = true;

							func();

						}

					}


				}


			});


			script.src = src;

			container.appendChild(script);

		}


	//	console.log(load_js_list);


	}




	// TODO Сделать под современные домены.
	bw.is_email = function( email ){

		var re = new RegExp( '^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,12}$', 'i');

		return re.test( email );

	}


	/**
	 * @deprecated
	 *
	 * @param selector
	 * @param height
	 */
	bw.fix_height = function( selector, height ){

		bw.dom( selector ).css( 'height', height + 'px' );

	}


	// Функция задаёт высоту по самому высокому элементу указанному в селекторе.
	bw.set_height = function( selector ){

		var max_height = 0;

		var list = bw.get_elements(selector);

		for( var i = 0; i < list.length; i++ ){

			var element = list[ i ];

			if( bw.dom(element).height() >= max_height ){

				max_height = bw.dom(element).height();

			}

		}

		/*
		$(selector).each(function(){
			if( bw.dom(this).height() >= max_height ){
				max_height = bw.dom(this).height();
			}
		});
		*/

		bw.dom(selector).height(max_height);

	}



	bw.bw_float_block = function( params ){

		var h2 = 0;
		var h = 0;
		var pos = null;

		var default_params = {}

		default_params['parent_id'] = '';
		default_params['element_id'] = '';
		default_params['offset'] = 0;

		var params = bw.set_params( default_params, params );

		h2 = bw.dom( params.parent_id ).outerHeight(true);
		h = bw.dom( params.element_id ).height();
		pos = bw.dom( params.parent_id ).position();

		var scroll_top = bw.dom(window).scrollTop();

		var top = 0;

		var max_top = pos.top + h2 - h - params.offset;
		var min_top = pos.top - params.offset;

		var max_padding_top = h2 - h;
		var min_padding_top = 0;

		if( scroll_top > max_top ){

			bw.dom( params.element_id ).removeClass('movable');

			if( bw.dom( params.parent_id ).hasClass('max_padding_top') == false ){
				bw.dom( params.parent_id ).addClass('max_padding_top');
				bw.dom( params.parent_id ).css('padding-top', max_padding_top );
			}

		}
		else if( scroll_top < min_top ){

			bw.dom( params.element_id ).removeClass('movable');

			if( bw.dom( params.parent_id ).hasClass('max_padding_top') == true ){
				bw.dom( params.parent_id ).removeClass('max_padding_top');
				bw.dom( params.parent_id ).css('padding-top', min_padding_top );
			}

		}
		else {

			bw.dom( params.element_id ).addClass('movable');

			if( bw.dom( params.parent_id ).hasClass('max_padding_top') == true ){
				bw.dom( params.parent_id ).removeClass('max_padding_top');
				bw.dom( params.parent_id ).css('padding-top', 0);
			}

		}

	}



	/**
	 * Функция устанавливает класс fixed_position для element.
	 *
	 * @param container Селектор элемента контейнера.
	 * @param element Селектор элемента.
	 */
	bw.set_fixed_position = function( container, element ){

		var pos = bw.dom(container).offset();

		var st = bw.dom(document).scrollTop();


		var bottom = pos.top + bw.dom(container).outerHeight() - bw.dom(element).outerHeight();


		var w = bw.dom(container).width();

		if( st >= pos.top && st < bottom ){

			if( bw.dom(element).hasClass('fixed_position') == false ){
				bw.dom(element).addClass('fixed_position');
				bw.dom(element).css({
					'width': w,
					'box-sizing': 'border-box'
				});
			}

			if( bw.dom(element).hasClass('bottom_fixed_position') == true ){
				bw.dom(element).removeClass('bottom_fixed_position');
			}


			if( bw.dom(container).hasClass('container_fixed_position') == true ){
				bw.dom(container).removeClass('container_fixed_position');
			}

		}
		else if( st >= bottom ){

			if( bw.dom(element).hasClass('bottom_fixed_position') == false ){
				bw.dom(element).addClass('bottom_fixed_position');
				bw.dom(element).css('width',w);
			}

			if( bw.dom(container).hasClass('container_fixed_position') == false ){
				bw.dom(container).addClass('container_fixed_position');
			}

			if( bw.dom(element).hasClass('fixed_position') == true ){
				bw.dom(element).removeClass('fixed_position');
			}

		}
		else {

			if( bw.dom(element).hasClass('fixed_position') == true ){
				bw.dom(element).removeClass('fixed_position');
			}

			if( bw.dom(element).hasClass('bottom_fixed_position') == true ){
				bw.dom(element).removeClass('bottom_fixed_position');
			}

			if( bw.dom(container).hasClass('container_fixed_position') == true ){
				bw.dom(container).removeClass('container_fixed_position');
			}

		}

	}

	bw.preg_match_all = function( regex, haystack ) {

	}


	bw.is_array = function( variable ){

		return variable instanceof Array;

	}



	bw.serialize_form = function( form ){


		var data = {};


		//var elements = bw.get_elements('input, select, textarea');

		bw.dom(form).foreach('input, select, textarea', function(){

			if( bw.dom(this).has_attr('name') == false ){

				return;

			}

			if( this.tagName == 'INPUT' ){

				if( bw.dom(this).attr('type') == 'checkbox' || bw.dom(this).attr('type') == 'radio' ){

					if( this.checked == false ){

						return;

					}

				}

			}

			var name = this.name;

			var matches = name.match(/\[(.*?)\]/gi);

			if( matches === null ){

				data[ name ] = this.value;

			}
			else {

				var i;

				var key;


				var next_key;


				var new_name = name.replace(/\[(.*?)\]/gi, '');



				//
				// BEGIN
				//

				next_key = matches[0];
				next_key = next_key.replace(/\[/gi, '');
				next_key = next_key.replace(/\]/gi, '');

				if ( next_key != '' ) {

					if ( ( new_name in data ) == false ) {

						data[ new_name ] = {};

					}

				}
				else {

					if ( ( new_name in data ) == false ) {

						data[ new_name ] = [];

					}

				}

				//
				// END
				//





				var prev_data = data[ new_name ];




				for( i = 0; i < matches.length; i++ ){

					key = matches[ i ];
					key = key.replace(/\[/gi, '');
					key = key.replace(/\]/gi, '');

					if( i + 1 < matches.length ) {

						next_key = matches[ i + 1 ];
						next_key = next_key.replace(/\[/gi, '');
						next_key = next_key.replace(/\]/gi, '');

						if( bw.is_array( prev_data ) == true ){

							if ( next_key != '' ) {

								key = prev_data.push( {} ) - 1;

							}
							else {

								key = prev_data.push( [] ) - 1;

							}

						}
						else {

							if ( next_key != '' ) {

								if( ( key in prev_data ) == false ) {

									prev_data[ key ] = {};

								}

							}
							else {

								if( ( key in prev_data ) == false ) {

									prev_data[ key ] = [];

								}


							}

						}




						prev_data = prev_data[ key ];

					}
					else {

						if( bw.is_array( prev_data ) == true ){

							prev_data.push( this.value );

						}
						else {

//							console.log('Z' + key, prev_data);

							prev_data[ key ] = this.value;

						}

					}


				}

			}

		});



		/*

		var fd = new FormData( form );


		// FormDataIterator
		var fdi_values = fd.values();
		var fdi_keys = fd.keys();

		var k;


		for( var k of fdi_keys ) {

			data[ k ] = fdi_values.next().value;

		}
		*/

		return data;

	}



	// Функция для выравнивания футера по нижнюю границу экрана.
	// Ф. учитывает высоту указанных элементов и
	// elements - массив с элементами (селекторы или id), которых нужно учесть.
	// element - Для этого элемента расчитывается min-height. Элемент, который будет расширен, чтобы
	// футер выровнился по границу экрана.
	bw.fix_footer = function( element, elements ){

		// Выровнять footer.
		// Высота клиентской области браузера.
		var screen_height = bw.dom(window).height();

		var sum_height = 0;

		for( var c = 1; c <= elements.length; c++ ){
			sum_height+= bw.dom( elements[ c - 1] ).outerHeight(true)
		}

		if( sum_height < screen_height ){

			var remainder = screen_height - sum_height;

			if( remainder > 0 ){
				// Получить чистую (без padding и margin) высоту области контента.
				var h = bw.dom(element).outerHeight(true) - ( bw.dom(element).outerHeight(true) - bw.dom(element).height() );
				bw.dom(element).css('min-height', ( h + remainder ) + 'px' );
			}
		}

	}
	
	
	/**
	 * Функция выделяет весь текст в указанном HTML-узле.
	 * @param selector
	 */
	bw.select_text = function( selector ){


		/*
		if( typeof selector === 'object' ){

			var el = selector;

		}
		else {

			var el = bw.get_element(selector);

		}
		
		*/
		
		var el = bw.get_element( selector );

		if( el == null ){
		
			return;
		
		}
		
		var range = document.createRange();
		
		range.selectNode(el);
		
		document.getSelection().addRange(range);

	}


	bw.select_text2 = function( selector, begin, end ) {
		
		begin = bw.intval( begin );
		
		end = bw.intval( end );
		
		var el = bw.get_element( selector );
		
		if( el == null ){
			
			return;
			
		}
		
		if( el.setSelectionRange !== undefined ){
			
			el.setSelectionRange( begin, end );
		
		}
		else if( el.createTextRange !== undefined ){
			
			var range = el.createTextRange();
			
			range.collapse(true);
			
			range.moveEnd('character', end);
			
			range.moveStart('character', begin);
			
			range.select();
		
		}
		else if( el.selectionStart !== undefined ){
			
			el.selectionStart = begin;
			el.selectionEnd = end;
		
		}
		
		
	}
	


	bw.is_touch = function () {
		try {
			document.createEvent('TouchEvent');
			return true;
		}
		catch (e) {
			return false;
		}
	}


	bw.prepare_body_class = function(){

		var w = bw.dom(window).width();

		var body_class = '';

		if( w >= 640 && w < 960 ){
			body_class = 'w640-960';
		}
		else if( w >= 480 && w < 639 ){
			body_class = 'w480-639';
		}
		else if( w < 479 ){
			body_class = 'w240-479';
		}

		if( bw.dom('body').hasClass( body_class ) == false ){

			bw.dom('body').removeClass('w640-960 w480-639 w240-479');

			bw.dom('body').addClass( body_class );

		}

	}


	bw.prepare_external_links = function(external_links){

		var list = bw.get_elements('.external-link');

		for( var i = 0; i < list.length; i++ ){

			var element = list[ i ];

			var key = bw.dom(element).data('key');

			if( key in external_links ){

				var href = this.base64_decode( external_links[ key ] );

				bw.dom(element).attr('href', href);

			}

		}

		/*
		$('.external-link').each(function(){
			var key = bw.dom(this).data('key');
			if( key in external_links ){
				var href = base64_decode( external_links[ key ] );
				bw.dom(this).attr('href', href);
			}
		});
		*/

	}



	bw.prepare_messages = function ( messages ){

		var css_class = '';
		var html = '';

		for( var i in messages ){

			var arr_mes = messages[ i ];

			switch( arr_mes[1] ){

				case bw.MES_INFO:

					css_class = ' info';

					break;

				case bw.MES_ERROR:

					css_class = 'bw_mes_error';

					break;

				case bw.MES_WARN:

					css_class = 'bw_mes_warning';

					break;

				case bw.MES_OK:

					css_class = 'bw_mes_ok';

					break;
			}

			html+= '<div class="' + css_class + '">';
			html+= arr_mes[0];
			html+= '</div>';

		}

		return html;

	}


	// TODO кроссбраузерность.
	bw.log = function (){



		if( this.debug == true ){

		//			console.log(arguments);

		}

	}


	bw.rand_str = function( len ){

		if( len == undefined ){

			len = bw.mt_rand(10, 16);

		}

		var str = '';

		var i = null;

		// TODO ![]{}()%&*$#^<>~@|
		var arr_chars = [
			// 0-9
			[ 48, 57 ],
			// A-Z
			[ 65, 90 ],
			// a-z
			[ 97, 122 ]
		];

		for ( c = 0; c < len; c++ ) {

			i = bw.mt_rand( 0, 2 );

			str += String.fromCharCode( bw.mt_rand( arr_chars[ i ][0], arr_chars[ i ][1] ) );

		}


		return str;

	}


	bw.set_random_password = function( selector ){

		bw.dom(selector).val( bw.rand_str( bw.mt_rand( 10, 16 ) ) );

	}


	// Флэшка YUI коверкает спецсимволы.
	bw.after_flash_uploader = function( json_data ){

		var re = /\r/g;
		json_data = json_data.replace(re, '\\r');

		var re = /\n/g;
		json_data = json_data.replace(re, '\\n');

		var re = /\t/g;
		json_data = json_data.replace(re, '\\t');

		json_data = jQuery.parseJSON(json_data);

		return json_data;

	}






	bw.transliterate = function( str ){

		var arr = {
			'а': 'a',
			'б': 'b',
			'в': 'v',
			'г': 'g',
			'д': 'd',
			'е': 'e',
			'ё': 'e',
			'ж': 'zh',
			'з': 'z',
			'и': 'i',
			'й': 'y',
			'к': 'k',
			'л': 'l',
			'м': 'm',
			'н': 'n',
			'о': 'o',
			'п': 'p',
			'р': 'r',
			'с': 's',
			'т': 't',
			'у': 'u',
			'ф': 'f',
			'х': 'kh',
			'ц': 'ts',
			'ч': 'ch',
			'ш': 'sh',
			'щ': 'shch',
			'ы': 'y',
			'э': 'e',
			'ю': 'yu',
			'я': 'ya',
			'ь': '',
			'ъ': '',
			' ': '-',
			'А': 'A',
			'Б': 'B',
			'В': 'V',
			'Г': 'G',
			'Д': 'D',
			'Е': 'E',
			'Ё': 'E',
			'Ж': 'Zh',
			'З': 'Z',
			'И': 'I',
			'Й': 'Y',
			'К': 'K',
			'Л': 'L',
			'М': 'M',
			'Н': 'N',
			'О': 'O',
			'П': 'P',
			'Р': 'R',
			'С': 'S',
			'Т': 'T',
			'У': 'U',
			'Ф': 'F',
			'Х': 'Kh',
			'Ц': 'Ts',
			'Ч': 'Ch',
			'Ш': 'Sh',
			'Щ': 'Shch',
			'Ы': 'Y',
			'Э': 'E',
			'Ю': 'Yu',
			'Я': 'Ya',
			'Ь': '',
			'Ъ': ''
		};


		var new_str = '';

		for( var i = 0; i < str.length; i++ ){

			var char = str[ i ];

			if( char in arr ){

				new_str+= arr[ char ];

			}
			else {

				new_str+= char;

			}

		}

		return new_str;
		
	}



	bw.is_number = function ( value ){

		return !isNaN( parseInt( value, 10 ) );

	}



	/**
	 * Выравнивание static-элемента по вертикали.
	 */
	bw.vert_align = function (el){

		el = '#' + el;

		var screen_height = bw.dom(window).height();
		var height = bw.dom(el).outerHeight(true);

		var margin_top = screen_height / 2 - height / 2;
		bw.dom(el).css('margin-top', margin_top);

	}


	bw.intval = function( val ){

		val = parseInt(val) || 0;

		return val;

	}

	bw.floatval = function( val ){

		val = val.replace(',','.');

		val = parseFloat(val) || 0;

		return val;

	}

	bw.generate_code = function( source, dest ){


		var str = this.transliterate( bw.dom(source).val() );

		// Удалить все лишние символы.
		//sef = sef.replace(/[^A-Za-zА-Яа-яЁё0-9\-]/ig, '');
		str = str.replace(/[^A-Za-z0-9\-]/ig, '');

		// Множественные тире, заменить на одно.
		str = str.replace(/\-+/ig, '-');

		// Перевести все символы в нижний регистр.
		str = str.toLowerCase();


		bw.dom(dest).val( str );

		return str;

	}


	bw.ajax = function( params ){

		var default_params = {
			method: 'POST',
			type: 'JSON',
			url: '',
			async: true,
			data: null,
			user: null,
			password: null,
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
				// Этот заголовок не использовать, так как код адаптирован под верхний заголовок.
				// При нижнем заголовке, система будет вести себя подругому.
				// 'Content-Type': 'application/json'
			},
			beforeSend: null,
			before: null,
			success: null,
			error: null,
			onreadystatechange: null,
			ontimeout: null
		};

		params = bw.set_params( default_params, params );

		var xhr = new XMLHttpRequest();


		if( typeof params.before == 'function' ){

			params.before( xhr );

		}

		if( typeof params.beforeSend == 'function' ){

			params.beforeSend( xhr );

		}


		xhr.ontimeout = function( event ){

			if( typeof params.ontimeout == 'function' ){

				params.ontimeout( event, this );

			}

		}

		xhr.onreadystatechange = function( event ){

			if( typeof params.onreadystatechange == 'function' ){

				params.onreadystatechange( event, this );

			}


			if( this.readyState == XMLHttpRequest.DONE ){


				if( this.status == 200 ){

					if( typeof params.success == 'function' ){

						var response = this.responseText;

						// Не работает
						// if( this.responseType == 'json' ){
						if( params.type.toUpperCase() == 'JSON' ){

							try {

								response = JSON.parse( this.responseText );

							}
							catch ( e ){

								console.log( e.message );

							}

						}

						params.success( response, this.statusText, this );


					}

				}

			}

		}

		if( params.user === null && params.password === null ) {

			xhr.open( params.method, params.url, params.async );

		}
		else if( params.user !== null && params.user === null ){

			xhr.open( params.method, params.url, params.async, params.user );

		}
		else if( params.user !== null && params.user !== null ){

			xhr.open( params.method, params.url, params.async, params.user, params.password );

		}


		for( var header in params.headers ){

			var value = params.headers[ header ];

			xhr.setRequestHeader( header, value );

		}

		if( params.type.toUpperCase() == 'JSON' ){

			xhr.send( bw.stringify( params.data ) );

		}
		else {

			xhr.send( params.data );

		}


	}


	bw.parse_str = function( str ){

		if( str == '' ){

			return {}

		}

		var pairs = str.split('&');

		var params = {};

		for( var i = 0; i < pairs.length; i++ ) {

			var couple = pairs[ i ].split('=');

			params[ couple[0] ] = couple[1];

		}


		return params;

	}


	bw.parse_url = function( url ) {

		var a = document.createElement('a');

		a.href = url;

		var parsed_url = {
			protocol: a.protocol,
			host: a.host,
			hostname: a.hostname,
			port: a.port,
			pathname: a.pathname,
			search: a.search,
			hash: a.hash,
			params: bw.parse_str( a.search.replace(/^\?/, '') )
		};

		return parsed_url;

	}


	bw.change_address = function( url ){

		if( typeof ( history.pushState ) != 'undefined' ){

			// https://developer.mozilla.org/en-US/docs/Web/API/History_API
			// https://developer.mozilla.org/ru/docs/Web/API/History/pushState
			history.pushState( {}, '', url );

		}
		else {

			// TODO url hash

		}

	}


	bw.round = function( number, precision ){

		if( typeof precision == 'undefined' ){
			precision = 0;
		}

		precision = parseInt( precision );

		var m = 0;

		if( precision > 0 ) {
			m = Math.pow( 10, precision );
			number = Math.round( number * m ) / m;
		}
		else {
			number = Math.round( number );
		}

		return number;

	}


	bw.htmlspecialchars_decode = function( html, flags ){

		html = html.toString();

		html = html.replace(/&lt;/g, '<');
		html = html.replace(/&gt;/g, '>');
		html = html.replace(/&quot;/g, '"');
		html = html.replace(/&apos;/g, "'");
		html = html.replace(/&#039;/g, "'");
		html = html.replace(/&amp;/g, '&');

		return html;

	}


	bw.ready = function( callback ){




		if( typeof callback != 'function' ){

			return;

		}




		if( document.readyState != 'loading' ){

			callback();

		}
		else {

			document.addEventListener('DOMContentLoaded', function(){

				callback();

			});

		}

	}

	bw.set_cookie = function( name, value, params ){

		var defaul_params = {
			encode: false,
			// Секунды.
			expires: 60,
			path: '',
			domain: '',
			secure: false
		};

		params = this.set_params( defaul_params, params );


		if( value === null ){

			value = '';

		}


		if( typeof params.expires === 'number' ) {

			var d = new Date();

			d.setTime( d.getTime() + params.expires * 1000 );

			params.expires = d;

		}

		var arr = [];

		arr[ arr.length ] = encodeURIComponent( name );
		arr[ arr.length ] = '=';

		if( params.encode == true ) {

			arr[ arr.length ] = encodeURIComponent( String( value ) );

		}
		else {

			arr[ arr.length ] = String( value );

		}


		arr[ arr.length ] = '; expires=' + params.expires.toUTCString();
		arr[ arr.length ] = '; path=' + params.path;
		arr[ arr.length ] = '; domain=' + params.domain;

		if( params.secure == true ){

			arr[ arr.length ] = '; secure';

		}

		document.cookie = this.implode( '', arr );

		return true;

	}


	bw.cookie_exists = function( name ){

		var arr = this.explode( ';', document.cookie );
		var i;
		var str;
		var arr_val = [];
		var exists = false;

		for( i = 0; i < arr.length; i++ ){

			str	= arr[ i ].trim();

			arr_val = this.explode( '=', str );

			if( arr_val[0] === name ){

				exists = true;
				break;

			}

		}

		return exists;

	}

	/**
	 *
	 * @param name
	 * @param data_type string | integer | float | boolean | object
	 */
	bw.get_cookie = function( name, data_type ){

		if( typeof data_type == 'undefined' ){

			data_type = 'string';

		}

		var arr = this.explode( ';', document.cookie );
		var i;
		var value = null;
		var str;
		var arr_val = [];

		for( i = 0; i < arr.length; i++ ){

			str	= arr[ i ].trim();

			arr_val = this.explode( '=', str );

			if( arr_val[0] === name ){

				if( data_type == 'integer' ){

					// TODO

				}
				else if( data_type == 'float' ){

					// TODO

				}
				else if( data_type == 'boolean' ){

					// TODO

				}
				else if( data_type == 'object' ){

					// TODO

				}
				else {

					value = arr_val[1];

				}

				break;

			}

		}

		return value;

	}

	/**
	 * Пока не используется, так как нет возможности прочитать метаданные для куки.
	 * @param name
	 */
	bw.get_cookie_data = function( name ){

		return null;

	}


	bw.delete_cookie = function( name ){

		this.set_cookie( name, '', { 'expires': -1 } );

		return true;

	}


	bw.foreach = function( selector, callback ){

		var list = bw.get_elements( selector );

		var i;

		if( typeof callback == 'function' ){

			for( i = 0; i < list.length; i++ ){

				callback.call(list[ i ]);

			}

		}

	}

	bw.number_format = function( number, decimals, dec_point, thousands_sep ) {

		var i, j, kw, kd, km;

		number = Number( number );

		if( decimals == undefined ){

			decimals = 2;

		}

		decimals = Math.abs( decimals );

		if( dec_point == undefined ){

			dec_point = '.';

		}

		if( thousands_sep == undefined ){

			thousands_sep = ' ';

		}

		i = parseInt( number = ( +number || 0 ).toFixed( decimals ) ) + "";

		if( ( j = i.length ) > 3 ){
			
			j = j % 3;
			
		}
		else{
			
			j = 0;
			
		}

		km = (j ? i.substr(0, j) + thousands_sep : "");

		kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);

		//kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");

		kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


		return km + kw + kd;

	}


	bw.mktime = function( hour, minute, second, month, day, year ){

		return new Date( year, month - 1, day, hour, minute, second, 0 ).getTime() / 1000;

	}
	
	
	bw.preg_quote = function( reg_exp ){
		
		var arr = [
			'.',
			'\\',
			'+',
			'*',
			'?',
			'[',
			'^',
			']',
			'$',
			'(',
			')',
			'{',
			'}',
			'=',
			'!',
			'<',
			'>',
			'|',
			':',
			'-'
		];
		
		//var re = new RegExp( '\\' + bw.implode('\\', arr ), 'g');
		var str = '(\\' + bw.implode('|\\', arr ) + ')';
		
		var re = new RegExp(str , 'g');
		
		reg_exp = reg_exp.replace( re, '\\$1' );
		
		return reg_exp;
		
	}
	



	bw.addslashes = function(str){
		
		str = String( str );
		
		str = str.replace(/\0/g,'\\0');
		
		str = str.replace(/\\/g,'\\\\');
		
		str = str.replace(/\'/g,'\\\'');
		
		str = str.replace(/\"/g,'\\"');
		
		return str;
		
	}
	
	
	/**
	 * Метод возвращает позицию (начало и конец) выделенного текста в input или textarea.
	 *
	 * @param el
	 * @returns {*}
	 */
	bw.get_selection_boundary = function( el ){
		
		var boundary = null;
		
		if( el.tagName === 'TEXTAREA' || ( el.tagName === 'INPUT' && el.type === 'text') ) {
			
			boundary = {
				begin: el.selectionStart,
				end: el.selectionEnd
			}
			
		}
		
		return boundary;
		
	}
	
	
	/**
	 * Метод возвращает выделенный текст в input или textarea.
	 */
	bw.get_selected_text = function( el ){
	
		
		
		if( el.tagName === 'TEXTAREA' || ( el.tagName === 'INPUT' && el.type === 'text') ) {
			
			var boundary = this.get_selection_boundary( el );
			
			var val = el.value.substring( boundary.begin, boundary.end );
			
			return val;
			
		}
	
	
	}
	
	
	
	
	
	
	
	
	
	
	/**
	 * Метод собирает ключи объекта первого уровня, и возвращает массив с ключами.
	 *
	 * TODO
	 * 1. Проверка obj.
	 */
	bw.array_keys = function( obj ){
	
		var arr = [];
		
		var k;
		
		for( k in obj ){
			
			arr.push( k );
			
		}
		
		
		return arr;
	
	}
	
	
	/**
	 * Функция возвращает положение курсора в input/textarea.
	 *
	 * @param el
	 * @returns {*}
	 */
	bw.get_cursor = function( el ) {
		
		var pos = null;
		
		if( el.tagName === 'TEXTAREA' || ( el.tagName === 'INPUT' && el.type === 'text' ) ){
			
			var val = el.value;
			
			pos = val.slice( 0, el.selectionStart ).length;
			
		}
		
		return pos;
		
	}
	
	
	
	
	bw.set_cursor = function( el, pos ){
		
		
		if( el.tagName === 'TEXTAREA' || ( el.tagName === 'INPUT' && el.type === 'text') ) {
			
			pos = bw.intval( pos );
			
			
			if( el.createTextRange !== undefined ){
				
				var textRange = el.createTextRange();
				
				textRange.collapse( true );
				
				textRange.moveStart('character', pos );
				//textRange.moveEnd('character', pos );
				
				textRange.select();
				
				el.focus();
				
				return true;
				
			}
			else if( el.setSelectionRange !== undefined ) {
				
				el.setSelectionRange( pos, pos );
			
				el.focus();
				
				return true;
				
			}
			else if( el.selectionStart !== undefined ){
				
				
				
				el.selectionStart = pos;
				el.selectionEnd = pos;
				
				
				el.focus();
				
				return true;
				
				
			}
			
			
		}
		
		return false;
		
	}


	/**
	 * Функция замещает часть строки на replacement с указанной позиции index.
	 *
	 * @param str
	 * @param index
	 * @param replacement
	 * @returns {string}
	 */
	bw.replace_string = function( str, index, replacement ){

		var new_str = '';

		new_str+= str.substring( 0, index );
		new_str+= replacement;
		new_str+= str.substring( index + replacement.length );

		return new_str;

	}

	/**
	 * Функция вставляет кусок текста в указанную позицию, сохраняя и раздвигая прежний текст.
	 *
	 * @param str
	 * @param index
	 * @param replacement
	 * @returns {string}
	 */
	bw.insert_string = function( str, index, replacement ){

		var new_str = '';

		new_str+= str.substring( 0, index );
		new_str+= replacement;
		new_str+= str.substring( index );

		return new_str;

	}

	
	
	//
	// BEGIN Private area.
	//

	function _get_hash_as_object( str ){

		var space = /\+/g;

		return decodeURIComponent( str.replace( space, ' ' ) );

	}

	//
	// END Private area.
	//


})( window.bw = window.bw || {} );