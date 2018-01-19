<?
// Конфигурационный файл приложения.

$config = [];

//
// BEGIN Описание приложения.
//

$config['details'] = [];

$config['details']['name'] = 'Приложение "Site".';

$config['details']['author'] = '';

$config['details']['description'] = '';

$config['details']['version'] = '1.0';

//
// END Описание приложения.
//

if( php_sapi_name() == 'cli' ){

	$config['controller'] = $_SERVER['PWD'] . '/' . $_SERVER['SCRIPT_NAME'];

	$config['controller_name'] = $_SERVER['SCRIPT_NAME'];

	$dir = dirname( $_SERVER['SCRIPT_NAME'] );

	if( $dir == '.' || $dir == '' ){

		$dir = $_SERVER['PWD'];

	}

	$_SERVER['DOCUMENT_ROOT'] = $dir;

	// $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
	// $_SERVER['HTTP_HOST']
	// $_SERVER['SERVER_PORT']

}
else {

	// TODO rename to entry_point
	$config['controller'] = $_SERVER['SCRIPT_FILENAME'];

	$config['controller_name'] = basename( $config['controller'] );

}


// Идентификатор приложения.
$config['name'] = 'site';

// Имя куки сессии.
$config['session_name'] = 'sid';

// Язык по умолчанию.
$config['language'] = 'ru';

// Интерфейс по умолчанию.
$config['interface'] = 'default';

// Страница по умолчанию.
// 0 - поле таблицы pages name или id.
// 1 - текстовый или числовой идентификатор.
// Переделать на default (page|service|controller)
// [ type => 'Тип', name => 'Название', ... ]
// Тип - page | service | controller
//$config['default_page'] = array( 'name', 'index' );
// TODO rename to default_controller
$config['default_page'] = [
	'type' => 'controller',
	'name' => 'main',
	//	'name' => 59,
	//	'id' => 0
];


// Список доступных языков. Пример ['ru','en','cn'].
$config['languages'] = [
	'ru'
];

// Список доступных интерфейсов. Названия директорий.
$config['interfaces'] = [
	'default',
	'winter',
	'summer',
];

// Мульти-язычность. Возможность переключать языки через переменную _language.
$config['ml'] = false;

// Мульти-интерфейсность. Возможность переключать интерфейсы через переменную _interface.
$config['mi'] = false;

// Системные переменные, которые нельзя устанавливать извне.
// Данные ключи будут затёрты в $_REQUEST до обработки роутинга.
$config['forbidden_vars'] = [
	//	'_inc',
	//	'_page',
	//	'_language',
	//	'_interface',
	//	'_sef',
	//	'_page',
	//	'_service',
	//	'_key',
	//	'_sid',
	// '_json',
	// '_sid'
];



//
// BEGIN Какие части системы подключать на этапе инициализации приложения.
//

// Какие подсистемы запустить до входа в контроллер/страницу/сервис.
$config['init_subsystems'] = [
	// TODO опция для отключения кэша через браузер.
	'cache' => false,
	// Включает или отключает создание объекта шаблонизатора.
	'template_engine' => true,
	// Включает или отключает запуск механизма сессий в процессе инициализации приложения.
	'sessions' => false,
	// Включает или отключает подключение в БД.
	// Например может быть не нужным использование БД для контроллеров, но тогда,
	// придётся вызвать предварительное подключение к БД, там где оно необходимо.
	'db' => false,
	'redis' => false,
];

//
// END Какие части системы подключать на этапе инициализации приложения.
//


// Для интервального учёта сессий.
$config['use_extra_sessions'] = false;


// file | redis
$config['cache_engine'] = 'file';

// file | database | redis
$config['session_engine'] = 'database';

// native | smarty | mixed
$config['template_engine'] = 'native';

// native | phpmailer
// native использует MTA.
// phpmailer умеет отправлять письма через SMTP с авторизацией, что даёт возможность отправлять письма с динамических IP.
$config['mail_engine'] = 'native';


// Список часовых поясов смотреть в документации PHP для
// функции date_default_timezone_set() или в классе ядра class_date.
$config['timezone'] = 'Asia/Yekaterinburg';

$config['check_ip'] = true;

//	$config['exception_handler'] = array('class_trace','exception_handler');
$config['exception_handler'] = null;

// $config['error_handler'] = array('class_trace','error_handler');
$config['error_handler'] = null;

$config['error_types'] = E_ALL | E_STRICT;


// Режим отладки.
// or dev_mode
// Если false, то будет выходить страница /internals/includes/http_pages/503.php в случае фатальной ошибки.
// Если true, то отладочная трассировка.
$config['debug'] = false;

$config['debug_ip'] = ['192.168.1.244'];

//
// BEGIN URL.
//

// Только домен, без протокола.
$config['domain'] = $_SERVER['HTTP_HOST'];

// URL сайта. Часто совпадает с root_url. Например "http://site.com/".
$config['url']	= ( $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http' ) . '://' . $config['domain'];

$config['canonical_url'] = 'https://site.ru';

// URL вещуший к контроллеру. Например "http://site.com/cp".
$config['root_url']	= ( $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http' ) . '://' . $config['domain'];

// URL контроллера. Например "http://site.com/cp/index.php".
$config['controller_url'] = $config['root_url'] . '/' . $config['controller_name'];

// URL к внутренностям (директории) приложения.
$config['internals_url'] = $config['root_url'] . '/internals';

// URL к модулям.
$config['modules_url'] = $config['root_url'] . '/internals/modules';

// URL к блокам.
$config['blocks_url'] = '/internals/blocks';

// URL текущего интерфейса.
$config['interface_url'] = $config['internals_url'] . '/interfaces/' . $config['interface'];

// URL путь к картинкам сайта.
$config['images_url'] = $config['interface_url'] . '/images';

// URL к директории ядра.
//$config['kernel_url'] = ( $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http' ) . '://' . $config['domain'] . '/kernel';
$config['kernel_url'] = '/kernel';


//
// END URL.
//

// При true, всегда будет вызываться secondary_init().
$config['always_full_init'] = true;

// Допустимые форматы:
// Название_сервиса
// [ Название_сервиса ]
// [ Название_сервиса, Приложение ]
$config['services'] = [

];

/**
 * Название_модуля
 * [ Название_модуля, Приложение ]
 */
$config['import_services'] = [
];


// Автозагружаемые модули.
// Название_модуля
// [ Название_модуля ]
// [ Название_модуля, Приложение ]
// [ Название_модуля, Приложение, Состояние_модуля ]
$config['autoload_modules'] = [

];


/**
 *
 * $item['name'] Имя для вызова контроллера.
 * $item['file']
 * $item['class']
 * $item['application']
 * $item['module']
 *
 * $config['controllers'][] = $item;
 *
 */
$config['controllers'] = [
	//	'main' => ['main.php','MainController'],
	[
		'name' => 'main',
		'file' => 'main.php',
		'class' => 'MainController',
	]
];


/**
 * Название_модуля
 * [ Название_модуля, Приложение ]
 */
$config['import_controllers'] = [
];


// При true, адрес /my/page/ и /My/Page/ - будут разными адресами.
$config['route_case_sensivity'] = false;

//
// BEGIN Routes. Имеет более высокий приоритет, чем правила из sef_url.
//

// Список модулей из которых будут импортированы адреса и обработчики адресов.
$config['import_routes'] = [
	//	'profile'
];

/**
 * Элемент массива, может быть строкой или массивом.
 * Если массив, первый элемент имя модуля, второй - имя приложения.
 */
$config['import_routes_rules'] = [
	//	'profile',
];

$config['routes'] = [];


$config['routes'][] = array(
	'url' => '/my-second-page/',
	'data' => [
		'_controller' => 'main',
		'_action' => 'second_page'
	]
);

/*
$config['routes'][] = array(
	'url' => '/uploader/',
	'data' => [
		'_controller' => 'main',
		'_action' => 'uploader'
	]
);
*/



$config['routes_rules'] = [];

/*
$config['routes_rules'][] = [
	'regexp' => '@^csv/download/(\d+).csv?@',
	'matches' => [
		1 => 'file_id'
	],
	'data' => [
		'_controller' => 'main',
		'_action' => 'download'
	]
];
*/

//
// END Routes. Имеет более высокий приоритет, чем правила из sef_url.
//


//
// BEGIN Настройка путей.
//

$config['dirs'] = [];

// Корневая директория сайта.
$config['dirs']['document_root'] = $_SERVER['DOCUMENT_ROOT'];

// Корневая директория приложения, где расположен скрипт (фронт-контроллер, диспетчер) приложения.
// Может отличаться от $_SERVER['DOCUMENT_ROOT'], если приложение размещено в поддиректории.
$config['dirs']['root'] = $config['dirs']['document_root'] . '';

// Директория приложения.
$config['dirs']['internals'] = $config['dirs']['root'] . '/internals';

// Закрытое хранилище для загрузок.
$config['dirs']['uploads'] = $config['dirs']['internals'] . '/uploads';

// Для закрытого кэша.
$config['dirs']['cache'] = $config['dirs']['internals'] . '/cache';

// Для лог файлов.
$config['dirs']['log'] = $config['dirs']['internals'] . '/log';

// Для обмена.
$config['dirs']['exchanger'] = $config['dirs']['internals'] . '/exchanger';

// Сервисы.
$config['dirs']['services'] = $config['dirs']['internals'] . '/services';

// Блоки.
$config['dirs']['blocks'] = $config['dirs']['internals'] . '/blocks';

// Страницы.
$config['dirs']['pages'] = $config['dirs']['internals'] . '/pages';

// Подключаемые страницы.
$config['dirs']['inc_pages'] = $config['dirs']['internals'] . '/inc_pages';

// Модули.
$config['dirs']['modules'] = $config['dirs']['internals'] . '/modules';

// Контроллеры.
$config['dirs']['controllers'] = $config['dirs']['internals'] . '/controllers';

// Интерфейсы.
$config['dirs']['interfaces'] = $config['dirs']['internals'] . '/interfaces';

// Сторонний код.
$config['dirs']['other'] = $config['dirs']['internals'] . '/other';

// Временные файлы.
$config['dirs']['tmp'] = $config['dirs']['internals'] . '/tmp';

// Словари с языковыми переменными.
$config['dirs']['dictionaries'] = $config['dirs']['internals'] . '/dictionaries';

// CLI.
$config['dirs']['cli'] = $config['dirs']['internals'] . '/cli';

// Для открытого кэша: сжатые css/js, нарезанные картинки.
$config['dirs']['pubcache'] = $config['dirs']['internals'] . '/pubcache';

// Любые подключаемые файлы.
$config['dirs']['includes'] = $config['dirs']['internals'] . '/includes';

//
// END Настройка путей.
//


$config['phpmailer'] = [];
$config['phpmailer']['user'] = '';
$config['phpmailer']['password'] = '';
$config['phpmailer']['host'] = '';
$config['phpmailer']['port'] = 465;

$config['use_phpmailer'] = true;

$config['admin_email'] = '';
$config['support_email'] = '';



// Тип визуального редактора по умолчанию, если явно не указан в полях типа FieldWysiwyg.
// native | tinymce3 | tinymce4
$config['wysiwyg'] = 'tinymce4';

// http://ulogin.ru/help.php#networks
$config['ulogin_networks'] = [];
$config['ulogin_networks']['vkontakte'] = 'ВКонтакте';
$config['ulogin_networks']['twitter'] = 'Twitter';
$config['ulogin_networks']['mailru'] = 'Mail.ru';
$config['ulogin_networks']['facebook'] = 'Facebook';
$config['ulogin_networks']['odnoklassniki'] = 'Одноклассники';
$config['ulogin_networks']['yandex'] = 'Яндекс';
$config['ulogin_networks']['google'] = 'Google';
$config['ulogin_networks']['steam'] = 'Steam';
$config['ulogin_networks']['soundcloud'] = 'Soundcloud';
$config['ulogin_networks']['lastfm'] = 'Last.FM';
$config['ulogin_networks']['linkedin'] = 'LinkedIn';
$config['ulogin_networks']['liveid'] = 'Live ID';
$config['ulogin_networks']['flickr'] = 'Flickr';
$config['ulogin_networks']['uid'] = 'uID';
$config['ulogin_networks']['livejournal'] = 'Живой журнал';
$config['ulogin_networks']['openid'] = 'Open ID';
$config['ulogin_networks']['webmoney'] = 'Webmoney';
$config['ulogin_networks']['youtube'] = 'Youtube';
$config['ulogin_networks']['foursquare'] = 'foursquare';
$config['ulogin_networks']['tumblr'] = 'tumblr';
$config['ulogin_networks']['googleplus'] = 'Google+';
$config['ulogin_networks']['dudu'] = 'dudu';
$config['ulogin_networks']['vimeo'] = 'Vimeo';
$config['ulogin_networks']['instagram'] = 'Instagram';
$config['ulogin_networks']['wargaming'] = 'Wargaming.net';


// {source} - файл источник
// {destination} - файл назначения
$config['yui_js_compressor'] = '/usr/bin/java -jar ' . app::$kernel_dir . '/other/yuicompressor-2.4.8.jar {source} -o {destination} --type js';

// {source} - файл источник
// {destination} - файл назначения
$config['yui_css_compressor'] = '/usr/bin/java -jar ' . app::$kernel_dir . '/other/yuicompressor-2.4.8.jar {source} -o {destination} --type css';

// Алгоритм минимизации CSS-файлов.
// yui | cssmin
$config['css_compressor_type'] = 'cssmin';

// Алгоритм минимизации JavaScript-файлов.
// yui | jsmin
$config['js_compressor_type'] = 'jsmin';

// Объединить CSS-файлы вставленные через app::add_style().
$config['merge_css'] = false;

// Минимизировать CSS-файлы вставленные через app::add_style().
$config['minimize_css'] = false;

// Объединить JavaScript-файлы вставленные через app::add_script().
$config['merge_js'] = false;

// Минимизировать JavaScript-файлы вставленные через app::add_script().
$config['minimize_js'] = false;

// Блок переопределения отдельных файлов модулей.
// Ключи можно посмотреть в файле .metadata/files.php или module/files.php
$config['overrides']['modules']['pages'] = [
	//	'list.tpl' => $config['dirs']['root'] . '/internals/interfaces/default/templates/custom_pages_list.tpl',
];


// При true, все внешние ссылки на странице будут спрятаны в javascript. Полезно для SEO.
$config['hide_external_links'] = false;

// Интервал уникальности хита.
$config['stat_visit_unique_time'] = 60;

// smsc.ru | sms.ru | twilio.com | plivo.com
$config['sms_provider'] = 'smsc.ru';


// Установить часовой пояс.
date_default_timezone_set( $config['timezone'] );

?>