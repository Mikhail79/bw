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
 * @var array $params Параметры, которые передаёт контроллер.
 */

$vars = [];

$html = '';

//app::load_module('frontend','kernel');


//
// BEGIN Сообщения.
//

$tdata = app::get_transit_data(false);

$messages = [];

if( is_array( $tdata['messages'] ) == true ){
	foreach( $tdata['messages'] as $message ){

		$messages[] = mes( $message[0], $message[1] );

	}
}

$vars['messages'] = $messages;

//
// END Сообщения.
//




//app::add_script( app::$kernel_url . '/other/jquery/jquery-2.2.1.min.js', 100000, true, 'head' );
app::add_script( app::$kernel_url . '/modules/main/functions.js', 10000 );
app::add_script( app::$interface_url . '/js/default.js' );

//app::add_style( app::$interface_url . '/css/fonts.css' );
app::add_style( app::$interface_url . '/css/default.css' );

$vars['current_year'] = date('Y');

$vars['back_url'] = base64_encode( app::$url . mb_substr( $_SERVER['REQUEST_URI'], 0, 10000 ) );


if( app::$page != null ){

	//
	// BEGIN Хлебные крошки
	//

	if( app::$page->breadcrumb_state == true && count( app::$page->bread_crumbs ) > 1 ){

		app::load_module('frontend','kernel','breadcrumb');

		$vars['breadcrumbs'] = breadcrumbs( app::$page->bread_crumbs, '', '&nbsp;/&nbsp;', true, false );
		$vars['breadcrumbs_str'] = breadcrumbs( app::$page->bread_crumbs, '', '<span class="separator"></span>', true, false );

	}

	//
	// END Хлебные крошки
	//


	app::$page->title = htmlspecialchars( app::$page->title, ENT_QUOTES | ENT_SUBSTITUTE );
	app::$page->description = htmlspecialchars( app::$page->description, ENT_QUOTES | ENT_SUBSTITUTE );
	app::$page->keywords = htmlspecialchars( app::$page->keywords, ENT_QUOTES | ENT_SUBSTITUTE );


	$vars['head'] = app::$page->get_head();

	$vars['h1'] = app::$page->seo_h1;

	$template = app::$page->template;
	$interface = app::$interface;
	$app_name = app::$name;

	$vars['content'] = app::$page->content;

}
else {

	if( count( $params['breadcrumbs'] ) > 0 ){

		app::load_module('frontend','kernel','breadcrumb');

		$vars['breadcrumbs'] = breadcrumbs( $params['breadcrumbs'], '', '&nbsp;/&nbsp;', true, false );
		$vars['breadcrumbs_str'] = breadcrumbs( $params['breadcrumbs'], '', '<span class="separator"></span>', true, false );

	}


	$vars['h1'] = $params['h1'];
	$vars['title'] = htmlspecialchars( $params['title'], ENT_QUOTES | ENT_SUBSTITUTE );
	$vars['description'] = htmlspecialchars( $params['description'], ENT_QUOTES | ENT_SUBSTITUTE );
	$vars['keywords'] = htmlspecialchars( $params['keywords'], ENT_QUOTES | ENT_SUBSTITUTE );

	$vars['content'] = $params['content'];

	$template = $params['template'];
	$interface = $params['interface'];



}


//
// BEGIN Блоки.
//


/*
$list = app::get_interface_blocks( $interface, $template, $app_name );

$vars['blocks'] = [];

foreach( $list as $position_name => $blocks ){

	foreach( $blocks as $block ){

		$vars['blocks'][ $position_name ][ $block->id ] = $block->get_html();

	}


}
*/

//$vars['blocks']['menu'] = app::include_block('menu');
//$vars['blocks']['mobile_menu'] = app::include_block('mobile_menu');

//$vars['blocks']['article_categories'] = app::include_block('kernel:articles/categories');


//
// END Блоки.
//



//
// BEGIN Обработка подключенных CSS/JS.
//

$vars['head_scripts'] = app::prepare_scripts( app::$scripts['head'], app::$config['merge_js'], app::$config['minimize_js'], $arr_url );
$vars['head_styles'] = app::prepare_styles( app::$styles['head'], app::$config['merge_css'], app::$config['minimize_css'] );

$vars['scripts'] = app::prepare_scripts( app::$scripts['default'], app::$config['merge_js'], app::$config['minimize_js'], $arr_url );
$vars['styles'] = app::prepare_styles( app::$styles['default'], app::$config['merge_css'], app::$config['minimize_css'] );

$vars['scripts_for_lazy_load'] = $arr_url;
$vars['scripts_for_async_load'] = $arr_url;

//
// END Обработка подключенных CSS/JS.
//



//
// BEGIN Консоль отладки.
//

//if( user_check_groups( app::$user->id, 'Administrators' ) == true ){

//	if( app::get_option('main.site_debug_console') ){

//$vars['debug_console'] = debug_console();

//	}

//}

//
// END Консоль отладки.
//



$vars['html_lang'] = 'ru';


//$vars['login'] = app::$user->login;
// Возможность HTML страницам видеть переменные Smarty.
//if( app::$page->store == 'html' ){
//	app::$page->content = app::$smarty->fetch('string:' . app::$page->content);
//}
// Возможность видеть переменные Smarty в заголовке страниц.
//app::$page->title = app::$smarty->fetch('string:' . app::$page->title);





header('Content-Type: text/html; charset=utf-8');

if( app::$page != null ){

	if( app::$page->interface_state == true ){

		$html = app::$tpl->fetch( $template, $vars );

	}
	else {

		$html = app::$page->content;

	}

}
else {


	$html = app::$tpl->fetch( $template, $vars );



}

$html = hide_external_links( $html );

$html = combine_scripts( $html );

//$html = remove_whitespace_from_html( $html );



//
// BEGIN Сжать контент перед выводом.
//

if( app::$config['output']['gzip'] == true && extension_loaded('zlib') == true ){

	if( strstr( $_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip' ) == false ){

		app::$config['output']['gzip'] = false;

	}

}

if( app::$config['output']['gzip'] == true ) {

	header('Content-Encoding: gzip');

	$html = gzencode( $html, app::$config['output']['level'] );

}

//
// END Сжать контент перед выводом.
//


echo $html;

?>