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


	bw.get_element = function( selector ){

		if( typeof selector === 'object'){
			
			return selector;
			
		}
		else {
			
			return document.querySelector( selector );
			
		}


	}


	bw.get_elements = function( selector ){


		if( typeof selector == 'object'){

			var arr = [];

			arr.push( selector );

			return arr;

		}
		else {

			return document.querySelectorAll( selector );

		}



	}


	function DOM(){

		var list = [];

		var element = null;

		this.selector = '';

		this.init = function( selector, index ){

			list = [];
			element = null;

			if( index === undefined ){

				index = 0;

			}
			else {

				index = parseInt( index );

			}

			if( isNaN( index ) == true ){

				index = 0;

			}


//			console.log(selector);

			if( bw.is_array( selector ) == true ){

				list = selector;

			}
			else if( typeof selector == 'object'){

				list.push( selector );

			}
			else {

				// document.querySelectorAll( selector );
				list = bw.get_elements( selector );

			}


		//	this.length = list.length;




			if( index in list ) {

				element = list[index];

			}




			this.selector = selector;




		}


		this.get_list = function(){

			return list;

		};


		this.foreach = function( selector, callback ){

			var list = bw.dom(element).find( selector );

			var i;

			if( typeof callback == 'function' ){

				for( i = 0; i < list.length; i++ ){

					callback.call(list[ i ]);

				}

			}

		}



		this.find = function( selector, index ){

			if( element === null ){

				return [];

			}

			if( typeof index != 'undefined'){

				index = parseInt(index);

				if( isNaN( index ) == true ){

					index = 0;

				}

				return element.querySelectorAll( selector )[ index ];

			}
			else {

				return element.querySelectorAll( selector );

			}



		}


		/**
		 * Возвращает 1 родителя указанного элемента.
		 */
		this.get_parent = function(){

			if( element === null ){

				return;

			}

			return element.parentNode;

		}


		this.parents = function( parent_selector ){

			return this.get_parents( parent_selector );

		}


		/**
		 * Метод возвращает цепочку родителей включая сам элемент, до parent_selector.
		 * Возвращает всю цепочку родителей указанного элемента.
		 * parent_selector - Если передать null, то функция найдёт всёх родителей.
		 *
		 * @param element_selector
		 * @param parent_selector
		 * @returns array
		 */
		this.get_parents = function( parent_selector ){

			var parents = [];

//			var element = element;

			var parent = bw.get_element( parent_selector );


			if( parent === undefined || parent === null ){

				// parent = document;
				parent = bw.get_element('html');

			}

			if( element === undefined || element === null ){

				return parents;

			}

			parents.push( element );

			while( element.parentNode ) {

				parents.push( element.parentNode );

				if( element.parentNode === parent ){

					break;

				}

				element = element.parentNode;

			}

			return parents;


		}




		/**
		 * Метод возвращает ближайший родительский элемент (или сам элемент),
		 * который соответствует заданному CSS-селектору или null,
		 * если таковых элементов вообще нет.
		 *
		 * @link https://developer.mozilla.org/ru/docs/Web/API/Element/closest
		 * @param el
		 */
		this.closest = function( parent_selector ){

			if( element === null ){

				return;

			}


			var parent = null;

			if( typeof element.closest != 'undefined' ){

				parent = element.closest( parent_selector );

			}
			else {

				var list = this.get_parents( parent_selector );

				try {

					for (var i = 0; i < list.length; i++) {

						var item = list[ i ];

						item.matches = item.matches || item.mozMatchesSelector || item.msMatchesSelector || item.oMatchesSelector || item.webkitMatchesSelector;

						if ( item.matches(parent_selector) == true ) {

							parent = item;

							break;

						}


					}

				}
				catch( e ){


				}


			}

			return parent;

		}


		this.children = function( index ){

			if( element === null ){

				return;

			}



			if( index != undefined ){


				index = bw.intval( index );



				/*
				var child = null;


				if( index in element.children ){

					child = element.children[ index ];

				}

				*/

				return element.children[index];

			}
			else {

				return element.children;

			}





		}


		this.index = function(){

			if( element === null ){

				return null;

			}


			var parent = element.parentNode;

			var index = Array.prototype.indexOf.call( parent.children, element );

			return index;

		}


		this.prev = function(){

			if( element === null ){

				return;

			}

			return element.previousElementSibling;

		}

		this.next = function(){

			if( element === null ){

				return;

			}

			return element.nextElementSibling;

		}





		this.has_attr = function( name ){

			if( element === null ){

				return;

			}

			return element.hasAttribute( name );

		}


		this.set_attr = function( name, val ){


			for( var i = 0; i < list.length; i++ ) {

				var el = list[i];

				el.setAttribute( name, val );

			}



		}


		this.get_attr = function( name ){

			if( element === null ){

				return;

			}

			return element.getAttribute( name );

		}

		this.remove_attr = function(){

			if( element === null ){

				return;

			}

			element.removeAttribute(name);

		}


		this.offset = function(){

			if( element === null ){

				return;

			}

			return element.getBoundingClientRect();

		}

		this.clone = function(){

			if( element === null ){

				return;

			}

			return element.cloneNode(true);

		}


		this.html = function( html ){

			//if( html != undefined && typeof html == 'String' ){
			if( arguments.length == 1 ){

		//		console.log(list);

				for( var i = 0; i < list.length; i++ ) {

					var el = list[ i ];

			//		console.log(el);

				//	$(el).html(html);

					el.innerHTML = html;

				}


			}
			else {

				if( element === null ){

					return;

				}


				return element.innerHTML;

			}

		}

		this.prepend = function( html ){

			if( element === null ){

				return;

			}

			return element.innerHTML = html + element.innerHTML;

		}

		this.append = function( html ){

			if( element === null ){

				return;

			}

		//	return element.innerHTML = element.innerHTML + html;


			element.insertAdjacentHTML('beforeend', html);

			// TODO заменить
//			$(element).append(html);

			return true;

		}


		this.add_class = function( class_name ){

			for( var i = 0; i < list.length; i++ ){

				var el = list[ i ];

				el.classList.add(class_name);

			}

		}




		this.remove_class = function( class_name ){

			for( var i = 0; i < list.length; i++ ) {

				var el = list[i];

				el.classList.remove(class_name);

			}

		}

		this.toggle_class = function( class_name ){

			for( var i = 0; i < list.length; i++ ) {

				var el = list[i];

				el.classList.toggle(class_name);

			}

		}


		this.toggleClass = function( class_name ){

			this.toggle_class( class_name );

		}

		/**
		 * https://developer.mozilla.org/ru/docs/Web/API/Element/classList
		 *
		 * @param class_name
		 */
		this.has_class = function( class_name ){

			if( element === null ){

				return;

			}

			return element.classList.contains(class_name);

		}


		this.remove = function(){

			for( var i = 0; i < list.length; i++ ) {

				var el = list[i];

				el.remove();

			}

		}


		this.val = function(){

			if( element === null ){

				return;

			}

			if( arguments.length == 1 ){

				element.value = arguments[0];

			}
			else {

				return element.value;

			}

		}




		/**
		 * Возвращает ширину элемента + padding, но без ширины scrollbar, border, margin.
		 */
		this.client_width = function(){

			if( element === null ){

				return;

			}

			return element.clientWidth;

		}


		/**
		 * Возвращает высоту элемента + padding, но без высоты scrollbar, border, margin.
		 */
		this.client_height = function(){

			if( element === null ){

				return;

			}

			return element.clientHeight;

		}


		/**
		 * Возвращает ширину элемента + padding + ширину scrollbar + border, но без margin.
		 */
		this.offset_width = function(){

			if( element === null ){

				return;

			}

			return element.offsetWidth;

		}


		/**
		 * Возвращает высоту элемента + padding + высоту scrollbar + border, но без margin.
		 */
		this.offset_height = function(){

			if( element === null ){

				return;

			}

			return element.offsetHeight;

		}


		this.scroll_width = function(){

			if( element === null ){

				return;

			}

			return element.scrollWidth;

		}
		
		
		/**
		 * функция возвращает высоту контента.
		 *
		 * @returns {*}
		 */
		this.scroll_height = function(){

			if( element === null ){

				return;

			}

			if( element === window || element === document ){

				var scrollHeight = Math.max(
					document.body.scrollHeight, document.documentElement.scrollHeight,
					document.body.offsetHeight, document.documentElement.offsetHeight,
					document.body.clientHeight, document.documentElement.clientHeight
				);

				return scrollHeight;

			}
			else {

				return element.scrollHeight;

			}


		}

		this.scrollTop = function(){

			if( element === null ){

				return;

			}

			if( arguments.length === 1 ){

				if( element === window || element === document ){

					document.documentElement.scrollTop = arguments[0];
					
					return document.documentElement.scrollTop;

				}
				else {

					element.scrollTop = arguments[0];

					return element.scrollTop;

				}

			}
			else {

				if( element === window || element === document ){

					return document.documentElement.scrollTop;

				}
				else {

					return element.scrollTop;

				}

			}

		}

		this.scrollLeft = function(){

			if( element === null ){

				return;

			}

			if( element === window || element === document ){

				return document.documentElement.scrollLeft;

			}
			else {

				return element.scrollLeft;

			}

		}


		this.innerWidth = function(){

			return this.client_width();

		}

		this.innerHeight = function(){

			return this.client_height();

		}

		this.outerHeight = function( include_margin ){

			var height = 0;

			if( element === null ){

				return;

			}

			height = element.offsetHeight;

			if( include_margin == true ){

				height+= parseFloat( window.getComputedStyle(element).marginTop.replace('px', '') );
				height+= parseFloat( window.getComputedStyle(element).marginBottom.replace('px', '') );

			}


			return height;

		}


		this.outerWidth = function( include_margin ){

			var width = 0;

			if( element === null ){

				return;

			}

			width = element.offsetWidth;

			if( include_margin == true ){

				width+= parseFloat( window.getComputedStyle(element).marginLeft.replace('px', '') );
				width+= parseFloat( window.getComputedStyle(element).marginRight.replace('px', '') );

			}

			return width;

		}


		/**
		 * Возвращает или устанавливает ширину элемента, без padding, border, margin, ширины scrollbar.
		 */
		this.width = function(){

			if( element === null ){

				return;

			}

			if( arguments.length == 1 ){

				this.css('width', arguments[0]);

			}
			else {

				var w = null;

				if( element == window ){

					w = document.documentElement.clientWidth;

				}
				else if( element == document ){

					w = document.body.clientWidth;

				}
				else {

					w = window.getComputedStyle(element).width;

				}

				w = String( w );

				w = w.replace( /px$/, '' );

				w = Number( w );

				return w;

			}

		}


		/**
		 * Возвращает или устанавливает высоту элемента, без padding, border, margin, высоты scrollbar.
		 */
		this.height = function(){

			if( element === null ){

				return;

			}

			if( arguments.length == 1 ){

				this.css('height', arguments[0]);

			}
			else {

				var h = null;

				if( element == window ){

					h = document.documentElement.clientHeight;

				}
				else if( element == document ){

					h = document.body.clientHeight;

				}
				else {

					h = window.getComputedStyle(element).height;

				}

				h = String( h );

				h = h.replace( /px$/, '' );

				h = Number( h );

				return h;


			}

		}


		this.css = function(){


			//
			// BEGIN Возврат стилей.
			//

			// Вернуть один указанный стиль.
			if( arguments.length == 1 ){

				if( typeof arguments[0] == 'string' ){

					if( element === null ){

						return;

					}



					if( arguments[0] in element.style ){

						return window.getComputedStyle(element)[ arguments[0] ];
						// return element.style[ arguments[0] ];

					}
					else {

						return null;

					}

				}

			}
			// Вернуть все стили.
			else if( arguments.length == 0 ){

				if( element === null ){

					return;

				}

				return window.getComputedStyle(element);

				//return element.style;

			}

			//
			// END Возврат стилей.
			//


			//
			// BEGIN Установка стилей.
			//

			for( var i = 0; i < list.length; i++ ) {

				var el = list[ i ];

				// Установить один стиль.
				if( arguments.length == 2 ){

					if( isNaN( arguments[1] ) == false ){

						el.style[ arguments[0] ] = arguments[1] + 'px';

					}
					else {

						el.style[ arguments[0] ] = arguments[1];

					}

				}
				// Установить несколько стилей.
				else if( arguments.length == 1 ) {

					if( typeof arguments[0] == 'object' ){

						for( var key in arguments[0] ){

							el.style[ key ] = arguments[0][ key ];

						}

					}

				}

			}

			//
			// END Установка стилей.
			//


		}


		this.position = function(){

			if( element === null ){

				return;

			}

			var pos = {
				left: element.offsetLeft,
				top: element.offsetTop
			}

			return pos;

		}


		this.offset = function(){

			if( element === null ){

				return;

			}

			var rect = element.getBoundingClientRect();

			var offset = {
				top: rect.top + document.body.scrollTop,
				left: rect.left + document.body.scrollLeft
			}

			return offset;

		}


		/**
		 * Для совместимости с jQuery.
		 */
		this.attr = function(){

			if( arguments.length == 2 ){

				this.set_attr( arguments[0], arguments[1] );

			}
			else {

				return this.get_attr( arguments[0] );

			}


		}

		/**
		 * Для совместимости с jQuery.
		 */
		this.data = function(){

			if( arguments.length == 2 ){

				this.set_attr( 'data-' + arguments[0], arguments[1] );

			}
			else {

				return this.get_attr( 'data-' + arguments[0] );

			}

		}


		/**
		 * Для совместимости с jQuery.
		 */
		this.hasClass = function( class_name ){

			return this.has_class( class_name );

		}

		this.removeClass = function( class_name ){

			this.remove_class( class_name );

		}



		this.addClass = function( class_name ){

			this.add_class( class_name );

		}


		this.is_displayed = function(){

			if( element === null ){

				return;

			}

			if( element.style.display == 'none' ){

				return false;

			}
			else {

				return true;

			}


		}

		this.toggle = function(){

			for( var i = 0; i < list.length; i++ ) {

				var el = list[ i ];


				var style = window.getComputedStyle(el);

				// show
				if( style.display == 'none' ){

					var css_display = bw.dom(el).get_attr('data-css-display');

					if (css_display !== null && css_display != '') {

						el.style.display = css_display;

					}
					else {

						el.style.display = 'block';

					}

				}
				// hide
				else {



					//bw.dom( el ).set_attr( 'data-css-display', el.style.display );

					if( style.display != 'none' ) {

						bw.dom(el).set_attr('data-css-display', style.display);

					}

					el.style.display = 'none';

				}





			}

		}


		/**
		 * В отличии от аналога jQuery, метод умеет корректно возвращать display, а не безрассудно ставить block.
		 */
		this.show = function(){


			var i;
			var el;
			var css_display;


			for( i = 0; i < list.length; i++ ) {

				el = list[ i ];

			//	console.log(el, list.length);

				css_display = bw.dom( el ).get_attr('data-css-display');

				if( css_display !== null && css_display != '' ){

					el.style.display = css_display;

				}
				else {

					el.style.display = 'block';

				}


				// Этот подход возвращает последнее состояние display.
				// Но это не подходит в случае, когда изначально none. Как браузер узнает корректный display?
				// В этой ситуации нужно использовать data-css-display, то есть закомментированный код выше.
			//	el.style.display = '';


			}

		}

		this.hide = function(){

			var i;
			var el;
			var style;


			for( i = 0; i < list.length; i++ ) {

				el = list[ i ];

//				console.log(el);


				style = window.getComputedStyle(el);

				//bw.dom( el ).set_attr( 'data-css-display', el.style.display );

				if( style.display != 'none' ) {

					bw.dom(el).set_attr('data-css-display', style.display);

				}

				el.style.display = 'none';


			}

		}

		this.addEventListener = function( type, listener, useCapture ){

			var i = 0;
			var el = null;

			for( i = 0; i < list.length; i++ ) {

				el = list[ i ];

				el.addEventListener( type, listener, useCapture );

			}


		}




	};

//	var dom = new DOM();

	bw.dom = function( selector, index ){

		var dom = new DOM();

		dom.init( selector, index );

		return dom;

	};

})( window.bw = window.bw || {} );


function dom( selector, index ){

	return bw.dom( selector, index );

}
