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

header('HTTP/1.1 403 Forbidden', true);

$url = '';

$internals_url = '/internals';

if( class_exists('app') == true ){

	$url = app::$url;

	$internals_url = rtrim( app::$internals_url, '/' );

}

?><!doctype html>
<html lang="ru">
	<head>
		<meta charset="utf-8" />
		<title></title>
		<style>
			* {
				box-sizing: border-box;
				-moz-box-sizing: border-box;
				-webkit-box-sizing: border-box;
			}
			body {
				background: #eee;
				display: flex;
				align-items: center;
				justify-content: center;
				min-height: 100vh;
			}
			body, div, p, h2 {
				font-family: sans-serif;
				padding: 0;
				margin: 0;
			}
			.block {
				width: 640px;
				min-height: 300px;
				padding: 188px 30px 30px 30px;
				background: url('<?=$internals_url;?>/includes/http_pages/lock.png') no-repeat center 30px;
			}
			h2 {
				font-size: 20px;
				font-weight: bold;
				text-align: center;
				margin-bottom: 20px;
			}
			p {
				text-align: center;
				margin-bottom: 4px;
			}
		</style>
	</head>
	<body>
		<div class="block">
			<h2>Доступ запрещён (ошибка 403)</h2>
			<p>Доступ к странице/сервису по этому адресу<br />закрыт администрацией сайта.</p>
		</div>
	</body>
</html>