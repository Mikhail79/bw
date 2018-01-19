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

header('HTTP/1.1 503 Service Temporarily Unavailable', true);

$seconds = 59;

$url = '';

$internals_url = '/internals';

if( class_exists('app') == true ){

	$url = app::$url;

	$internals_url = rtrim( app::$internals_url, '/' );

}

$request_uri = mb_substr( $_SERVER['REQUEST_URI'], 0, 8192 );
$redirect_url = rtrim( $url, '/' ) . '/' . ltrim( $request_uri, '/' );
$redirect_url = base64_encode( $redirect_url );

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
				background: url('<?=$internals_url;?>/includes/http_pages/maintenance.png') no-repeat center 30px;
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
			.timer {
				font-size: 30px;
			}
		</style>
		<script>
			var seconds = <?=$seconds;?>;

			var timer = null;

			var redirect_url = '<?=$redirect_url;?>';

			window.addEventListener('load', function(){

				timer = setInterval('timer_loop()',1000);

			});

			function timer_loop(){

				console.log(seconds);

				seconds--;

				if( seconds == 0 ){

					document.location = base64_decode( redirect_url );

					return;

				}

				document.getElementById('timer').innerHTML = seconds + ' сек.';
			}

			function base64_decode( str ){

				str = String( str );

				var arr = atob( str ).split('');

				arr = arr.map(function(c) {

					return '%' + ( '00' + c.charCodeAt(0).toString(16) ).slice(-2);

				});

				str = arr.join('');

				str = decodeURIComponent( str );

				return str;

			}
		</script>
	</head>
	<body>
		<div class="block">
			<h2>Сайт временно не работает!</h2>
			<p>Проводятся технические работы.</p>
			<p>Пожалуйста, попробуйте зайти позже.</p>
			<p style="margin-bottom: 30px;">Спасибо за понимание!</p>
			<p>Возможно, что через</p>
			<p id="timer" class="timer"><?=$seconds;?> сек.</p>
			<p style="margin-bottom: 30px;">сайт заработает.</p>
			<p>Страница обновится автоматически.</p>
		</div>
	</body>
</html>