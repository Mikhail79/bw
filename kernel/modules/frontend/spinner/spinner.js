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
	
	
	/**
	 * TODO
	 *
	 * 1. Удаление спиннера с инпута.
	 */
	function class_spinner(){

		var spinner = this;

		var current_value = 0;

		this.default_value = 0;

		this.step = 1;

		this.min = null;

		this.max = null;

		// Спиннер.
		this.element = null;

		// Начальный элемент.
		this.base_element = null;

		// Инпут спиннера.
		this.input = null;

	//	this.onspinup = null;

	//	this.onspindown = null;

		// Атрибуты, которые будут перекопированы из элемента заглушки в input спиннера.
		this.copy_attrs = {};

		// Атрибуты, которые будут установлены в input спиннера.
		this.attrs = {};

		// Атрибуты data, которые будут установлены в input спиннера.
		this.data = {};



		/**
		 * Обработчик принимает old_value, new_value, type.
		 *
		 * type - источник события: mouse_wheel, input, arrow_up, arrow_down.
		 *
		 * onchange = function( old_value, new_value, type )
		 *
		 * Обработчик возвращает новое модифицированное значение или ничего не возвращает,
		 * тогда new_value будет переопределён.
		 */
		this.onchange = null;

		this.onafterchange = null;

		this.init = function(params){

			var default_params = {
				min: 0,
				max: null,
				step: 1,
				default_value: 0,
				onchange: null,
				onafterchange: null,
				copy_attrs: {},
				attrs: {},
				data: {}
			};

			params = bw.set_params( default_params, params );

			this.max = params.max;
			this.min = params.min;
			this.step = params.step;
			this.default_value = params.default_value;
			this.onchange = params.onchange;
			this.onafterchange = params.onafterchange;
			this.copy_attrs = params.copy_attrs;
			this.attrs = params.attrs;
			this.data = params.data;

			var html = '';

			var div = document.createElement('div');
			div.className = 'bw_spinner';

			html+= '<input type="text" value="' + this.default_value + '" />';
			html+= '<a href="#" class="up"></a>';
			html+= '<a href="#" class="down"></a>';


			div.innerHTML = html;

			this.element = div;

			//this.base_element.insertAdjacentHTML('afterend', html);

			var parent = this.base_element.parentNode;


			parent.insertBefore( div, this.base_element );


			var a_up = this.element.querySelector('.up');
			var a_down = this.element.querySelector('.down');
			this.input = this.element.querySelector('input[type="text"]');


			this.input.value = check_value( this.input.value );


			var k;

			for( k in this.data ){

				bw.dom( this.input ).data( k, this.data[k] );

			}


			for( k in this.attrs ){

				bw.dom( this.input ).set_attr( k, this.attrs[k] );

			}





			a_up.addEventListener('click', function(event){

				event.preventDefault();

				var value = Number( spinner.input.value ) + Number( spinner.step );

				value = check_value( value );

				if( typeof spinner.onchange === 'function' ){

				//	spinner.input.value = Number( spinner.input.value );

					// ! Number применять именно в вызове, иначе spinner.input.value вернёт строку.
					var modified_value = spinner.onchange( Number( spinner.input.value ), value, 'arrow_up' );

					if( typeof modified_value !== 'undefined' && isNaN( modified_value ) === false && modified_value !== null ){


						value = Number( modified_value );

					}

				}

				spinner.input.value = value;

				current_value = value;

				if( typeof spinner.onafterchange === 'function' ){

					spinner.onafterchange();

				}


			});


			a_down.addEventListener('click', function(event){

				event.preventDefault();

				var value = Number( spinner.input.value ) - Number( spinner.step );


				value = check_value( value );


				if( typeof spinner.onchange === 'function' ){

					//	spinner.input.value = Number( spinner.input.value );

					// ! Number применять именно в вызове, иначе spinner.input.value вернёт строку.
					var modified_value = spinner.onchange( Number( spinner.input.value ), value, 'arrow_down' );

					if( typeof modified_value !== 'undefined' && isNaN( modified_value ) === false && modified_value !== null ){

						value = Number( modified_value );

					}

				}


				spinner.input.value = value;


				current_value = value;

				if( typeof spinner.onafterchange === 'function' ){

					spinner.onafterchange();

				}


			});



			this.input.addEventListener('blur', function(event){

				this.value = check_value( this.value );

			});


			this.input.addEventListener('change', function(event){

				this.value = check_value( this.value );

				var old_value = Number( current_value );


				if( typeof spinner.onchange === 'function' ){

					var modified_value = spinner.onchange( old_value, Number( this.value ), 'input' );

					if( typeof modified_value !== 'undefined' && isNaN( modified_value ) === false && modified_value !== null ){

						this.value = Number( modified_value );

					}

				}





				current_value = Number( this.value );



				if( typeof spinner.onafterchange === 'function' ){

					spinner.onafterchange();

				}




			});

			if( div.addEventListener ) {

				if ('onwheel' in document) {

					// IE9+, FF17+, Ch31+
					div.addEventListener('wheel', mouse_wheel_handler);

				}
				else if ('onmousewheel' in document) {

					// устаревший вариант события
					div.addEventListener('mousewheel', mouse_wheel_handler);

				}
				else {

					// Firefox < 17
					div.addEventListener('MozMousePixelScroll', mouse_wheel_handler);

				}

			}
			else { // IE8-

				div.attachEvent('onmousewheel', mouse_wheel_handler);

			}





		//	bw.dom( this.base_element ).hide();

			if( this.base_element.tagName === 'INPUT' ){

				var attrs = [
					'id',
					'name',
					'style',
					'value'
				];

				var i;
				var attr;
				var val;

				for( i in attrs ){

					attr = attrs[ i ];

					if( attr === 'value' ){

						if( bw.dom( this.base_element ).has_attr('value') === true ){

							this.input.value = this.base_element.value;

						}


					}
					else {

						val = bw.dom( this.base_element ).attr( attr );

						if( val != null ){

							bw.dom( this.input ).attr( attr, val );

						}

					}


				}

			}

			parent.replaceChild( div, this.base_element );


		};

		function check_value( value ){

			if( typeof value === 'undefined' || isNaN( value ) === true ){

				value = spinner.default_value;

			}
			else {

				value = Number( value );

			}


			if( spinner.max !== null ){

				if( value > spinner.max ){

					value = spinner.max;

				}

			}

			if( spinner.min !== null ){

				if( value < spinner.min ){

					value = spinner.min;

				}

			}

			value = Number( value );


			return value;

		}


		// https://stackoverflow.com/questions/3515446/jquery-mousewheel-detecting-when-the-wheel-stops

		var mouse_wheel_handler = function( event ) {
			
			event = event || window.event;

			// wheelDelta не дает возможность узнать количество пикселей
//			var delta = event.deltaY || event.detail || event.wheelDelta;
			
			var scroll_direction = '';
			
			if( event.wheelDelta !== undefined ){
			
				if( event.wheelDelta < 0 ){
					
					scroll_direction = 'down';
					
				}
				else {
					
					scroll_direction = 'up';
					
				}
				
			
			}
			else if( event.deltaY !== undefined ){
			
			
				if( event.deltaY < 0 ){
					
					scroll_direction = 'up';
				
				}
				else {
					
					scroll_direction = 'down';
					
				}
				
			
			}
			
			
			// up
			if( scroll_direction === 'up' ){

				var value = Number( spinner.input.value ) + Number( spinner.step );

			}
			else { // down

				var value = Number( spinner.input.value ) - Number( spinner.step );
			}



			value = check_value( value );


			if( typeof spinner.onchange === 'function' ){

				//	spinner.input.value = Number( spinner.input.value );

				// ! Number() применять именно в вызове, иначе spinner.input.value вернёт строку.
				var modified_value = spinner.onchange( Number( spinner.input.value ), value, 'mouse_wheel' );

				if( typeof modified_value !== 'undefined' && isNaN( modified_value ) === false && modified_value != null ){

					value = Number( modified_value );

				}

			}


			spinner.input.value = value;


			if( typeof spinner.onafterchange === 'function' ){

				spinner.onafterchange();

			}

			current_value = value;
			
			
			event.preventDefault();
			
			//e.preventDefault ? e.preventDefault() : (e.returnValue = false);

		}


	}


	/**
	 *
	 * @param selector
	 * @param params
	 * @param index
	 */
	bw.spinner = function( selector, params, index ){

		if( typeof index === 'undefined' ){

			index = 0;

		}

		//index = parseInt( index );


		bw.foreach( selector, function(){

			var spinner = new class_spinner();

			spinner.base_element = this;

			spinner.init(params);

		});


	}


	/*

	window.addEventListener('scroll', function(event){

		var el = event.target || event.srcElement;


		var spinner = bw.dom(el).closest('.bw_spinner');

		if( spinner != null ){

			console.log(spinner);

		}





	});

	*/



})( window.bw = window.bw || {} );