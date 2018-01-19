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


	bw.js_serial_load = function( list ){

		var i = 0;

		function load_js( js ){

			if( typeof js == 'function' ){

				js();

				i++;

				if( i in list ){

					load_js( list[ i ] );

				}

			}
			else if( typeof js == 'string' ) {

				var container = document.querySelector('body');
				var script = document.createElement('script');

				script.type = 'text/javascript';
				script.async = true;

				script.addEventListener('error', function(){

					i++;

					if( i in list ){

						load_js( list[ i ] );

					}

				});

				script.addEventListener('load', function(){

					i++;

					if( i in list ){

						load_js( list[ i ] );

					}

				});

				script.src = js;

				container.appendChild( script );

			}

		}


		if( i in list ){

			load_js( list[ i ] );

		}


	}


	/**
	 *
	 * @param list
	 */
	bw.js_parallel_load = function( list ){


		//
		// BEGIN
		//

		var groups = [];

		var i;
		var g;
		var item;
		var last_item = null;

		for( i = 0; i < list.length; i++ ){

			item = list[ i ];

			if( typeof item == 'function' ){

				g = groups.push( item );

			}
			else if( typeof item == 'string' ){

				if( typeof last_item == 'function' || last_item == null ){

					g = groups.push([]) - 1;

				}

				groups[ g ].push( item );

			}

			last_item = item;

		}


		//
		// END
		//


		g = 0;

		if( g in groups ){

			if( document.readyState != 'loading' ){

				loader( groups[ g ] );

			}
			else {

				document.addEventListener('DOMContentLoaded', function(){

					loader( groups[ g ] );

				});

			}


		}



		function get_path( url ) {

			var a = document.createElement('a');

			a.href = url;

			return a.pathname;

		}


		function check_result( list ){

			var finish = false;

			var i;

			var s = 0;

			for( i = 0; i < list.length; i++ ){

				if( list[ i ].error == true || list[ i ].loaded == true ){

					s++;

				}

			}

			if( s == list.length ){

				finish = true;

			}

			return finish;


		}


		function loader( list ){

			if( typeof list == 'function' ){


				list();

				g++;

				if( g in groups ){

					loader( groups[ g ] );

				}

			}
			else {

				var i;
				var js;

				var local_list = [];

				for( i = 0; i < list.length; i++ ){

					js = list[ i ];

					local_list.push({
						script: js,
						loaded: false,
						error: false
					});

				}


				for( i = 0; i < list.length; i++ ){

					js = list[ i ];

					if( typeof js == 'string' ){

						var container = document.querySelector('body');
						var script = document.createElement('script');

						script.type = 'text/javascript';
						script.async = true;

						script.addEventListener('error', function(){

							var path = get_path( this.src );

							var path2;

							var i;

							for( i = 0; i < local_list.length; i++ ){

								path2 = get_path( local_list[ i ].script );

								if( path2 == path ){

									local_list[ i ].error = true;

								}

							}


							var finish = check_result( local_list );

							if( finish == true ){

								g++;

								if( g in groups ){

									loader( groups[ g ] );

								}

							}


						});

						script.addEventListener('load', function(){

							var path = get_path( this.src );

							var path2;

							var i;

							for( i = 0; i < local_list.length; i++ ){

								path2 = get_path( local_list[ i ].script );

								if( path2 == path ){

									local_list[ i ].loaded = true;

								}

							}

							var finish = check_result( local_list );




							if( finish == true ){

								g++;

								if( g in groups ){

									loader( groups[ g ] );

								}

							}


						});

						script.src = js;

						container.appendChild( script );

					}


				}

			}



		}












	}


})( window.bw = window.bw || {} );