<?

// Инициализируется в load_config
//$config = [];

// set_exception_handler(array('class_trace','catcher'));


// TS - Time Stamp
define('TS_WEEK', 604800);
define('TS_DAY', 86400);
define('TS_HOUR', 3600);
define('TS_MINUTE', 60);



//
// BEGIN REWRITABLE AREA applications
//

$config['applications'] = [
	'site',
];

//
// END REWRITABLE AREA applications
//


// Not used yet.
$config['servers'] = [];

/*

$config['servers'][0] = [
	'ip' => '127.0.0.1'
];

 */



// Глобальный список с обработчиками событий.
$config['event_listeners'] = [];


$config['document_root'] = $_SERVER['DOCUMENT_ROOT'];



// К основному подключению, можно обратиться следующими вариантами:
// 1) app::$db->select( $sql )
// 2) dbm::get(0)->select( $sql )
// 3) dbm::server(0)->select( $sql )
// 4) dbm::db(0)->select( $sql )
// 5) db(0)->select( $sql )
// А к дополнительным подключениям, по принципу 2, 3, 4 и 5. Причём индекс может быть и строкой.

// Настройка для подключения к БД.
$config['db'] = [];
$config['db']['tp'] = '';
$config['db']['host'] = 'localhost';
$config['db']['port'] = 3306;
$config['db']['db'] = '';
$config['db']['user'] = '';
$config['db']['password'] = '';
// TODO
$config['db']['persistent'] = false;

// Дополнительные базы данных (подключения).
// TODO Round robin принцип выбора сервера, через rr_NAME, но вызывать можно будет по NAME, rr_ отбрасывается
/*
$config['databases'] = [];
$config['databases']['slave']['tp'] = '';
$config['databases']['slave']['host'] = 'localhost';
$config['databases']['slave']['port'] = 3306;
$config['databases']['slave']['db'] = '';
$config['databases']['slave']['user'] = 'root';
$config['databases']['slave']['password'] = 'qwerty123';

$config['databases']['slave2']['tp'] = '';
$config['databases']['slave2']['host'] = 'localhost';
$config['databases']['slave2']['port'] = 3306;
$config['databases']['slave2']['db'] = '';
$config['databases']['slave2']['user'] = 'root';
$config['databases']['slave2']['password'] = 'qwerty123';
*/

$config['redis'] = [];
$config['redis']['host'] = '127.0.0.1';
$config['redis']['port'] = 6379;
$config['redis']['db'] = 0;
$config['redis']['user'] = '';
$config['redis']['password'] = '';
$config['redis']['persistent'] = false;

$config['redis_databases'] = [];

// native | phpredis | predis
$config['redis_engine'] = 'phpredis';

// Способ вывода.
// false - если нужно отключить или стоит модуль Apache mod_deflate.
$config['output']['gzip'] = false;
// Подавляющее большинство методик сжатия используют 6-й уровень сжатия
// (из 9-и возможных) для сбережения ресурсов процессора. Как правило,
// разница между 6-м и 9-м уровнем ничтожна, а сбереженные ресурсы системы весьма значительны.
// http://www.nestor.minsk.by/sr/2004/06/40612.html
$config['output']['level'] = 6;

// Определяет время жизни куки с идентификатором сессии.
// Неделя 604800
$config['session']['lifetime'] = 604800;

// Активность пользователя. Измеряется в секундах.
// Допустимое время от последнего обращения к серверу,
// в пределах которого пользователь считается он-лайн.
// Используется в session::get_online().
$config['online_interval'] = 60;

// Сессии

// Не имеет смысла, но всё же задано, так как в функциях по работе с сессиями
// $config['session']['lifetime'] используется напрямую.
ini_set('session.gc_maxlifetime',$config['session']['lifetime']);

// Устанавливает время жизни cookie (в секундах) в браузере.
// Если ноль, значит сессия будет жить пока браузер открыт, как закроется, браузер удалит эту куку.
// Примечание: expiry сессионной cookie не продляется.
ini_set('session.cookie_lifetime',$config['session']['lifetime']);

// Запретить или разрешить вставку SID в URL.
ini_set('session.use_trans_sid',0);

// Запретить автостарт механизма сессий.
ini_set('session.auto_start',0);

// Ошибки

// Виды отображаемых сообщений.
error_reporting(E_ALL & ~E_NOTICE);

// Если включена, последнее сообщение об ошибке
// всегда будет находиться в глобальной переменной $php_errormsg.
ini_set('track_errors',1);

// Отображать ошибки или нет.
// При тестировани - 1, при работе - 0.
ini_set('display_errors', 1);

// Должны ли сообщения об ошибках скриптов записываться в error log сервера.
ini_set('log_errors',1);

// Путь к лог-файлу php.
//ini_set('error_log',$config['dirs']['app'] . '/log/php.log');

// Даже когда display_errors включен, ошибки могут происходить во время запуска PHP и, чтобы
// о них было известно, рекомендуется включить.
// При тестировани - 1, при работе - 0.
ini_set('display_startup_errors',1);

// Безопасность

// Запретить файловым функциям работать с url.
ini_set('allow_url_fopen',0);

// Базовая директория для файловых функций.
//ini_set('open_basedir',$config['dirs']['root']);

// Прочие настройки.

// Кодировка по умолчанию для multibyte string функций.
mb_internal_encoding('utf-8');

// Установка локали, для корректной работы текстовых функций.
setlocale(LC_ALL, array ('ru_RU.UTF-8'));

setlocale(LC_NUMERIC, array('en_US.UTF-8'));

// Отключить автоматическое экранирование кавычек.
// Для избежания sql-injection атак в функциях по работе с БД,
// используется функция app::$db->prepare_sql().
ini_set('magic_quotes_runtime',0);

ini_set('magic_quotes_sybase',0);

//ini_set('register_globals',0);



?>