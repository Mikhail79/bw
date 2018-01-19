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


function tpl( $template, $vars = [] ){
	return load_template( $template, $vars );
}

function cut_sentence( $str, $offset = 0 ){
	$str = mb_substr( $str, 0, strpos( $str, ' ', $offset));
	return $str;
}

function mb_ucfirst( $str, $enc = 'utf-8' ) {
	$str = mb_strtoupper( mb_substr( $str, 0, 1, $enc ), $enc ) . mb_substr( $str, 1, mb_strlen( $str, $enc ), $enc );
	return $str;
}


function hide_external_links( $html, $domain = null ){

	if( $domain == null ){

		$domain = app::$config['domain'];

	}

	$matches = [];

	$pattern = '/<a.*?>.*?<\/a>/im';
	preg_match_all( $pattern, $html, $matches );

	//print_r($matches);

	$extrenal_links = [];

	foreach( $matches[0] as $i => $value ) {

		$arr = [];

		if( preg_match( '/href="(.*?)"/im', $value, $arr ) == true ){
			$parsed_url = parse_url( $arr[1] );
			if( array_key_exists('host',$parsed_url) == true ){
				if( $_SERVER['SERVER_NAME'] != $parsed_url['host'] && $parsed_url['host'] != $domain ){

					//	if( preg_match('/class="(.*?)"/im', $value, $arr2) == true ){
					//	}
					//	else {
					//	}

					$encoded_href = base64_encode( $arr[1] );
					$key = md5( $encoded_href );

					$extrenal_links[ $key ] = $encoded_href;

					$new_value = preg_replace( '/href=".*?"/im', 'href="#" data-key="' . $key . '" class="external-link"', $value );
					$html = preg_replace( '/' . preg_quote( $value, '/im' ) . '/', $new_value, $html );

				}
			}
		}

	}

	$html = preg_replace('/<\/body>/im','<script>var external_links = ' . json_encode( $extrenal_links ) . ';</script></body>', $html);






	return $html;

}


/**
 * Функция определяет, является ли клиент поисковым роботом (спайдером).
 *
 * @param string $browser
 * @param string $name
 * @return bool
 */
function is_bot( $browser = '', &$name = '' ){

	$bots = [
		'Googlebot',
		'SemrushBot',
		'Baiduspider',
		'YandexBot',
		'AhrefsBot',
		'bingbot',
		'Exabot',
		'alexa',
	];

	$browser = (string) $browser;

	$bot = false;

	$pattern = implode( '|', $bots );
	//	$pattern = preg_quote( $pattern, '/' );

	$pattern = '/bot|spider|' . $pattern . '/i';

	//	echo $pattern;

	if( preg_match( $pattern, $browser, $matches ) == true ){

		$bot = true;

		$name = htmlspecialchars( $matches[0] . ', ' . $browser, ENT_QUOTES | ENT_SUBSTITUTE );

	}



	return $bot;

}


function to_json( $params = null ){
	return json( $params );
}

function json( $params = null ){
	header('Content-type: application/x-json', true);
	return json_encode( $params );
}

function ajax( $params = null ){
	echo json( $params );
}

function ajax_response( $params = null ){

	if( app::$config['debug'] == true ){

		$params['debug'] = [];

		$params['debug']['id'] = randstr(10);
		$params['debug']['info'] = debug_console(true);

	}

	return ajax( $params );
}

// Обрамление для html данных вставляемых в XML ответ.
function cdata($content){
	return '<![CDATA[' . $content . ']]>';
}

/**
 *
 * @param str $type Тип ответа json или xml.
 * @param arr $params
 *
 * Для XML-ответа используется одномерный ассоциативный массив.
 *
 * $params['action'] = 'get_data';
 * $params['param1'] = '123';
 * $params['param2'] = 'abcde';
 *
 * На выходе получится.
 *
 * <answer>
 * 		<action><![CDATA[get_data]]></action>
 * 		<param1><![CDATA[123]]></param1>
 * 		<param2><![CDATA[abcdefg]]></param2>
 * </answer>
 */
function ajax_answer( $type = 'json', $params ){


	/**
	 * Типы сообщений.
	 * error Ошибка, не удачное выполнение операции.
	 * info Позитивная информация, успешное выполнение операции.
	 * warn Важная информация, предупреждение.
	 * ok Успешное выполнение операции.
	 */
	$messages_type = array('error','info','warn','ok');

	switch( $type ){
		case 'json':
			header('Content-type: application/x-json', true);
			return json_encode($params);
			break;
		case 'xml_answer':
			header('Content-Type: text/xml; charset=utf-8', true);

			if( in_array( $params['message_type'], $messages_type ) === false )
				$params['message_type'] = 'info';
			$xml = '<answer>';
			$xml.= '<action>' . $params['action'] . '</action>';
			$xml.= '<message type="' . $params['message_type'] . '">' . $params['message'] . '</message>';
			$xml.= '<data>' . $params['data'] . '</data>';
			$xml.= '</answer>';
			return $xml;
			break;
		case 'xml':
			header('Content-Type: text/xml; charset=utf-8', true);
			$xml = '<answer>' . "\n";
			foreach( $params as $key => $value ){
				$xml.= '<' . $key . '>' . cdata($value) . '</' . $key . '>'."\n";
			}
			$xml.= '</answer>';
			return $xml;
			break;
	}
}


function check_menu_item( $url ){

	$current_url = get_current_url();

	$r = compare_url( $current_url, $url, true );

	return $r;

}


/**
 * Сравнивает 2 адреса, причём порядок параметров может отличаться.
 *
 * Например эти два адреса эквивалентны.
 *
 * http://site.ru/?par1=val1&par2=val2 и http://site.ru/?par2=val2&par1=val1
 *
 * @todo Доработать для сравнения полного адреса. Сейчас в сравнение не попадает домен.
 *
 * @param $url1
 * @param $url2
 * @param boolean $strict При false, слэш в path не будет учитываться.
 * @return bool true - адреса эквивалентны
 */
function compare_url( $url1, $url2, $strict = false ){

//	echo $url1 . "<br>";
//	echo $url2 . "<br>";

	$parsed_url = parse_url( $url1 );
	$parsed_url2 = parse_url( $url2 );

	parse_str( $parsed_url['query'], $vars );
	parse_str( $parsed_url2['query'], $vars2 );

	asort( $vars );
	asort( $vars2 );

	$str = serialize( $vars );
	$str2 = serialize( $vars2 );


	if( array_key_exists( 'host', $parsed_url ) == false ){

		$parsed_url['host'] = $_SERVER['HTTP_HOST'];

		if( $strict == false ){

			$parsed_url['host'] = '';

		}

	}


	if( array_key_exists( 'host', $parsed_url2 ) == false ){

		$parsed_url2['host'] = $_SERVER['HTTP_HOST'];

		if( $strict == false ){

			$parsed_url2['host'] = '';

		}

	}


	if( $strict == false ){

		$parsed_url['path'] = trim( $parsed_url['path'], '/' );

		$parsed_url2['path'] = trim( $parsed_url2['path'], '/' );

	}


	if( md5( $str ) == md5( $str2 )
		&& md5( $parsed_url['path'] ) == md5( $parsed_url2['path'] )
		&& md5( $parsed_url['host'] ) == md5( $parsed_url2['host'] )
	){

		return true;

	}

	return false;

}


function get_current_url(){

	$current_url = ( $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	return $current_url;

}


/**
 * @param $password Пароль, переданный из формы авторизации.
 * @param $real_hash Хэш из БД от правильного пароля.
 * @param $real_salt Соль из БД от правильного пароля .
 * @return boolean true - пароли совпадают.
 */
function compare_password( $password, $real_hash, $real_salt ){

	$password = (string) $password;

	$hash = get_hash( $password, $real_salt );

	return ( $hash === $real_hash );

}

function get_hash( $password, &$salt = null ){

	if( $salt == null ){

		$salt = randstr(10);

		/*
		$salt = sha1( rand() );

		$salt = substr( $salt, 0, 4 );
		*/

	}

	// $hash = base64_encode( sha1( $password . $salt, true ) . $salt );

	$hash = sha1( sha1( $password . $salt ) . $salt );

	return $hash;

}


/**
 * Метод определяет MIME-тип файла.
 * @param $filename
 * @return bool|string
 * @link http://www.iana.org/assignments/media-types/index.html
 * @return boolean|string В случае, если файл не существует или не удалось определить MIME возвращает false.
 */
function get_mime( $filename ){

	if( is_file( $filename ) == true ){

		//	$finfo = finfo_open(FILEINFO_MIME_TYPE, '/usr/share/file/magic.mgc');
		//$finfo = finfo_open(FILEINFO_MIME_TYPE);

		//$finfo = new finfo(FILEINFO_MIME_TYPE,'/usr/share/file/magic.mgc');
		$finfo = new finfo(FILEINFO_MIME_TYPE);

		//$mimetype = finfo_file($finfo, $filename);
		$mimetype = $finfo->file( $filename );

		//  finfo_close($finfo);

		if( $mimetype === false ){

			return false;

		}

		return $mimetype;

	}
	else {

		return false;

	}

}


function is_image( $file, &$mime ){

	// Виды MIME для картинок.
	$arr_mime = [
		'image/gif',
		'image/jpeg',
		'image/jpg',
		'image/pjpeg',
		'image/bmp',
		'image/png'
	];

	$mime = get_mime( $file );

	return in_array( $mime, $arr_mime, true );

}



// В зависимости от указанного MIME, возвращает
// соответственное расширение для файла этого типа.
function mime2ext($mime){
	$ext = '';
	switch($mime){
		case 'image/gif': $ext = 'gif'; break;
		case 'image/jpeg': $ext = 'jpg'; break;
		case 'image/jpg': $ext = 'jpg'; break;
		case 'image/pjpeg': $ext = 'jpg'; break; // progressive jpeg
		case 'image/bmp': $ext = 'bmp'; break;
		case 'image/png': $ext = 'png'; break;
		case 'application/x-shockwave-flash': $ext = 'swf'; break;
	}
	return $ext;
}


function ext2mime($ext){
	$mime = '';
	switch(mb_strtolower($ext)){
		case 'gif': $mime = 'image/gif'; break;
		case 'jpg': $mime = 'image/jpeg'; break;
		case 'bmp': $mime = 'image/bmp'; break;
		case 'png': $mime = 'image/png'; break;

	}
	return $mime;
}

function t( $text, $params = [] ){

	$translated_text = '';

	foreach( app::$dictionaries as $language => $dictionaries ){

		foreach( $dictionaries as $dictionary ){

			$translated_text = $dictionary->translate( $text );

			if( $translated_text != '' ){

				break 2;

			}

		}

	}

	return $translated_text;

}



/**
 * $sender_host - Имя домена, с которого идёт проверка.
 * $sender_email - Адрес с которого будет происходить отправка.
 *
 * @param $email - Получатель, проверяемый e-mail.
 * @return bool
 */
function mailbox_exists( $email, $sender_host, $sender_email ){

	app::load_module( 'bw_net', 'kernel' );

	$exists = false;

	// is_email

	list( $mailbox, $host ) = explode( '@', $email );

	$records = dns_get_record( $host, DNS_MX );

	if( is_array( $records ) == true ){

		$mx = $records[0]['target'];

		$socket = new socket();
		$r = $socket->connect( $mx, 25 );


		if( $r == true ){


			$data = array(
				0 => '',
				1 => 'EHLO ' . $sender_host . "\r\n",
				2 => 'MAIL FROM: <' . $sender_email . '>' . "\r\n",
				3 => 'RCPT TO: <' . $email . '>' . "\r\n",
				4 => 'QUIT' . "\r\n"
			);

			foreach( $data as $i => $item ){

				$socket->write( $item );

				$str = $socket->read();

				//echo $str . "\n";

				if( $i == 3 ){

					$f = preg_match( '@^(\d{3}) @', $str, $matches );

					if( $f == true ){

						if( $matches[1] == 250 ){

							$exists = true;

						}


					}

				}

			}

		}


	}


	return $exists;

}

function sendmail( $from, $to, $subject = '', $message = '' ){

	$cmd = '/usr/sbin/sendmail -t -i -f ' . $from;

	$headers = [];
	$headers[] = 'To: ' . $to;
	$headers[] = 'From: ' . $from;
	$headers[] = 'Subject: ' . $subject;

	$fd = popen($cmd, 'w');

	if( $fd === false )
		return false;

	foreach( $headers as $header ){

		fputs($fd, $header . "\r\n");

	}

	fputs($fd, "\r\n");
	fputs($fd, $message);

	$r = pclose($fd);

	if( $r == -1 )
		return false;

	return true;

}

/**
 * Метод для удобной отправки письма по названию события.
 *
 * @param string|integer $name Соответствует полю name из таблицы mail_templates.
 * @param array $vars
 * @param array $params Параметры для переопределения почтового шаблона.
 *      $params['subject']
 *      $params['from']
 *      $params['message']
 * @return boolean true - Сообщение отправлено.
 *
 * app::send_mail( 'Активация', 'mail@yandex.ru', array( 'ip' => $_SERVER['REMOTE_ADDR'] ) );
 *
 */
function send_event( $name, $to, $vars = [], $subject = null, $from = null, $message = null, $attachments = [] ){

	if( is_array( $vars ) == false ){

		$vars = [];

	}

	$sql = 'SELECT * FROM ?_mail_templates WHERE id = ?d OR str_id = ?';

	/*
	if( is_int( $name ) == true ){

		$sql = 'SELECT * FROM ?_mail_templates WHERE id = ?d';

	}
	else {

		$sql = 'SELECT * FROM ?_mail_templates WHERE name LIKE ?';

	}
	*/

	$result = false;

	$mail_template = app::$db->selrow( $sql, $name, $name );


	if( $mail_template != null ){

		if( $from != null ){

			$mail_template['from'] = $from;

		}


		if( $subject != null ){

			$mail_template['subject'] = $subject;

		}

		if( $message != null ){

			$mail_template['message'] = $message;

		}

		$mail = new Mail();

		$error = false;

		if( is_array( $attachments ) == true ){

			foreach( $attachments as $attachment ){

				if( is_file( $attachment['path'] ) == true ){

					$content = read_file( $attachment['path'] );

					$mail->add_attachment( $content, $attachment['name'] );


				}
				else {

					$error = true;

				}

			}

		}


		if( $error == false ){

			$mail->from = $mail_template['from'];
			$mail->to = $to;
			$mail->subject = $mail_template['subject'];

		//	$mail->body = str_tpl( $mail_template['message'], $vars );

			$arr = [];

			foreach( $vars as $key => $value ){

				$arr[ '{' . $key . '}' ] = $value;

			}

			$mail_template['message'] = strtr( $mail_template['message'], $arr );

			$mail->body = $mail_template['message'];


			$result = $mail->send();


		}




	}
	else {

		$result = false;

	}




	return $result;

}


function is_ipv4( $ip ){

	$result = filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );

	if( $result === false ){

		return false;

	}

	return true;
}

function is_ipv6( $ip ){

	$result = filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 );

	if( $result === false ){

		return false;

	}

	return true;

}


/**
 * Метод проверяет URL.
 */
function is_url( $ext_url, $host_required = false ){

	$url_parts = @parse_url($ext_url);

	if( $url_parts === false)
		return false;

	$url = '';

	if( isset( $url_parts['scheme'] ) )
		$url.= $url_parts['scheme'] . '://';
	// TODO Возможно отвалится prepare_script & prepare_style.
	//	else
	//		$url.= 'http://';

	if( $host_required == true ){
		if( isset( $url_parts['host'] ) == false ){
			return false;
		}
	}

	if( isset( $url_parts['host'] ) )
		$url.= $url_parts['host'];

	if( isset( $url_parts['port'] ) )
		$url.= ':' . $url_parts['port'];

	if( isset( $url_parts['path'] ) )
		$url.= $url_parts['path'];

	if( isset( $url_parts['query'] ) )
		$url.= '?' . $url_parts['query'];

	if( isset( $url_parts['fragment'] ) )
		$url.= '#' . $url_parts['fragment'];

	//	echo $url . ' = ' . $ext_url . "<br>";

	if( $url == $ext_url ){
		return true;
	}
	else{
		return false;
	}

}


function is_url2( $url ){

	$url = (string) $url;

	if( $url == '' ){
		return false;
	}

	if( preg_match('/^http(s)?:\/\//', $url) == false ){
		$url = 'http://' . $url;
	}

	$parsed_url = mb_parse_url( $url );

	//	print_r($parsed_url);
	//	exit;

	if( array_key_exists( 'host', $parsed_url ) == false ){
		return false;
	}

	$parsed_url['host'] = preg_replace('/x32/','',$parsed_url['host']);

	if( array_key_exists( 'scheme', $parsed_url ) == false ){
		return false;
	}


	if( $url != unparse_url( $parsed_url ) ){
		return false;
	}

	return true;

}


/**
 * Проверяет формат.
 */
function is_datetime($datetime,$format = 1){
	$formats[0] = '\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d';
	$formats[1] = '\d\d\d\d-\d\d-\d\d';
	$formats[2] = '\d\d:\d\d:\d\d';
	$formats[3] = '\d\d:\d\d';
	$formats[4] = '\d\d\d\d/\d\d/\d\d \d\d:\d\d:\d\d';
	$formats[5] = '\d\d\d\d/\d\d/\d\d';
	$formats[6] = '\d\d/\d\d/\d\d\d\d';
	$formats[7] = '\d\d.\d\d.\d\d\d\d';


	$reg_exp = '@';
	$reg_exp.= $formats[ $format ];
	$reg_exp.= '@';

	if( preg_match($reg_exp, $datetime) == true ){
		return true;
	}

	return false;
}

/**
 * Проверка имени файла.
 */
function is_filename($filename){
	return ( preg_match('@^([a-z0-9_\-.]+)$@i',$filename) ? true : false );
}


/**
 * Проверка формата логина.
 */
function is_login($login){
	if( mb_strlen($login) > 50 || mb_strlen($login) < 2 ||  $login == '' )
		return false;
	return (preg_match('/^[a-zA-Z0-9]+([a-zA-Z0-9]*(\-|\_|\.)[a-zA-Z0-9]+)*$/',$login)) ? true : false;
}


/**
 * Проверка формата имени модуля.
 */
function is_modulename($module){
	return (preg_match('@^[\.a-z0-9_-]+$@i',$module)) ? true : false;
}

/**
 * Проверка имени компонента.
 */
function is_compname($module){
	return (preg_match('@^[\.a-z0-9_-]+$@i',$module)) ? true : false;
}

/**
 * Метод проверяет название приложения.
 */
function is_appname($appname){
	return (preg_match('@^[\.a-z0-9_-]+$@i',$appname)) ? true : false;
}

/**
 * Проверка формата имени сервиса.
 */
function is_servicename($service){
	return (preg_match('@^[\.a-z0-9_-]+$@i',$service)) ? true : false;
}


/**
 * Проверка формата имени страницы.
 */
function is_pagename($pagename){
	return (preg_match('@^[\.a-z0-9_-]+$@i',$pagename)) ? true : false;
}


/**
 * Проверка формата IP-адреса.
 * @deprecated
 */
function is_ip($ip){
	return (preg_match('/^([0-9]|[0-9][0-9]|[01][0-9][0-9]|2[0-4][0-9]|25[0-5])(\.([0-9]|[0-9][0-9]|[01][0-9][0-9]|2[0-4][0-9]|25[0-5])){3}$/',$ip)) ? true : false;
}


/**
 * Проверка формата числового идентификатора БД.
 */
function is_id($id){
	return (preg_match('/^[0-9]+$/',$id)) ? true : false;
}


/**
 * Проверка формата номера TCP-порта
 */
function is_port($port){
	if(preg_match('/^[0-9]{1,5}$/',$port)){
		if($port >= 1 && $port <= 35536){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}


/**
 * Проверка формата префикса таблиц БД.
 */
function is_prefix($prefix){
	return (preg_match('/^[a-zA-Z0-9]*[_]{0,1}$/',$prefix)) ? true : false;
}


/**
 * Проверка формата названия БД.
 */
function is_db($db){
	return (preg_match('/^[a-zA-Z0-9]+([a-zA-Z0-9]*(\-|\_)[a-zA-Z0-9]+)*$/',$db)) ? true : false;
}


/**
 * Проверка буквы.
 */
function is_rus_letter($letter){
	$letter = mb_strtoupper($letter);
	return (in_array($letter,array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ы','Э','Ю','Я')))? true : false;
}


/**
 * Это число.
 */
function is_number($num){
	return (preg_match('/^-?\d+[\.|\,]?\d+$/',$num)) ? true : false;
}


/**
 * Проверка формата ключа.
 */
function is_key($key, $length = 50){
	return (preg_match('/^[a-z0-9]{' . $length . '}$/i',$key)) ? true : false;
}

/**
 * Проверка формат токена.
 */
function is_token($key, $length = 50){
	return (preg_match('/^[a-z0-9]{' . $length . '}$/i',$key)) ? true : false;
}

/**
 * Проверяет является ли указанный адрес электронной почты верным.
 */
function is_email($email){

	//return (preg_match('/^[a-z0-9]+([a-z0-9]*(\.|\-|\_)[a-z0-9]+)*\@[a-z0-9]+([a-z0-9]*(\.|\-)[a-z0-9]+)*\.[a-z]{2,10}$/i',$email)) ? true : false;

	$result = filter_var( $email, FILTER_VALIDATE_EMAIL );

	if( $result === false ){

		return false;

	}

	return true;

}




function num_in_range( $num, $min, $max ){

	$num = (float) $num;

	$in_range = false;

	if( $num >= $min && $num <= $max ){
		$in_range = true;
	}

	return $in_range;

}


function str_len_in_range( $str, $min, $max ){

	$length = mb_strlen( $str );

	$in_range = false;

	if( $length >= $min && $length <= $max ){
		$in_range = true;
	}

	return $in_range;

}




function is_captcha( $value = '' ){
	$value = (string) $value;
	return (boolean) preg_match( '/[0-9a-z]{5,6}/', $value );
}




/**
 * Простое шифрование по ключу.
 */
function simple_crypt($string='', $decrypt = false, $key = ''){
	// TODO вынести в настройки
	$default_key = 'HUSdh482dy39dhcd89se8';

	if( $key == '' )
		$key = $default_key;

	if( $string == '' )
		return false;

	//Создание вектора инициализации для дополнительной безопасности
	$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);

	if( $decrypt === true ){
		$string = hex2bin($string);
		// decrypted string
		$string = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB, $iv);
		$string = trim($string);
	}
	else{
		// Шифрование. encrypted string
		$string = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB, $iv);
		// Преобразованная строка в HEX.
		$string = bin2hex($string);
	}

	return $string;

}


// TODO Warning
function _dir( $path, $application = null ){

	$chains = explode( '/', $path );

	$full_path = false;

	if( is_array( $chains ) == true && count( $chains ) > 0 ){

		$dir = array_shift( $chains );

		if( array_key_exists( $dir, app::$config['dirs'] ) == true ){

			$full_path = [];

			$full_path[] = app::$config['dirs'][ $dir ];

			foreach( $chains as $chain ){

				$full_path[] = $chain;

			}

			$full_path = implode( '/', $full_path );

		}

	}


	return $full_path;

}

/**
 * Функция сравнивает массив array1 с массивом array2,
 * если различия имеются возвращает массив разницу.
 *
 * Если точнее, то возвращённый массив будет содержать те значения
 * массива array1, которых нет в массиве array2 и те значения,
 * массива array2, которых нет в массиве array1.
 *
 * Функция работает более логично, чем array_diff.
 *
 **/
function array_compare($array1,$array2){
	// Массивы имеют одинаковое кол-во элементов.
	$diff[0] = []; // Те значения массива array2, которых нет в массиве array1.
	$diff[1] = []; // Те значения массива array1, которых нет в массиве array2.

	$length1 = count($array1);
	$length2 = count($array2);

	for($c=0;$c<$length1;$c++){
		$exist = false;
		for($x=0;$x<$length2;$x++){
			if($array1[$c]==$array2[$x]) $exist = true;
		}
		if($exist==false) array_push($diff[1],$array1[$c]);
	}

	for($c=0;$c<$length2;$c++){
		$exist = false;
		for($x=0;$x<$length1;$x++){
			if($array2[$c]==$array1[$x]) $exist = true;
		}
		if($exist==false) array_push($diff[0],$array2[$c]);
	}

	return $diff;
}


/**
 * Аналог функции cal_days_in_month().
 */
function days_in_month($month, $year) {
	return date('t', strtotime($year . '-' . $month . '-01'));
}


/**
 * TODO обработка дробных чисел
 *
 * Функция переводит строчное представление времени в секунды.
 *
 * @param $text
 * @param $default_type Если не удалось определить тип, тогда значение воспринимается, как $default_type.
 * @return int Возвращает секунды.
 */
function time_detector( $text, $default_type = 'second' ){

	$arr_time = [];

	$text = (string) $text;

	$arr_units = [
		'second' => ['second','sec','секунд','сек','s','с'],
		'minute' => ['minute','min','минут','мин'],
		'hour' => ['час','hour','ч','hr','h'],
		'day' => ['day','день','д'],
//		'month' => ['month','месяц','мес'],
//		'year' => ['year','yr','год','г','лет','л'],
//		'week' => ['week','wk','неделя','нед'],
	];

	$units = [];

	foreach( $arr_units as $item ){
		$units[] = implode('|', $item);
	}

	$units = implode( '|', $units );


	$text = preg_replace('/\d+|' . $units . '/iu',' $0 ',$text);
	$text = preg_replace('/\s+/',' ',$text);

	$matches = [];

	$result = preg_match_all( '/(\d+)\s(' . $units .')?/iu', $text, $matches, PREG_SET_ORDER );

	if( $result !== false ){

		foreach( $matches as $match ){

			$type = $default_type;

			// Найти тип.
			if( array_key_exists( 2, $match ) == true ){
				foreach( $arr_units as $key => $arr_unit ){
					if( in_array( $match[2], $arr_unit, true ) == true ){
						$type = $key;
						break;
					}
				}
			}

			$arr_time[] = [
				'unit' => $type,
				'value' => intval( $match[1] )
			];

		}

	}

//	app::cons($arr_time);

	return $arr_time;

}


function get_seconds( $text, $default_type = 'second' ){

	$arr_time = time_detector( $text, $default_type );

	$seconds = 0;

	foreach( $arr_time as $item ){

		if( $item['unit'] == 'second' ){
			$seconds += $item['value'];
		}
		else if( $item['unit'] == 'minute' ){
			$seconds += $item['value'] * 60;
		}
		else if( $item['unit'] == 'hour' ){
			$seconds += $item['value'] * 3600;
		}
		else if( $item['unit'] == 'day' ){
			$seconds += $item['value'] * 86400;
		}
		/*
		else if( $item['unit'] == 'month' ){
			$seconds += $item['value'] * 3600;
		}
		else if( $item['unit'] == 'year' ){
			$seconds += $item['value'] * 3600;
		}
		else if( $item['unit'] == 'week' ){
			$seconds += $item['value'] * 3600;
		}
		*/

	}

	return $seconds;

}

/**
 * Выводит интервал между датами.
 * Нижний порог даты 01.01.1970.
 * 365 суток в невисокосные годы и 366 суток в високосные годы
 *
 * TODO вычисление времени (часы, минуты, секунда).
 *
 * @link http://php.net/manual/en/function.date-diff.php
 *
 * @param str / int $begin Unix timestamp или YYYY-MM-DD HH:MM:SS
 * @param str / int $end Unix timestamp или YYYY-MM-DD HH:MM:SS
 * @return arr Остаток переносится на меньшую единицу времени.
 * 		seconds - разница в секундах.
 * 		minutes - разница в полных минутах.
 * 		hours - разница в полных часах.
 * 		days - разница в полных днях.
 * 		months - разница в полных месяцах.
 * 		years - разница в полных годах.
 */
function date_difference( $begin = 0, $end = 0 ){

	$diff = [];
	$diff['seconds'] = 0;
	$diff['minutes'] = 0;
	$diff['hours'] = 0;
	$diff['days'] = 0;
	$diff['months'] = 0;
	$diff['years'] = 0;

	if( $begin == 0 ){
		$begin = time();
	}

	if( $end == 0 ){
		$end = time();
	}

	//if( ($ts_end < $ts_begin) && is_int($begin) && is_int($end) )
	//	var_flip( $ts_end, $ts_begin );


	if( is_int( $begin ) == true ){

		$datetime1 = date_create( date('Y-m-d H:i:s', $begin) );

	}
	else {

		$datetime1 = date_create( $begin );

	}

	if( is_int( $end ) == true ){

		$datetime2 = date_create( date('Y-m-d H:i:s', $end) );

	}
	else {

		$datetime2 = date_create( $end );

	}

//		error_log( $begin );
//		error_log( $end );


	$interval = date_diff( $datetime1, $datetime2 );

	list(
		$diff['years'],
		$diff['months'],
		$diff['days'],
		$diff['hours'],
		$diff['minutes'],
		$diff['seconds']
		) = explode( '-', $interval->format('%Y-%m-%d-%H-%i-%s') );

	foreach( $diff as $i => $value ){

		$value = intval( $value );

		$diff[ $i ] = $value;

	}

	return $diff;

}


function parse_date( $date ){

	$arr['year'] = null;
	$arr['month'] = null;
	$arr['day'] = null;
	$arr['hours'] = null;
	$arr['minutes'] = null;
	$arr['seconds'] = null;

	if( preg_match('@^\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d$@', $date) == true ){ // DATETIME

		list( $d, $t ) = explode(' ', $date);

		list( $arr['year'], $arr['month'], $arr['day'] ) = explode('-', $d);
		list( $arr['hours'], $arr['minutes'], $arr['seconds'] ) = explode(':', $t);

	}
	if( preg_match('@^\d\d\.\d\d\.\d\d\d\d \d\d:\d\d:\d\d$@', $date) == true ){ // DATETIME

		list( $d, $t ) = explode(' ', $date);

		list( $arr['day'], $arr['month'], $arr['year'] ) = explode('.', $d);
		list( $arr['hours'], $arr['minutes'], $arr['seconds'] ) = explode(':', $t);

	}
	else if( preg_match('@^\d\d\d\d-\d\d-\d\d$@', $date) == true ){ // DATE

		list( $arr['year'], $arr['month'], $arr['day'] ) = explode('-', $date);

	}
	else if( preg_match('@^\d\d\.\d\d\.\d\d\d\d$@', $date) == true ){ // DATE

		list(  $arr['day'], $arr['month'], $arr['year'] ) = explode('.', $date);

	}
	else if( preg_match('@^\d\d\d\d$@', $date) == true ){ // YEAR

		$arr['year'] = $date;

	}
	else if( preg_match('@^\d\d:\d\d:\d\d$@', $date) == true ){ // TIME

		list( $arr['hours'], $arr['minutes'], $arr['seconds'] ) = explode(':', $date);

	}


	foreach( $arr as $k => $v ){

		//	if( $v === null )
		//		continue;

		$arr[ $k ] = intval( $v );

	}


	return $arr;


}

function ts2str( $ts ){


	$ts = (int) $ts;

	$str = date('j',$ts) . ' ' . month_name( date('m',$ts), 2 ) . ' ' . date('Y',$ts);

	return $str;

}

function check_date( $year, $month, $day, $hour = 0, $minute = 0, $second = 0 ){

	$year = (int) $year;
	$month = (int) $month;
	$day = (int) $day;

	return checkdate( $month, $day, $year );

}


function parse_timestamp( $ts = null ){

	if( $ts === null ){
		$ts = time();
	}

	$date_string = date('d.m.Y H:i:s',$ts);

	$arr = [];
	$arr['day'] = '';
	$arr['month'] = '';
	$arr['year'] = '';

	$arr['hour'] = '';
	$arr['minute'] = '';
	$arr['second'] = '';

	list( $date, $time ) = explode(' ',$date_string);
	list( $arr['day'], $arr['month'], $arr['year'] ) = explode('.',$date);
	list( $arr['hour'], $arr['minute'], $arr['second'] ) = explode(':',$time);

	return $arr;

}


/**
 * @param str $date_of_birth Дата рождения. YYYY-MM-DD
 * @return int возраст.
 */
function get_age( $date_of_birth ){
	$diff = date_difference( $date_of_birth, time() );
	return $diff['years'];
}


/**
 * Метод разбирает дату формата YYYY-MM-DD HH:MM:SS
 * @param str $dt
 * @param bool $to_int Привести строки к целому.
 * @return array | null $arr;
 */
function parse_dt( $dt, $to_int = true ){
	$arr['year'] = null;
	$arr['month'] = null;
	$arr['day'] = null;
	$arr['hours'] = null;
	$arr['minutes'] = null;
	$arr['seconds'] = null;

	if( preg_match('@^\d\d\d\d-\d\d-\d\d \d\d:\d\d:\d\d$@', $dt) == true ){ // DATETIME AND TIMESTAMP

		list( $d, $t ) = explode(' ', $dt);

		list( $arr['year'], $arr['month'], $arr['day'] ) = explode('-', $d);
		list( $arr['hours'], $arr['minutes'], $arr['seconds'] ) = explode(':', $t);

	}
	else if( preg_match('@^\d\d\d\d-\d\d-\d\d$@', $dt) == true ){ // DATE

		list( $arr['year'], $arr['month'], $arr['day'] ) = explode('-', $dt);

	}
	else if( preg_match('@^\d\d\d\d$@', $dt) == true ){ // YEAR

		$arr['year'] = $dt;

	}
	else if( preg_match('@^\d\d:\d\d:\d\d$@', $dt) == true ){ // TIME

		list( $arr['hours'], $arr['minutes'], $arr['seconds'] ) = explode(':', $dt);

	}

	if( $to_int == true ){

		foreach( $arr as $k => $v ){

			if( $v === null )
				continue;

			$arr[ $k ] = intval( $v );

		}

	}

	return $arr;

}

function seconds_to_hours( $seconds = 0, $with_seconds = false ){

	$seconds = intval( $seconds );

	$str = '';
	$arr = [];

	$r = $seconds % 60;

	$minutes = ( $seconds - $r ) / 60;

	$seconds = $r;

	$r = $minutes % 60;

	$hours = ( $minutes - $r ) / 60;

	$minutes = $r;

	if( $hours > 0 ){

		$arr[] = $hours . ' ч.';
		$arr[] = $minutes . ' мин.';

	}
	else if( $hours == 0 && $minutes > 0 ){

		$arr[] = $minutes . ' мин.';

	}






	if( $seconds > 0 && $with_seconds == true ){
		$arr[] = $seconds . ' сек.';
	}

	$str = implode( ' ', $arr );

	return $str;

}

/**
 * Улучшенный вариант функции float_val().
 *
 * float_val() имеет недостаток при обработке значений вида "1,234", если
 * запятая в локале не является разделителем дроби, то вернёт "1".
 *
 * @param $value
 * @return float
 */
function float_value( $value ){

	$arr = localeconv();
	$value = preg_replace('/\,|\./',$arr['decimal_point'],$value);
	$value = preg_replace('/ /', '', $value);
	// Удалить все символы, кроме цифр, точки и запятой.
	$value = preg_replace('/[^\d\.\,]/', '', $value);

	return (float) $value;

}



function custom_sort($a, $b){

	$a['value'] = float_value($a['value']);
	$b['value'] = float_value($b['value']);

	if ($a['value'] == $b['value']) {
		return 0;
	}

	return ($a['value'] < $b['value']) ? -1 : 1;

}





/**
 * @param array $params
 *
 * type - тип объекта service | page | inc_page
 * name - для service | page | inc_page.
 * id - числовой код, только для page.
 * app_name - если не задано, то используется текущее.
 */
function check_acl( $params = [] ){

	$forbidden = false;

	$object_type = '';
	$object_id = '';
	$key = '';
	$action = '';

	if( array_key_exists( '_page', $_REQUEST ) == true ){

		$object_type = 'page';
		$object_id = get_str('_page');

	}
	elseif( array_key_exists( '_service', $_REQUEST ) == true ){

		$object_type = 'service';
		$object_id = get_str('_service');

	}

	if( array_key_exists( 'action', $_REQUEST ) == true ){
		$action = get_str('action');
	}

	$key = $object_type . '|' . $object_id;


	$exists = false;

	if( array_key_exists( $key, app::$config['acl']['objects'] ) ){
		$acl = app::$config['acl']['objects'][ $key ];
		$exists = true;
	}


	if( $exists == true ){

		//	print_r($acl);


		//
		// BEGIN Действие и все пользователи по умолчанию.
		//

		if( array_key_exists( '*', $acl ) == true ){

			if( array_key_exists( '*', $acl['*'] ) == true ){

				if( $acl['*']['*'] == 'd' ){

					$forbidden = true;

				}

			}
			else {

				if( app::$config['acl']['mode'] == 'da' ){

					$forbidden = true;

				}

			}

		}
		else {

			if( app::$config['acl']['mode'] == 'da' ){

				$forbidden = true;

			}

		}

		//
		// END Действие и все пользователи по умолчанию.
		//


		//
		// BEGIN Выбранное действие.
		//


		if( array_key_exists( $action, $acl ) == true ){




			$groups = user_get_user_groups( app::$user->id );


			print_r($groups);


		}

		//
		// END Выбранное действие.
		//


	}
	else {

		if( app::$config['acl']['mode'] == 'da' ){

			$forbidden = true;

		}
		else { // ad

		}

	}

	if( $forbidden == true ){
		exit('Доступ запрещён.');
	}




}


/**
 * Метод для редиректа.
 *
 * null
 * 301 Permament Redirect
 * 302
 */
function redirect( $url = '/', $code = 301 ){

	$url = (string) $url;

	if( $url == '' ){
		$url = '/';
	}

	if( is_url($url) == true ){

		if( $code !== null ){
			$code = intval( $code );
			if( in_array( $code, [ 301, 302 ] ) == false ){
				$code = null;
			}
		}

		header( 'Location: ' . $url, true, $code );

	}
	exit;
}


function url_add_params( $url, $params = [] ){

	$arr_query = [];
	$arr_query2 = [];
	$arr_url = [];

	$parsed_url = parse_url($url);

	if( array_key_exists( 'scheme', $parsed_url ) == true ){
		$arr_url[] = $parsed_url['scheme'] . '://';
	}

	if( array_key_exists( 'user', $parsed_url ) == true ){
		$arr_url[] = $parsed_url['user'];
	}

	if( array_key_exists( 'pass', $parsed_url ) == true ){
		$arr_url[] = ':' . $parsed_url['pass'];
	}

	if( array_key_exists( 'user', $parsed_url ) == true ){
		$arr_url[] = '@';
	}

	if( array_key_exists( 'host', $parsed_url ) == true ){
		$arr_url[] = $parsed_url['host'];
	}

	if( array_key_exists( 'port', $parsed_url ) == true ){
		$arr_url[] = ':' . $parsed_url['port'];
	}

	if( array_key_exists( 'path', $parsed_url ) == true ){
		$arr_url[] = $parsed_url['path'];
	}

	if( array_key_exists( 'query', $parsed_url ) == true ){
		parse_str( $parsed_url['query'], $arr_query );
	}


	if( is_array( $params ) == true ){

		$arr_query2 = $params;

	}
	else {

		parse_str( $params, $arr_query2 );

	}


	if( count( $arr_query ) > 0 || count( $arr_query2 ) > 0 ){

		$arr_url[] = '?';

	}

	if( count( $arr_query ) > 0 ){

		$arr_url[] = http_build_query( $arr_query );

	}

	if( count( $arr_query ) > 0 && count( $arr_query2 ) > 0 ){
		$arr_url[] = '&';
	}


	$str = http_build_query( $arr_query2 );
	$str = preg_replace( '/%5B\d+%5D/', '%5B%5D', $str );

	// Исключения для переменной пагинатора pn={$page}
	$str = preg_replace( ['/%7B/','/%24/','/%7D/'], ['{','$','}'], $str );

	$arr_url[] = $str;


	if( array_key_exists( 'fragment', $parsed_url ) == true ){
		$arr_url[] = '#' . $parsed_url['fragment'];
	}

	return implode('',$arr_url);

}


/**
 * Функция генерирует строку указанной длины из определённого набора символов.
 * Используется в генерации пароля, кода активации и прочих местах.
 *
 * @param $length
 * @param null $chars
 * @return string
 */
function randstr( $length, $chars = null ){

	if( $chars == null ){
		$chars = 'abcdefghijklmnoprstuvxyzABCDEFGHIJKLMNOPRSTUVXYZ0123456789';
	}
	else {
		$chars = (string) $chars;
	}

	mt_srand();

	$str = '';

	for( $c = 0; $c < $length; $c++ ){

		$str.= $chars[ mt_rand( 0, mb_strlen( $chars ) - 1 ) ];

	}

	return $str;

}


/**
 * @return mixed|string
 */
function get_ip(){

	if( array_key_exists( 'HTTP_X_REAL_IP', $_SERVER ) == true ){

		$ip = $_SERVER['HTTP_X_REAL_IP'];

	}
	elseif( array_key_exists( 'HTTP_CLIENT_IP', $_SERVER ) == true ){

		$ip = $_SERVER['HTTP_CLIENT_IP'];

	}
	elseif( array_key_exists( 'HTTP_X_FORWARDED_FOR', $_SERVER ) == true ){

		$ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

		if( is_array( $ip_list ) == true ){
			foreach( $ip_list as $i => $ip ){
				$ip = trim($ip);
				$ip_list[ $i ] = $ip;
			}
			$ip = array_pop( $ip_list );
		}

		unset($ip_list);

	}
	else {

		$ip = $_SERVER['REMOTE_ADDR'];

	}



	if( filter_var( $ip, FILTER_VALIDATE_IP ) === false ){

		$ip = $_SERVER['REMOTE_ADDR'];

	}


	return $ip;

}



function inet_aton( $address ){

	return inet_pton( $address );

}

function inet_ntoa( $in_addr ){

	return inet_ntop( $in_addr );

}

function curl( $params = [] ){

	$default_params = [];

	$default_params['userpwd'] = '';

	$default_params['headers'] = [];
	$default_params['method'] = 'get';
	$default_params['post_data'] = [];
	$default_params['url'] = '';

	// Выводить ли в результат HTTP-заголовки.
	$default_params['include_headers'] = false;

	// Выводить ли в результат полученный контент.
	$default_params['include_body'] = true;

	$default_params['referer'] = '';

	// $default_params['user_agent'] = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)';
	$default_params['user_agent'] = 'Opera';


	/**
	 * Максимально допустимый объём сканируемой HTML-страницы.
	 * Размер в байтах. По умолчанию 1 Мб = 1048576 байт.
	 * Сначала страница полностью скачивается в память сервера.
	 * Если объём выходит за рамки $max_content_size, усекается до
	 * $max_content_size и обрабатывается дальше.
	 * Если задан 0, то без ограничений.
	 */
	$default_params['max_content_size'] = 1048576;

	// Макс. кол-во редиректов.
	$default_params['max_redirs'] = 10;

	// Таймаут соединения. В секундах.
	$default_params['conn_timeout'] = 120;

	// Таймаут ответа. В секундах.
	$default_params['timeout'] = 120;

	$default_params['cookie_file'] = null;

	$params = set_params( $default_params, $params );

	// Создать подключение.
	// ch - connection handler
	$ch = curl_init();

	if( $ch === false ){
		return false;
	}


	// Переходить по редиректам.
	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

	if( $params['method'] == 'post' ) {

		// Порядок важен! Сначала CURLOPT_POST, а потом CURLOPT_POSTFIELDS.
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $params['post_data'] );

	}

	curl_setopt( $ch, CURLOPT_URL, $params['url'] );

	// Чтобы curl_exec возвращал данные, а не статус.
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);


	curl_setopt($ch, CURLOPT_USERAGENT, $params['user_agent'] );
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $params['conn_timeout'] );
	curl_setopt($ch, CURLOPT_TIMEOUT, $params['timeout'] );
	curl_setopt($ch, CURLOPT_MAXREDIRS, $params['max_redirs'] );

	if( count( $params['headers'] ) > 0 ){


		curl_setopt( $ch, CURLOPT_HTTPHEADER, $params['headers'] );

	}

	curl_setopt( $ch, CURLOPT_HEADER, false );

	if( $params['include_body'] == false ){

		curl_setopt( $ch, CURLOPT_NOBODY, true );

	}

	if( $params['include_headers'] == true ){

		curl_setopt($ch,CURLOPT_HEADER,true);

	}

	if( $params['userpwd'] != '' ){

		curl_setopt( $ch, CURLOPT_USERPWD, $params['userpwd'] );

	}

	// curl_setopt( $ch, CURLOPT_PROXY, '' );
	// curl_setopt($ch, CURLOPT_VERBOSE,1);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
	//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);

	// Обрабатывает все способы кодирования
	curl_setopt( $ch, CURLOPT_ENCODING, '' );

	if( $params['referer'] != '' ) {

		curl_setopt( $ch, CURLOPT_REFERER, $params['referer'] );

	}

	if( $params['cookie_file'] != null ){

		if( is_file( $params['cookie_file'] ) == false ){

			write_file( $params['cookie_file'], '' );

		}

		curl_setopt( $ch, CURLOPT_COOKIEJAR, $params['cookie_file'] );
		curl_setopt( $ch, CURLOPT_COOKIEFILE, $params['cookie_file'] );

	}

	// Получить данные.
	$output = curl_getinfo( $ch );

	$output['content'] = curl_exec( $ch );
	$output['errno'] = curl_errno( $ch );
	$output['errmsg'] = curl_error( $ch );
	$output['http_code'] = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

	// Проверка размера данных.
//	if( $max_content_size > 0 && strlen($output['content']) > $max_content_size ) {

//		$output['content'] = mb_substr($output['content'], 0, $max_content_size);

//	}

	// Перекодировать в utf-8.
//	if( $encoding != 'utf-8' ) {

//		$output['content'] = iconv($encoding, 'utf-8', $output['content']);

//	}

	// Закрыть соединение.
	curl_close( $ch );

	if( $output['errno'] > 0 ) {

		return false;

	}

	return $output;

}

function curl_post( $url, $post_data = [], $params = [] ){

	$curl_params = $params;
	$curl_params['url'] = $url;
	$curl_params['post_data'] = $post_data;
	$curl_params['method'] = 'post';

	return curl( $curl_params );

}

function curl_get( $url, $params = [] ){

	$curl_params = $params;
	$curl_params['url'] = $url;

	return curl( $curl_params );

}

function http_post( $url, $post_data = [], $params = [] ){

	return curl_post( $url, $post_data, $params );

}

function http_get( $url, $params = [] ){

	return curl_get( $url, $params );

}


/**
 * Функция кодирует адресную строку, не преобразуя при этом слэш в %2F.
 */
function save_slash_rawurlencode( $url ){

	$url = implode('/', array_map('rawurlencode', explode('/', $url) ) );

	return $url;

}

if ( function_exists('getallheaders') == false ) {

	function getallheaders() {

		$headers = [];

		foreach( $_SERVER as $name => $value ){

			if( substr( $name, 0, 5 ) == 'HTTP_' ){

				$h = str_replace( ' ', '-', ucwords( strtolower( str_replace( '_', ' ', substr( $name, 5 ) ) ) ) );

				$headers[ $h ] = $value;

			}

		}

		return $headers;

	}
}


// Функция записывает данные в файл. Если файл не существует, создаст его.
// $chmod - режим создания файла по умолчанию. Только для нового файла.
function write_file( $filename, $content='', $append=false, $chmod = 0775 ){

	$dir = dirname( $filename );

	if( is_dir( $dir ) == false ){
		mkdir( $dir, 0777, true );
	}

	$exists = false;

	if( is_file( $filename ) == true ){
		$exists = true;
	}

	if( $append === true )
		$fh = fopen($filename,'a');
	else
		$fh = fopen($filename,'w');
	// Виды блокировок
	// LOCK_SH - shared-блокировка (reader)
	// LOCK_EX - исключительная/exclusive блокировка (writer)
	// LOCK_UN - освобождения блокировки (shared или exclusive)
	flock($fh,LOCK_EX);
	fwrite($fh,$content,strlen($content));
	flock($fh,LOCK_UN);
	fclose($fh);

	if( $exists == false ){

		chmod( $filename, $chmod );

	}


}

/**
 * Функция читает файл и возвращает его содержимое.
 *
 * @param string $filename
 * @return string
 */
function read_file($filename){
	if( is_file( $filename ) == true ){
		$content = '';
		$fh = fopen( $filename, 'r' );
		if( filesize( $filename ) > 0 )
			$content = fread( $fh, filesize($filename) );
		fclose($fh);
		return $content;
	}else{
		throw new exception('The file "' . $filename . '" not exists.');
	}
}



function ajax_call(){

	$result = false;

	if( array_key_exists( 'HTTP_X_REQUESTED_WITH', $_SERVER ) == true ){
		if( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ){
			$result = true;
		}
	}
	elseif( array_key_exists( '_json', $_REQUEST ) == true ){
		$result = true;
	}

	return $result;

}




/**
 * Сгруппировать данные по ключу.
 *
 * @var $format Регулярное выражение.
 * @var $key_index Номер фигурной скобки в регулярном выражении, содержащий объединяющий ключ.
 */
function group_data( $format, $key_index ){

	$fields = [];

	foreach( $_REQUEST as $key => $value ){

		$matches = [];

		if( preg_match( '//', $key, $matches ) == true ){

			//$fields[ $matches[ $key_index ] ][  ]

		}

	}

	return $fields;

}



function get_bool( $name, $default_value = false ){

	return get_boolean( $name, $default_value );

}

function get_boolean( $name, $default_value = false, $data_source = null ){

	$value = $default_value;



	if( $data_source == null ){

		$data_source = $_REQUEST;

	}





	if( array_key_exists( $name, $data_source ) == true ){

		$value = mb_strtolower( $data_source[$name] );

	}

	if( in_array( $value, [ 'true', 'yes', 'y', 'on', '1' ] ) == true ){

		$value = true;

	}
	else if( in_array( mb_strtolower($value), [ 'false', 'no', 'n', 'off', '0' ] ) == true ){

		$value = false;

	}
	else {

		$value = (boolean) $value;

	}

	return (boolean) $value;

}

function get_integer( $name, $default_value = 0, $values = [] ){

	return get_int( $name, $default_value, $values );

}



/**
 * Возвращает целое число.
 * В 32-х битных системах максимальное знаковое целое лежит в диапазоне от -2147483648 до 2147483647.
 *
 * @param string $name
 * @param int $default
 * @return array|bool|float|int|string
 */
/**
 * @param $name
 * @param int $default_value
 * @param array $values Массив с допустимыми значениями. Проверка строго по типу, то есть в массив $values нельзя писать '1', '2' и т.д., но можно 1, 2 и т.д.
 * @return int
 */
function get_int( $name, $default_value = 0, $values = [], $data_source = null ){

	$default_value = (int) $default_value;

	$value = $default_value;

	if( $data_source == null ){

		$data_source = $_REQUEST;

	}

	if( array_key_exists( $name, $data_source ) == true ){

		$value = intval( $data_source[ $name ] );

	}

	if( count( $values ) > 0 ){

		if( in_array( $value, $values, true ) == false ){

			$value = $default_value;

		}

	}

	return (int) $value;

}

/**
 * Возвращает целое беззнаковое.
 *
 * @param string $name
 * @param int $default
 * @return number
 */
function get_uint( $name, $default_value = 0, $values = [] ){

	$value = abs( get_int( $name, $default_value, $values ) );

	return $value;

}



/**
 * Возвращает дробное число.
 *
 * @param string $name
 * @param float $default
 * @return array|bool|float|int|string
 */
function get_float( $name, $default_value = 0, $data_source = null ){

	$value = (float) $default_value;

	if( $data_source == null ){

		$data_source = $_REQUEST;

	}

	if( array_key_exists( $name, $data_source ) == true ){

		$value = $data_source[ $name ];

		$arr = localeconv();

		$value = preg_replace('/\,|\./',$arr['decimal_point'],$value);

	}

	return (float) $value;

}



/**
 * Возвращает дробное беззнаковое число.
 *
 * @param string $name
 * @param float $default
 * @return number
 */
function get_ufloat( $name, $default_value = 0 ){

	$value = abs( get_float( $name, $default_value ) );

	return $value;

}



/**
 * Метод возвращает строку. Данная функция подвержена XSS-атаке.
 * Чтобы получить безопасный текст используйте get_text().
 * Чтобы получить безопасный HTML используйте get_html().
 *
 * @param string $name
 * @param string $default_value
 * @return string
 */
function get_str( $name, $default_value = '', $data_source = null, $trim = true ){

	$value = $default_value;

	if( $data_source == null ){

		$data_source = $_REQUEST;

	}

	if( array_key_exists( $name, $data_source ) == true ){

		$value = $data_source[ $name ];

	}

	$value = (string) $value;

	if( $trim == true ) {

		$value = trim($value);

	}

	return $value;

}

function get_string( $name, $default_value = '' ){

	return get_str( $name, $default_value );

}


function get_cookie_str( $name, $default_value = '' ){

	$value = $default_value;

	if( array_key_exists( $name, $_COOKIE ) == true ){

		$value = $_COOKIE[ $name ];

	}

	$value = (string) $value;

	$value = trim( $value );

	return $value;

}

function get_cookie_int( $name, $default_value = 0, $values = [] ){

	$default_value = (int) $default_value;

	$value = $default_value;

	if( array_key_exists( $name, $_COOKIE ) == true ){

		$value = intval( $_COOKIE[ $name ] );

	}


	if( count( $values ) > 0 ){

		if( in_array( $value, $values, true ) == false ){

			$value = $default_value;

		}

	}

	return (int) $value;

}




function get_array( $name, $default_value = [], $data_source = null ){

	$value = $default_value;


	if( $data_source == null ){

		$data_source = $_REQUEST;

	}


	if( array_key_exists( $name, $data_source ) == true ){

		$value = $data_source[ $name ];

	}

	$value = (array) $value;

	return $value;

}

/**
 * Метод возвращает данные в сыром виде, как они есть в $_REQUEST.
 *
 * @param string $name
 * @param string $default_value
 * @return array|bool|float|int|string
 */
function get_var( $name, $default_value = null ){

	$value = $default_value;

	if( array_key_exists( $name, $_REQUEST ) == true ){

		$value = $_REQUEST[ $name ];

	}

	return $value;

}

/**
 * Метод возвращает строку с преобразованными специальными символами в HTML-сущности.
 *
 * htmlspecialchars + trim
 *
 * @param string $name
 * @param string $default_value
 * @return string
 */
function get_text( $name, $default_value = '', $data_source = null ){

	$value = get_str( $name, $default_value, $data_source );

	$value = htmlspecialchars( $value, ENT_QUOTES | ENT_SUBSTITUTE );

	return $value;

}




function get_email( $name ){

	$value = '';

	if( array_key_exists( $name, $_REQUEST ) == true ){

		$value = $_REQUEST[ $name ];

	}

	if( is_email( $value ) == false ){

		$value = null;

	}

	return $value;

}


function get_login( $name ){

	$value = '';

	if( array_key_exists( $name, $_REQUEST ) == true ){

		$value = $_REQUEST[ $name ];

	}

	if( is_login( $value ) == false ){

		$value = null;

	}

	return $value;

}



function get_url( $name ){


	$ext_backurl = get_str( $name );

	if( preg_match ('/^http(s)?:\/\//', $ext_backurl ) == false ){

		$ext_backurl = 'http://' . $ext_backurl;

	}

	$parsed_url = parse_url( $ext_backurl );

	if( is_array( $parsed_url ) == false ){
		$parsed_url = [];
	}


	if( array_key_exists( 'host', $parsed_url ) == false ){
		if( $parsed_url['host'] != app::$config['domain'] ){
			$ext_backurl = '';
		}
	}


	return $ext_backurl;

}




function get_backurl( $name = 'backurl' ){

	return get_url( $name );

}


function get_date( $name, $format = 'YYYY-MM-DD' ){

}



/**
 * Защита от XSS.
 *
 * <ScRiPt >prompt(955218)</ScRiPt>
 *
 * @link http://htmlpurifier.org/live/smoketests/xssAttacks.php
 * @link http://htmlpurifier.org/live/configdoc/plain.html
 *
 * @param $name
 * @param null | array $purifier_config
 * @return string
 */
function get_html( $name, $default_value = '' ){

	$value = get_string( $name, $default_value );

	if( app::$purifier == null ){

		app::init_purifier();

	}

	$value = app::$purifier->purify( $value );

	return $value;

}




/**
 * Дополнение к форме.
 * Формирует галерею для закачки и управления картинками.
 * @deprecated
 */
function gallery($params){

	$tpl_data = app::$smarty_yadro->createData();

	$tpl_data->assign('file', editbox(array(
		'name' => 'file_' . $params['id'],
		'value' => $params['name'],
		'attrs' => 'readonly="true"'
	)));

	$tpl_data->assign('description', editbox(array(
		'name' => 'description_' . $params['id'],
		'value' => $params['description']
	)));

	$tpl_data->assign('id', $params['id']);

	$tpl = app::$smarty_yadro->createTemplate('gallery.tpl',$tpl_data);
	return $tpl->fetch();

}


/**
 * @param $str
 * @param $pos Нумерация символов, начиная с 0.
 * @return string
 */
function get_char( $str, $pos ) {
	$str = (string) $str;
	$pos = (int) $pos;
	return mb_substr( $str, $pos, 1, 'utf-8');
}

function data_uri( $file, $mime ) {

	return data_url( $file, $mime );

}

/**
 * Удаление пробелов между тегами.
 *
 * @todo Удаление пробелов в script
 * @param string $html
 * @return mixed
 */
function remove_whitespace_from_html( $html = '' ){

	return preg_replace('/(?:(?)|(?))(\s+)(?=\<\/?)/','',$html);

}

function data_url( $file, $mime ) {
	$content = read_file( $file );
	$base64 = base64_encode( $content );
	$content = 'data:' . $mime . ';base64,' . $base64;
	return $content;
}

/**
 * Метод проверяет сериализованна ли строка.
 */
function is_serialized( $val ){

	if( is_string($val) == false || trim($val) == '' ){
		return false;
	}

	if( preg_match('/^(i|s|a|o|d):(.*);/si', $val ) !== false ){
		return true;
	}

	return false;
}

/**
 * Метод меняет значения двух переменных местами.
 */
function var_flip( &$var1, &$var2 ){

	list( $var1, $var2 ) = [ $var2, $var1 ];

}


function fdate( $ts ){

	$html = date( 'd.m.Y', $ts ) . ' ' . color( date( 'H:i', $ts ), '#ccc' );

	return $html;

}


function crc( $str ){

	$str = (string) $str;
	$crc = crc32( $str );
	$crc = sprintf('%u', $crc);

	return $crc;
}



/**
 * Метод возвращает изменённые данные.
 *
 * @param array $fields
 * @param array $new_data
 * @param array $old_data
 * @param array $types - Уточняющий массив, с типами данных (boolean, float, double, real, integer, string, bool, int, str).
 *
 * $types[ имя_поля1 ] = float
 * $types[ имя_поля2 ] = integer
 *
 */
function get_changed_data( $fields = [], $new_data = [], $old_data = [], $types = [], $return_both_value = true ){

	if( is_array( $old_data ) == false ){
		$old_data = [];
	}

	if( is_array( $new_data ) == false ){
		$new_data = [];
	}

	if( is_array( $fields ) == false ){
		$fields = [];
	}

	$changed_data = [];

	foreach( $fields as $field ){

		if( array_key_exists( $field, $old_data ) == true && array_key_exists( $field, $new_data ) == true ){

			$type = 'string';

			if( array_key_exists( $field, $types ) == true ){

				$type = $types[ $field ];

			}

			if( $type == 'boolean' || $type == 'bool' ){

				$old_value = (boolean) $old_data[ $field ];
				$new_value = (boolean) $new_data[ $field ];

			}
			else if( $type == 'float' || $type == 'double' || $type == 'real' ){

				$old_value = (float) $old_data[ $field ];
				$new_value = (float) $new_data[ $field ];

			}
			else if( $type == 'integer' || $type == 'int' ){

				$old_value = (integer) $old_data[ $field ];
				$new_value = (integer) $new_data[ $field ];

			}
			else {

				$old_value = (string) $old_data[ $field ];
				$new_value = (string) $new_data[ $field ];

			}

			if( $old_value !== $new_value ){

				if( $return_both_value == true ){

					$changed_data[ $field ] = [ 'new_value' => $new_value, 'old_value' => $old_value ];

				}
				else {

					$changed_data[ $field ] = $new_value;

				}

			}

		}

	}


	return $changed_data;

}



/**
 * Метод проверяет номер страницы. Не вышел ли за пределы.
 *
 * @param int $total_records - Всего записей.
 * @param int $limit - Вывод на страницу.
 * @param int $page_number - Номер текущей страницы.
 *
 * @return arr
 * 		int $result[0] - Сколько всего страниц.
 * 		int $result[1] - Номер текущей страницы, после проверки диапазона.
 */
function check_page_number($total_records, $limit, $page_number){

	if( $limit == 0 ){

		return [ 1, 1 ];

	}

	$total_pages = 0;

	$r = $total_records % $limit;

	$total_pages = ( $total_records - $r ) / $limit;

	if( $r > 0 ) {

		$total_pages = $total_pages + 1;

	}

	if( $total_pages == 0 ) {

		$total_pages = 1;

	}

	if( $page_number < 1 ) {

		$page_number = 1;

	}

	if( $page_number > $total_pages ) {

		$page_number = $total_pages;

	}

	return [ $total_pages, $page_number ];

}


function get_page_number( $total_records, $limit, $page_number ){

	list( $total_pages, $page_number ) = check_page_number( $total_records, $limit, $page_number );

	return $page_number;

}


function get_total_pages( $total_records, $limit, $page_number ){

	list( $total_pages, $page_number ) = check_page_number( $total_records, $limit, $page_number );

	return $total_pages;

}


/**
 * Используется для очистки пути/URL от лишних слэшей.
 * @todo Учитывать двойной слэш в http://
 */
function clear_path($path){

	return preg_replace( '@//+@', '/', $path );

}

/**
 * Используется для очистки пути/URL от лишних слэшей.
 *
 */
function clear_url( $path ){

	return clear_path($path);

}


/**
 * Обрубает текст до целого слова.
 *
 * @param $text
 */
function cut_text( $text, $length ){

	return preg_replace('/\s[^\s]+$/', '', substr( $text, 0, $length ) );

}



/**
 * Метод упрощающий получение параметров.
 * Используется для переопределения значений по умолчанию, на полученные значения.
 *
 * @param boolean $append Нужно ли дописывать недостающие параметры.
 */
function set_params( $default_params, $params, $append = true ){

	if( is_array( $default_params ) == false ){
		$default_params = [];
	}

	if( is_array( $params ) == false ){
		$params = [];
	}

	if( $append == true ){

		foreach( $default_params as $key => $value ){

			if( array_key_exists( $key, $params ) == true ){

				$default_params[ $key ] = $params[ $key ];

			}

		}

	}
	else {

		$new_params = [];

		foreach( $default_params as $key => $value ){

			if( array_key_exists( $key, $params ) == true ){

				$new_params[ $key ] = $params[ $key ];

			}

		}

		$default_params = $new_params;

	}



	return $default_params;


}

/**
 * Удаление множества новых строк.
 */
function remove_newline($str){

	return preg_replace('/(\r?\n)+/','',$str);

}

/**
 * Удаление множества новых строк.
 * Если будет 3 и более новых строк, то они заменятся
 * на \n\n.
 */
function remove_newline2($str){

	return preg_replace('/(\r?\n){3,}/',"\n\n",$str);

}


/**
 *
 */
function js_str($str){

	$pattern = array('/\'/','/\n/','/\r/');

	$replace = array("\\'","\\n","\\r");

	return preg_replace($pattern, $replace, $str);

}



function safe_array( $data = [] ){

	$safe_data = [];

	foreach( $data as $key => $value ){
		if( is_string( $value ) == true ){
			$safe_data[ $key ] = htmlspecialchars( $value, ENT_QUOTES );
			$safe_data[ '!' . $key ] = $value;
		}
		else {
			$safe_data[ $key ] = $value;
		}
	}

	return $safe_data;

}



/**
 * Экранирование символа ' (single quote).
 */
function add_slash($str){

	return preg_replace('/\'/u','\\\'',$str);

}


/**
 * Замена множества новых строк в тексте на одну новую HTML строку
 * nl2br
 */
function rn2br($str){

	return preg_replace('/(\r?\n)/','<br />',$str);

}


/**
 * Проверяет число на чётность.
 *
 * @return bool
 * 		true - число чётное.
 */
function even($num){

	return ( ( $num % 2 ) === false ) ? true : false;

}



/**
 * Стандартный intval (signed integer) работает в диапазоне от -2147483648 до 2147483647 на x86.
 *
 * Ипользуйте эту функцию, чтобы получить диапазон от 0 до 4294967295.
 *
 */
function uintval($number){

	// Чтобы не навредить отрицательным числам.
	if( $number <= 0 ){
		$number = intval( $number );
		return $number;
	}

	$number = floatval( $number );

	if( $number > PHP_INT_MAX ){
		$number = PHP_INT_MAX;
		// echo var_dump($number); // Преборазуется в float.
	}

	return sprintf('%u', $number);

}




/**
 * Если в Smarty передать true, то в шаблоне будет 1. Поэтому нужно передавать true, как строку для JavaScript.
 *
 * @param $val
 * @return bool
 */
function bool_to_str( $val ){

	if( $val ){
		return 'true';
	}
	else {
		return 'false';
	}

}





/**
 * Замена множества пробелов на
 * underscore character символ подчёркивания "_" или -
 */
function sp2uc( $str, $char = '-' ){

	return preg_replace( '/( )+/', $char, $str );

}


/**
 * Замена множества новых строк на одинарный пробел.
 */
function rn2space($str){

	return preg_replace('/(\r?\n)+/',' ',$str);

}


/**
 * Функция оборачивает HTML текст в цвет.
 */
function color($str,$color = '#000000'){

	return '<span style="color:' . $color . '">' . $str . '</span>';

}


/**
 * Метод выдаёт случайное число в интервале $min - $max.
 */
function random_value($min = 0, $max = 0){
	list($usec, $sec) = explode(' ', microtime());
	$val = (float) $sec + ((float) $usec * 100000);
	mt_srand($val);
	$randval = mt_rand($min,$max);
	return $randval;
}




function hex_color( $value ){

	$short_hex_color = strtolower( $value[1] );


	if( $value[1][0] == $value[1][1]
		&& $value[1][2] == $value[1][3]
		&& $value[1][4] == $value[1][5] )
	{

		$short_hex_color = $value[1][0] . $value[1][2] . $value[1][4];

		$short_hex_color = strtolower( $short_hex_color );

	}

	$short_hex_color = '#' . $short_hex_color;

	return $short_hex_color;

}


/**
 * Метод собирает все вставки <script></script> в <body></body> в порядке следования и объединяет их в один <script></script>,
 * помещая перед </html>.
 *
 * @todo Исправить. Функция захватывает скрипты или стили помещённые в комментарии HTML.
 */
function combine_scripts( $html ){

	$js_inline = '';

	$js_files = '';

	$matches = [];

	if( preg_match( '#<body(.*?)</body>#umsi', $html, $matches ) > 0 ){

		$body = $matches[0];

		//
		// BEGIN Собрать содержимое всех тегов script.
		//

		$matches2 = [];

		$cnt = preg_match_all( '#\<script([^>]*?)\>(.*?)\</script\>#umsi', $body, $matches2 );

		if( $cnt > 0 ){

			foreach( $matches2[2] as $z => $content ){

				$attrs = [];

				$arr = explode(' ', $matches2[1][ $z ] );

				foreach( $arr as $i => $v ){

					list( $key, $value ) = explode( '=', $v );

					$key = trim( $key );
					$value = trim( $value );

					if( $key != '' ){

						$attrs[ $key ] = trim( $value, '"' );

					}

				}


				if( array_key_exists( 'data-skip', $attrs ) == true ){

					if( $attrs['data-skip'] == true ){

						continue;

					}

				}

				$js_inline.= $content . "\n";

			}

		}




		//
		// END Собрать содержимое всех тегов script.
		//



		//
		// BEGIN Файлы подключенные через src собрать в кучу, чтобы перенести вниз страницы.
		//

		$matches2 = [];

	//	$cnt = preg_match_all( '#\<script[^>]*src[^>]*\>.*?</script\>#umsi', $body, $matches2 );
		$cnt = preg_match_all( '#\<script([^>]*?)\>.*?</script\>#umsi', $body, $matches2 );
	//	$cnt = preg_match_all( '#\<script([^>]*?)\>(.*?)\</script\>#umsi', $body, $matches2 );

		if( $cnt > 0 ){

			foreach( $matches2[0] as $z => $item ){

				$attrs = [];

				$arr = explode(' ', $matches2[1][ $z ] );

				foreach( $arr as $i => $v ){

					list( $key, $value ) = explode( '=', $v );

					$key = trim( $key );
					$value = trim( $value );

					if( $key != '' ){

						$attrs[ $key ] = trim( $value, '"' );

					}

				}

				if( array_key_exists( 'src', $attrs ) == false ){

					continue;

				}


				if( array_key_exists( 'data-skip', $attrs ) == true ){

					if( $attrs['data-skip'] == true ){

						continue;

					}

				}


				$js_files.= $item . "\n";

			}

		}

		//
		// END Файлы подключенные через src собрать в кучу, чтобы перенести вниз страницы.
		//

		// Экранировать $
		$body = preg_replace( '/\$/', '\\\$', $body );

		$body = preg_replace_callback('#\<script([^>]*?)\>(.*?)\</script\>#umsi', function( $matches ){

			$attrs = [];

			$arr = explode(' ', $matches[1]);

			foreach( $arr as $i => $v ){

				list( $key, $value ) = explode( '=', $v );

				$key = trim( $key );
				$value = trim( $value );

				if( $key != '' ){

					$attrs[ $key ] = trim( $value, '"' );

				}

			}


			if( array_key_exists( 'data-skip', $attrs ) == true ){

				if( $attrs['data-skip'] == true ){

					return $matches[0];

				}

			}

		//	app::cons($attrs);

			return '';

		}, $body);

		// Удалить все теги <script></script>.
	//	$body = preg_replace( '#\<script[^>]*\>(.*?)\</script\>#umsi', '', $body );



		if( $js_inline != '' ) {

			$new_html = $js_files . '<script>' . $js_inline . '</script></body>';
			$body = preg_replace( '#</body>#umsi', $new_html, $body );
			$html = preg_replace( '#<body.*?</body>#umsi', $body, $html );

		}

	}


	return $html;

}


function bytes_to_str($bytes){

	return simple_bytes_converter($bytes);

}

function simple_bytes_converter($bytes){

	$megabyte = 1048576;
	$kilobyte = 1024;

	$str = '';

	$bytes = intval( $bytes );

	if ( $bytes < $megabyte && $bytes > $kilobyte ) {
		$str = number_format( round( $bytes / $kilobyte ), 0, '', ' ' ) . ' Kb';
	}
	else if ( $bytes >= $megabyte ) {
		$str = number_format( round( $bytes / $megabyte ), 0, ' ', ' ' ) . ' Mb';
	}
	else {
		$str = number_format( $bytes, 0, '', ' ' );
	}

	return $str;
}


/**
 * @param $file Путь к phtml файлу.
 * @param $func_name Название функции в компилированном шаблоне.
 * @param $cached_template Путь к компилированному шаблону.
 * @return bool
 * @throws exception
 */
function compile_template( $file, $func_name, $cached_template ){


	$file_content = read_file( $file );

	//				$lines = explode( PHP_EOL, $file_content );

	$tokens = token_get_all( $file_content );

	$__dir__ = dirname( $file ) . '/';
	$__file__ = $file;

	$lines = [];

	$line_number = 1;

	$arr_inc = [
		T_REQUIRE,
		T_REQUIRE_ONCE,
		T_INCLUDE,
		T_INCLUDE_ONCE
	];

	// Признак вхождения в include или require.
	$inc = false;

	// Признак того, что в include или require используется __DIR__.
	$dir_in_inc = false;

	foreach( $tokens as $token ){

		if( is_array( $token ) == true ){

			$line_number = $token[2];

			if( $token[0] == T_DIR ){

				$token[1] = '$__dir__';

				if( $inc == true ){

					$dir_in_inc = true;

				}

			}
			else if( in_array( $token[0], $arr_inc ) == true ){

				$inc = true;

			}

			if( $inc == true && $token[0] == T_CONSTANT_ENCAPSED_STRING ){



				if( $dir_in_inc == false ){

					$str = trim( $token[1], "\'\"" );

					if( mb_substr( $str, 0, 1 ) != '/' ){

						$str = rtrim( $__dir__, '/' ) . '/' . ltrim( $str, '/' );

					}

					$token[1] = '"' . $str . '"';

				}

				$inc = false;
				$dir_in_inc = false;


			}

			$lines[ $line_number ].= $token[1];

		}
		else {

			$lines[ $line_number ].= $token;

		}


	}


	$file_content = implode( '', $lines );

	if( $lines == $file_content ){

		//	echo 'SUPER!';

	}

	$new_content = [];
	$new_content[] = '<?';
	$new_content[] = 'function ' . $func_name . '( $vars = [], &$__filemtime__ = 0 ){';
	$new_content[] = '$__dir__ = "' . $__dir__ . '";';
	$new_content[] = '$__file__ = "' . $__file__ . '";';
	// Время модификации шаблона-источника.
	$new_content[] = '$__filemtime__ = ' . filemtime( $__file__ ) . ';';
	$new_content[] = '$content = "";';
	$new_content[] = 'try {';
	$new_content[] = 'ob_start();';
	$new_content[] = '?>';
	$new_content[] = $file_content;
	$new_content[] = '<?';
	$new_content[] = '$content = ob_get_contents();';
	$new_content[] = 'ob_end_clean();';
	$new_content[] = '}catch( Exception $e ){';
	$new_content[] = 'ob_end_clean();';
	$new_content[] = '}';
	$new_content[] = 'return $content;';
	$new_content[] = '}';
	$new_content[] = '?>';

	$new_content = implode( "\n", $new_content );

	write_file( $cached_template, $new_content );

	return true;

}


/**
 * Загрузка PHP-шаблона.
 *
 * @param $file
 * @param array $vars
 * @return string
 */
function load_template( $file, $vars = [], $use_cache = false ){

	$file = (string) $file;
	$vars = (array) $vars;

	try {

		if( $use_cache == true ){

			// Адрес сайта добавлен, чтобы при смене адреса, обновлялся кэш.
			$hash = md5( $file . app::$url );

			$func_name = 'func_' . $hash;

			$cache_dir = app::$config['dirs']['cache'] . '/templates';

			if( is_dir( $cache_dir ) == false ){

				mkdir( $cache_dir, 0777 );

			}

			$cached_template = $cache_dir . '/' . $hash . '.php';

			//
			// BEGIN Актуальность скомпилированного шаблона.
			//

			$rebuild = false;

			if( is_file( $cached_template ) == true ){

				$origin_ts = filemtime( $file );
				$tpl_ts = filemtime( $cached_template );

				if( $origin_ts !== false && $tpl_ts !== false ){

					if( $origin_ts > $tpl_ts ){

						$rebuild = true;

					}

				}

			}

			//
			// END Актуальность скомпилированного шаблона.
			//


			if( is_file( $cached_template ) == false || $rebuild == true ){

				compile_template( $file, $func_name, $cached_template );

			}


			require_once( $cached_template );

			$content = $func_name( $vars );


		}
		else {

			// Буферизация вывода.
			ob_start();

			require( $file );

			$content = ob_get_contents();

			// Очистка буфера.
			ob_end_clean();

		}



	}
	catch( Exception $e ){

		error_log('An error occurred in template "' . $file . '". ' . $e->getMessage() );

	}


	return $content;

}


function url_template( $url, $vars = [] ){

	$reg_exp = '/\{([^}]*)\}/';

	$prepared_url = '';

	if( preg_match_all( $reg_exp, $url, $matches ) ){

		$matches = $matches[1];

		$patterns = [];

		$replacements = [];

		foreach( $matches as $key ){
			$patterns[] = '/\{' . $key . '\}/';

			if( array_key_exists( $key, $vars ) == true ){
				$replacements[] = $vars[ $key ];
			}
			else {
				$replacements[] = '';
			}

		}

		$prepared_url = preg_replace( $patterns, $replacements, $url );

	}

	return $prepared_url;

}



function relative_url( $ext_url ){

	$ext_url = (string) $ext_url;

	$url_parts = @parse_url( $ext_url );

	if( $url_parts === false)
		return false;

	$url = '';

	if( array_key_exists( 'path', $url_parts ) == true ){

		$url.= $url_parts['path'];

	}

	if( array_key_exists( 'query', $url_parts ) == true ){

		$url.= '?' . $url_parts['query'];

	}

	if( array_key_exists( 'fragment', $url_parts ) == true ){

		$url.= '#' . $url_parts['fragment'];

	}

	return $url;

}




/**
 * Метод обрабатывает шаблон Smarty из строки.
 */
function str_tpl( $str, $vars = [] ){

	if( app::$smarty == null ){
		//		app::init_smarty();
		throw new Exception('The Smarty object not initialized.');
	}

	$html = '';

	$tpl_data = app::$smarty->createData();

	if( count( $vars ) > 0 ){
		foreach( $vars as $key => $value ){
			$tpl_data->assign($key, $value);
		}
	}

	$tpl = app::$smarty->createTemplate( 'string:' . $str, $tpl_data );

	$html = $tpl->fetch();

	unset($tpl, $tpl_data);

	return $html;

}

function file_tpl( $tpl_file, $vars ){

	$str = read_file( $tpl_file );

	return str_tpl( $str, $vars );

}




function prepare_emoticons( $html = '' ){

	// Замена смайликов.

	$patterns = [];
	$replacements = [];

	$emoticons = array(
		':\)' 			=> 'smilie.gif',
		':\(' 			=> 'sad.gif',
		':angry:' 		=> 'angry.gif',
		':D' 			=> 'biggrin.gif',
		':blink:' 		=> 'blink.gif',
		':blush:' 		=> 'blush.gif',
		'B\)' 			=> 'cool.gif',
		'<_<' 			=> 'dry.gif',
		'^_^' 			=> 'happy.gif',
		':huh:' 		=> 'confused.gif',
		':lol:' 		=> 'laugh.gif',
		':o' 			=> 'ohmy.gif',
		':fear:' 		=> 'fear.gif',
		':rolleyes:' 	=> 'rolleyes.gif',
		':sleep:' 		=> 'sleep.gif',
		':p' 			=> 'tongue.gif',
		':P' 			=> 'tongue.gif',
		':unsure:' 		=> 'unsure.gif',
		':wacko:' 		=> 'wacko.gif',
		':wink:' 		=> 'wink.gif',
		':wub:'			=> 'wub.gif'
	);

	foreach( $emoticons as $emoticon => $file ){
		$patterns[] = '/' . $emoticon . '/s';
		$replacements[] = '<img src="/site/interface/common/emoticons/' . $file . '" />';
	}

	$html = preg_replace($patterns, $replacements, $html);

	return $html;

}


/**
 * Метод преобразует BB Code в HTML.
 *
 * @link http://www.bbcode.org/
 * @link http://www.phpbb.com/community/faq.php?mode=bbcode
 * @link http://ru.wikipedia.org/wiki/BBCode
 * @link http://en.wikipedia.org/wiki/BBCode
 */
function bbc2html($bbcode_str = ''){

	$html = $bbcode_str;

	$patterns = [];
	$replacements = [];

	$compliance = array(
		'@\[b\](.*?)\[/b\]@' => '<strong>$1</strong>',
		'@\[u\](.*?)\[/u\]@' => '<span style="text-decoration: underline;">$1</span>',
		'@\[i\](.*?)\[/i\]@' => '<em>$1</em>',
		'@\[s\](.*?)\[/s\]@' => '<s>$1</s>',
		'@\[color=(.*?)\](.*?)\[/color\]@' => '<span style="color: $1;">$2</span>',
		'@\[size=(.*?)\](.*?)\[/size\]@' => '<span style="font-size: $1;">$2</span>',
		'@\[img\](.*?)\[/img\]@' => '<img src="$1" />',
		'@\[url\](.*?)\[/url\]@' => '<a href="$1">$1</a>',
		'@\[url=(.*?)\](.*?)\[/url\]@' => '<a href="$1">$2</a>',
		'@\[code](.*?)\[/code\]@' => '<code style="white-space: pre;">$1</code>',
		'@\[quote](.*?)\[/quote\]@' => '<blockquote>$1</blockquote>'
	);

	foreach( $compliance as $bbcode => $replacement ){
		$patterns[] = $bbcode;
		$replacements[] = $replacement;
	}

	$html = preg_replace($patterns, $replacements, $html);

	return $html;

}





/**
 * Стилизует сообщение.
 */
function mes( $mes = '', $type){
	// $class = 'mes';

	switch($type){
		case app::MES_INFO:
			$class = ' info';
			break;
		case app::MES_ERROR:
			//$class = ' error';
			$class = 'bw_mes_error';
			break;
		case app::MES_WARN:
			//$class = ' warn';
			$class = 'bw_mes_warning';
			break;
		case app::MES_OK:
			//$class = ' succesful';
			$class = 'bw_mes_ok';
			break;
	}
	$html = '<div class="' . $class . '">';
	$html.= $mes;
	$html.= '</div>';
	return $html;
}




/**
 * Переводит число из одной единицы измерения в другую.
 * @param arr $params
 * 		$params['value'] int Входяшее значение, которое необходимо перевести.
 * 		$params['iunit'] str Единица измерения входящего значения.
 *  	$params['ounit'] str Единица измерения в которую требуется перевести.
 * 		$params['postfix'] bool Если true, то к возвращаемому числу будет привалена единица измерения.
 * @return mixed
 */
function byte_converter($params){


	/**
	 * Единицы информации.
	 * @link http://ru.wikipedia.org/wiki/%D0%91%D0%B0%D0%B9%D1%82
	 */

	$du = array(
		'b' => 0,
		'kb' => 1,
		'mb' => 2,
		'gb' => 3,
		'tb' => 4,
		'pb' => 5,
		'eb' => 6,
		'zb' => 7,
		'yb' => 8
	);


	/**
	 * Степень.
	 * 0 - для основания 10.
	 * 1 - для основания 2.
	 */
	$du_exponent = array(
		'b' => array(0,0),
		'kb' => array(3,10),
		'mb' => array(6,20),
		'gb' => array(9,30),
		'tb' => array(12,40),
		'pb' => array(15,50),
		'eb' => array(18,60),
		'zb' => array(21,70),
		'yb' => array(24,80)
	);

	$du_dictionary = array(
		'ru' => array(
			'b' => array('б','байт','байт'),
			'kb' => array('кб','килобайт','кибибайт'),
			'mb' => array('мб','мегабайт','мебибайт'),
			'gb' => array('гб','гигабайт','гибибайт'),
			'tb' => array('тб','терабайт','тебибайт'),
			'pb' => array('пб','петабайт','пебибайт'),
			'eb' => array('эб','эксабайт','эксбибайт'),
			'zb' => array('зб','зеттабайт','зебибайт'),
			'yb' => array('йб','йоттабайт','йобибайт')
		),
		'en' => array(
			'b' => array('b','byte','B'),
			'kb' => array('kb','kilobyte','KiB'),
			'mb' => array('mb','megabyte','MiB'),
			'gb' => array('gb','gigabyte','GiB'),
			'tb' => array('tb','terabyte','TiB'),
			'pb' => array('pb','petabyte','PiB'),
			'eb' => array('eb','exabyte','EiB'),
			'zb' => array('zb','zettabyte','ZiB'),
			'yb' => array('yb','yottabyte','YiB')
		)
	);

	$default_params['value'] = 0;
	$default_params['iunit'] = 'b';
	$default_params['ounit'] = 'mb';
	$default_params['postfix'] = true;

	foreach( $default_params as $key => $value ){
		if( isset( $params[ $key ] ) == true ){
			$default_params[ $key ] = $params[ $key ];
		}
	}

	$params = $default_params;


	$value_in_byte = intval( $params['value'] );
	$value_in_byte = abs( $value_in_byte );


	if( $params['iunit'] != 'b' ){
		$value_in_byte = $value_in_byte * pow( 2, $du_exponent[ $params['iunit'] ][1] );
	}

	if( $params['iunit'] != $params['ounit'] ){
		$value_in_byte = round( $value_in_byte / pow( 2, $du_exponent[ $params['ounit'] ][1] ) , 3 );
	}

	if( $params['postfix'] == true ){
		$value_in_byte = $value_in_byte . ' ' . $du_dictionary['en'][ $params['ounit'] ][0];
	}

	return $value_in_byte;

}




// Стандартный serialize может добавлять 0x00 символы.
// Оф. документация В начало имен приватных членов объекта дополняется имя класса,
// а в начало имен защищенных членов '*'. Эти дополненные значения окружаются нулевым байтом (0x00) с обеих сторон.
function custom_serialize( $object ) {
	return base64_encode( gzcompress( serialize( $object ) ) );
}


function custom_unserialize( $content ) {
	return unserialize( gzuncompress( base64_decode( $content ) ) );
}




/**
 * @param $name Ключ в $_REQUEST.
 */
function unserialize_form( $name ){

	$ext_ser_form = get_var( $name );

	parse_str( $ext_ser_form, $vars );

	if( is_array( $vars ) == true ){

		foreach( $vars as $key => $var ){

			$_REQUEST[ $key ] = $var;

		}

	}

}


function mb_parse_url( $url ) {

	$url = (string) $url;

	//		$encoded_url = preg_replace( '%[^:/?#&=\.]+%usDe', 'urlencode(\'$0\')', $url );

	$encoded_url = preg_replace_callback(
		'%[^:/?#&=\.]+%usD',
		function ( $m ) {
			return urlencode( $m[0] );
		},
		$url
	);

	$components = parse_url( $encoded_url );

	if( is_array( $components ) == true ){
		foreach ( $components as $i => $component ){
			$components[ $i ] = urldecode( $component );
		}
	}

	return $components;

}



function unparse_url( $parsed_url ) {

	if( is_array( $parsed_url ) == false ){
		$parsed_url = [];
	}

	$scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
	$host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
	$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
	$user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
	$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
	$pass     = ($user || $pass) ? "$pass@" : '';
	$path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
	$query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
	$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

	return $scheme . $user . $pass . $host . $port . $path . $query . $fragment;

}




/**
 * Используется для удобства вызова callback:
 * 		-функций,
 * 		-статических методов класса
 * 		-методов объектов.
 *
 * @param $callback
 * 		array $callback = array( НАЗВАНИЕ КЛАССА ИЛИ ОБЪЕКТ, НАЗВАНИЕ МЕТОДА )
 * 		str $callback = 'НАЗВАНИЕ ФУНКЦИИ'
 *
 * @param mixed $args
 * 		1 аргумент или массив, передаваемые в вызываемую функцию или метод.
 *
 * @param mixed &$result
 * 		Результат, который вернула callback функция или метод.
 *
 * @return boolean
 * 		true - callback функция или метод найдены и вызваны.
 * 		false - функция или метод не найдены.
 *
 *
 * ПРОБЛЕМА PHP!!! Функция call_user_func возвращает результат вызванной
 * функции или метода. В случае, если callback функция должна возвращать false, то
 * можно посчитать, что это ошибка call_user_func.
 *
 *
 */
function callback( $callback, $args = null, &$result = null ){

	$callback_exists = false;

	if( is_array($callback) == true ){
		// Имя класса или объект.
		$class_name = $callback[0];

		// Метод обработчик.
		$callback = $callback[1];

		if( is_object($class_name) === true && method_exists($class_name, $callback) === true ){
			$result = call_user_func( array( $class_name, $callback ), $args);
			//if( $result !== false )
			$callback_exists = true;
		}else{
			if( class_exists($class_name) && method_exists($class_name, $callback) ){
				$result = call_user_func($class_name . '::' . $callback, $args);
				//if( $result !== false )
				$callback_exists = true;
			}
		}
	}else{
		if( function_exists($callback) ){
			$result = call_user_func($callback, $args);
			//if( $result !== false )
			$callback_exists = true;
		}
	}

	return $callback_exists;

}




/**
 * Метод преобразует строку вида в массив
 *
 * 		app/module_name/callback
 * 		module_name/callback
 * 		$object->method (! пока не работает, сделать через eval)
 * 		class_name::static_method
 * 		function_name
 *
 * $callback = 'site/modules/testfunc';
 * $callback = prepare_callback($callback);
 * callback($callback);
 *
 *
 * для передачи в callback.
 *
 * @todo Сейчас эта функция подключает модуль, возможно нужно убрать в callback.
 * @todo Подумать над тем, чтобы совместить prepare_callback + callback.
 *
 *
 * @return mixed
 * 		array, string, null
 *
 */
function prepare_callback( $callback_str = null ){

	$matches = [];

	if( preg_match( '@([^\/]+)\/([^\/]+)\/([^\/]+)@', $callback_str, $matches ) == true ){
		$app = $matches[1];
		$mod = $matches[2];
		$callback_str = $matches[3];

		app::load_module($mod, $app);

	}else if( preg_match( '@([^\/]+)\/([^\/]+)@', $callback_str, $matches ) == true ){
		$mod = $matches[1];
		$callback_str = $matches[2];
		app::load_module($mod);

	}



	$matches = [];

	if( preg_match( '/\$(.+)\-\>(.+)/', $callback_str, $matches ) == true ){

		// TODO через global и eval

	}else if( preg_match( '/(.+)\:\:(.+)/', $callback_str, $matches ) == true ){

		return array( $matches[1], $matches[2] );

	}

	return $callback_str;

}





function prepare_url( $url ){

	$prepared_url = '';

	$url = (string) $url;

	if( $url == '' ){
		return $prepared_url;
	}

	$prepared_url = $url;

	if( preg_match('/^http(s)?:\/\//', $prepared_url) == false ){
		$prepared_url = 'http://' . $prepared_url;


	}



	//	echo $prepared_url . '<br>';

	//		echo $prepared_url . '<br>';

	$parsed_url = mb_parse_url( $prepared_url );


	//	print_r($parsed_url);

	// TODO url encode

	$prepared_url = unparse_url( $parsed_url );


	return $prepared_url;

}



/**
 *
 */
function unserialize_session_data( $serialized_string ) {
	$variables = [];
	$a = preg_split("/(\w+)\|/", $serialized_string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
	for($i=0;$i<count($a);$i=$i+2){
		$variables[$a[$i]] = unserialize($a[$i+1]);
	}
	return($variables);
}


/**
 * Метод для получения онлайн статуса пользователя.
 *
 * @param array $id_list Список UID.
 *
 *      Принимает массив вида.
 *
 *      array( 1023, 43545, 323, 3434 )
 *
 * @return array
 *
 *      Возвращает массив вида.
 *
 *      array(
 *          1023    => true,
 *          43545   => false,
 *          323     => true,
 *          3434    => true
 *      )
 *
 */
function user_list_online( $id_list = [] ){

	$list = [];

	if( count( $id_list ) > 0 && is_array( $id_list ) == true ){

		$sql = 'SELECT uid FROM ?_sessions WHERE uid IN(?a) AND ( ?d - last_request ) <= ?d AND remove_ts = 0 GROUP BY uid';

		app::$db->field_as_key = 'uid';

		$records = app::$db->sel(
			$sql,
			$id_list,
			time(),
			app::$config['online_interval']
		);


		if( $records == null ){
			$records = [];
		}

		foreach( $id_list as $id ){

			$list[ $id ] = false;

			if( array_key_exists( $id, $records ) == true ){

				$list[ $id ] = true;

			}

		}

	}

	return $list;

}


/**
 * Метод проверяет по user id, в сети ли сейчас пользователь.
 * @param int $uid
 * @return bool
 */
function user_online( $uid ){

	$uid = uintval($uid);

	if( $uid > 0 ){

		$sql = 'SELECT sid FROM ?_sessions WHERE uid = ?d AND ( UNIX_TIMESTAMP() - last_request ) <= ' . app::$config['online_interval'];
		$row = app::$db->selrow($sql, $uid);
		return !empty($row);

	}

	return false;

}


function get_online2( $params = [] ){

	$default_params = [];
	$default_params['limit'] = 100;
	$default_params['page'] = 1;

	foreach( $default_params as $key => $value ){
		if( isset( $params[ $key ] ) === true ){
			if( $key == 'page' || $key == 'limit' ){
				$default_params[ $key ] = uintval( $params[ $key ] );
			}

		}
	}

	$params = $default_params;

	$sql = 'SELECT sid, uid, app, ip FROM ?_sessions WHERE';
	// cron скрипты открывают сессии с 0.
	$sql.= ' ip <> 0';
	$sql.= ' AND ( UNIX_TIMESTAMP() - last_request ) <= ' . app::$config['online_interval'];
	$sql.= ' ORDER BY app';
	$sql.= ' LIMIT ' . ( ( $params['page'] - 1 ) * $params['limit'] ) . ',' . $params['limit'];

	$records = app::$db->sel( $sql );

	return $records;

}


/**
 * Функция возвращает массив с идентификаторами сессий (SID). Точнее
 * с идентификаторами, для гостей всегда 0.
 * Между последним обращением должно быть не более ONLINE_INTERVAL секунд.
 **/
function get_online( $only_sid = true ){
	$_['guests'] = [];
	$_['users'] = [];
	$_['all'] = [];

	$rows = app::$db->sel('SELECT sid, uid FROM ?_sessions WHERE ( UNIX_TIMESTAMP() - last_request ) <= ' . app::$config['online_interval'] );

	if( is_array( $rows ) == true ) {
		foreach ( $rows as $row ) {
			if ( $row['uid'] == 0 ) {
				if ( $only_sid == true )
					$_['guests'][] = $row['sid'];
				else
					$_['guests'][] = $row;
			}
			else {
				if ( $only_sid == true )
					$_['users'][] = $row['sid'];
				else
					$_['users'][] = $row;
			}
			if ( $only_sid == true )
				$_['all'][] = $row['sid'];
			else
				$_['all'][] = $row;
		}
	}

	return $_;
}


/**
 * Функция преобразует массив специального формата (в котором описывается схема таблицы) в SQL.
 *
 * @link http://dev.mysql.com/doc/refman/5.7/en/create-table.html
 */
function sql_array_to_scheme( $arr_table ){

	$arr_table = (array) $arr_table;

	$sql = [];

	$sql[] = 'CREATE TABLE IF NOT EXISTS `' . $arr_table['name'] . '` (';

	$sql_ai_field = '';

	$sql_fields = [];

	foreach( $arr_table['fields'] as $field ){

		$sql_field = [];

		$sql_field[] = '`' . $field['name'] . '`';


		$str = $field['type'] . ( $field['length'] > 0 ? '(' . $field['length'] . ')' : '' );

		if( $field['type'] == 'enum' ){

			$str .= '(\'' . implode( '\',\'', $field['enums'] ) . '\')';

		}

		$sql_field[] = $str;


		if( $field['attribute'] != '' ) {

			$sql_field[] = $field['attribute'];

		}

		if( $field['null'] == true ) {

			$sql_field[] = 'NULL';

		}
		else {

			$sql_field[] = 'NOT NULL';

		}

		if( $field['ai'] == true ){

			$sql_ai_field.= "\n\n";
			$sql_ai_field.= 'ALTER TABLE `' . $arr_table['name'] . '`';
			$sql_ai_field.= ' MODIFY `' . $field['name'] . '`';
			$sql_ai_field.= ' ' . $field['type'] . ( $field['length'] > 0 ? '(' . $field['length'] . ')' : '' );

			if( $field['attribute'] != '' ) {

				$sql_ai_field.= ' ' . $field['attribute'];

			}

			if( $field['null'] == true ) {

				$sql_ai_field.= ' NULL';

			}
			else {

				$sql_ai_field.= ' NOT NULL';

			}

			$sql_ai_field.= ' AUTO_INCREMENT;';

			// $sql_field[] = 'AUTO_INCREMENT';

		}


		if( array_key_exists( 'default', $field ) == true ) {
			if ( $field['default'] !== null ) {

				$sql_field[] = "DEFAULT '" . $field['default'] . "'";

			}
		}

		if( $field['comment'] != '' ){

			$sql_field[] = "COMMENT '" . addslashes( $field['comment'] ) . "'";

		}

		$sql_fields[] = implode( ' ', $sql_field );

	}

	$sql[] = implode( ",\n", $sql_fields );


	$options = [];
	$options['ENGINE'] = 'InnoDB';
	$options['DEFAULT CHARSET'] = 'utf8';

	if( $arr_table['comment'] != '' ){

		$options['COMMENT'] = $arr_table['comment'];

	}


	if( $arr_table['row_format'] != '' ){

		$options['ROW_FORMAT'] = $arr_table['row_format'];

	}




	$arr = [];

	foreach( $options as $key => $option ){

		if( $key == 'COMMENT' ){

			$arr[] = $key . "='" . addslashes( $option ) . "'";

		}
		else {

			$arr[] = $key . '=' . $option;

		}


	}



	$sql[] = ') ' . implode( ' ' , $arr ) . ';';

	if( count( $arr_table['indexes'] ) > 0 ) {

		$sql[] = "\n\n";

		$sql[] = 'ALTER TABLE `' . $arr_table['name'] .'`';

		$sql_indexes = [];

		foreach ( $arr_table['indexes'] as $arr_index ) {

			$sql_index = [];

			$type = 'INDEX';

			if( mb_strtolower( $arr_index['type'] ) == 'primary' ){

				$type = 'PRIMARY KEY';

			}
			else if( mb_strtolower( $arr_index['type'] ) == 'unique' ){

				$type = 'UNIQUE INDEX';

			}
			else if( mb_strtolower( $arr_index['type'] ) == 'fulltext' ){

				$type = 'FULLTEXT INDEX';

			}

			if( mb_strtolower( $arr_index['type'] ) == 'primary' ){

				$sql_index[] = ' ADD ' . $type . ' (';

			}
			else {

				$sql_index[] = ' ADD ' . $type . ' `' . $arr_index['name'] . '` (';

			}



			$sql_fields = [];

			foreach( $arr_index['fields'] as $name ){

				$sql_fields[] = '`' . $name . '`';

			}

			$sql_index[] = implode( ',', $sql_fields );

			$sql_index[] = ')';

			$sql_indexes[] = implode( '', $sql_index );

		}

		$sql[] = implode( ",\n", $sql_indexes ) . ';';

	}

	$sql = implode( "\n", $sql );

	$sql.= $sql_ai_field;

	return $sql;

}


/**
 * Функция находит в тексте запросы, разделённые ; и возвращает в виде массива.
 *
 * @todo Исправить. Не захватывает последний запрос, если нет точки с запятой.
 *
 * @param $sql
 * @return array
 */
function sql_parser( $sql ){

	$queries = [];

	$len = strlen( $sql );

	$opened_quote = false;
	$opened_comment = false;
	$query_start = false;
	$query = '';

	$tmp = '';

	for( $pos = 0; $pos < $len; $pos++ ){

		$char = $sql{ $pos };

		$last_char = '';

		if( $pos > 0 ){
			$last_char = substr( $sql, $pos - 1, 1 );
		}

		if( in_array( $char, ["'",'"','`'] ) == true && $last_char != '\\' ){

			$opened_quote = !$opened_quote;

		}

		//
		// BEGIN Открыть комментарий.
		//

		if( $opened_quote == false && $opened_comment == false ){

			if( $char == '-' && $last_char != '\\' ){

				$str = substr( $sql, $pos, 3 );

				if( $str == '-- ' || $str == "--\n" || $str == "--\r" ){
					$opened_comment = true;
					//		echo "Комментарий открыт $pos <br>";
				}

			}
			else if( $char == '#' && $last_char != '\\' ){

				$opened_comment = true;
				//	echo "Комментарий открыт $pos <br>";

			}

		}

		//
		// END Открыть комментарий.
		//



		if( $opened_comment == true ){
			if( $char == "\n" || $char == "\r" ){
				$opened_comment = false;
				//		echo "Комментарий закрыт $pos <br>";
			}
		}


		if( $opened_comment == false ){
			$tmp.= $char;
		}

		if( $opened_comment == false && $query_start == false ){

			$query_start = true;
			$query = '';

			//	echo 'Начало запроса ' . $pos . '<br>';

		}

		if( $opened_comment == false && $query_start == true ){
			$query.= $char;
		}

		if( ( $opened_comment == false && $char == ';' && $last_char != '\\' )
			|| ( $opened_comment == false && $last_char != '\\' && $pos == $len - 1 ) ){

			//	echo 'Конец запроса ' . $pos . '<br>';

			$query = trim( $query );
			$query = trim( $query, ';' );

			$queries[] = $query;


			$query_start = false;

		}

	}

	return $queries;

}


/**
 * Функция парсит 1 запрос.
 *
 * @param $sql
 */
function sql_parse_query( $sql ){

	$len = strlen( $sql );

	$opened_quote = false;
	$word_begin = false;
	$word_end = false;
	$current_word = '';

	$words = [];

	$query_type = '';
	$statement = '';
	$stop_word = '';

	$arr_data = [
		'type' => '',
		'table_options' => [],
		'alter_specifications' => [],
	];

	$arr_statement_type = [
		'SET',
		'ALTER',
		'CREATE',
		'DROP',
		'RENAME',
		'TRUNCATE',
	];

	for( $pos = 0; $pos < $len; $pos++ ){

		$char = get_char($sql,$pos);


		$last_char = '';

		if( $pos > 0 ){
			$last_char = substr( $sql, $pos - 1, 1 );
		}

		if( in_array( $char, ["'",'"','`'] ) == true && $last_char != '\\' ){

			$opened_quote = !$opened_quote;

		}


		$char_code = ord($char);

	//	echo $char . ' = ' . ord($char). "\n";

		if( $word_begin == false && $char_code != 32 ){

			$word_begin = true;

		}


		// Закрыть слово.
		if( $word_begin == true && $char_code == 32 ){

			$words[] = $current_word;

			if( $query_type == '' ){

				if( in_array( mb_strtoupper( $current_word ), $arr_statement_type ) == true ){

					$query_type = $current_word;

					$arr_data['type'] = $query_type;

				}

			}
			else {

				if( mb_strtoupper( $query_type ) == 'ALTER' ){

					$arr_stop_words = [
						'ADD',
						'ALGORITHM',
						'CHANGE',
						'ALTER',
						'LOCK',
						'MODIFY',
						'DROP',
						'DISABLE',
						'ENABLE',
						'RENAME',
						'ORDER',
						'CONVERT',
						'DISCARD',
						'IMPORT',
						'FORCE',
						'TRUNCATE',
						'COALESCE',
						'REORGANIZE',
						'EXCHANGE',
						'ANALYZE',
						'CHECK',
						'OPTIMIZE',
						'REBUILD',
						'REPAIR',
						'REMOVE',
						'UPGRADE'
					];


					if( $stop_word == '' && in_array( mb_strtoupper( $current_word ), $arr_stop_words ) == true ){

						$stop_word = $current_word;

						echo $stop_word . "\n";

					}


				}

			}


			$current_word = '';
			$word_begin = false;

		}

		if( $word_begin == true && $char_code > 31 ){

			$current_word.= $char;

		}




		/*
		if( $word_begin == false && ord( $char ) != 32 ){

			$current_word.= $char;
			$word_begin = true;

		}

		if( $word_begin == true && ord( $char ) == 32 ){

			echo $current_word . "\n";
			$word_begin = false;
			$current_word = '';
		}
		*/



	}


/*

	foreach( $words as $word ){

		$word = mb_strtoupper( $word );

		$type = null;

		if( in_array( $word, $arr_statement_type ) == true ){

			$type = $word;

		}

		if( $type !== null ){

			if( $type == 'ALTER' ){




			}

		}

	}
*/


	//print_r($words);
	//print_r($arr_data);

	return $arr_data;

}

function sql_parse_create_table2( $sql ){

	spl_autoload_register(function($class) {

		$path = implode( '/', explode( '\\', $class ) );

		$file = app::$config['dirs']['root'] . '/' . $path . '.php';

		echo $file;

		if( is_file( $file ) == true ){

			require_once( $file );

		}

	});

	require_once( app::$config['dirs']['root'] . '/SqlParser/Parser.php');



	$parser = new SqlParser\Parser($sql);

	foreach( $parser->statements as $stat ){

		print_r( $stat );
	}


}

/**
 * Функция возвращает массив в формате параметра $arr_table функции sql_array_to_scheme().
 *
 * @param $sql Основной запрос с CREATE TABLE.
 * @param $extra_sql ALTER TABLE запросы.
 */
function sql_parse_create_table( $sql, $extra_sql = '' ){

	spl_autoload_register(function($class) {

		$path = implode( '/', explode( '\\', $class ) );

		$file = app::$kernel_dir . '/other/' . $path . '.php';

		if( is_file( $file ) == true ){

			require_once( $file );

		}

	});

	require_once( app::$kernel_dir . '/other/PHPSQLParser/PHPSQLParser.php');

	$parser = new PHPSQLParser\PHPSQLParser();
	$parsed = $parser->parse($sql);


	$table = null;

	if( array_key_exists( 'CREATE', $parsed ) == true
		&& array_key_exists( 'TABLE', $parsed ) == true ) {

		//echo '<pre>'. var_export($parsed,true) . '</pre>';




		echo '<pre>' . var_export($parsed['TABLE']['options'],true) . '</pre>';



		$table = [];

		$table['name'] = $parsed['TABLE']['no_quotes']['parts'][0];

		$table['engine'] = 'InnoDB';
		$table['comment'] = '';
		$table['row_format'] = '';
		$table['fields'] = [];
		$table['indexes'] = [];



	//	if( $table['name'] == 'keys' ){

	//		echo '<pre>'. var_export($parsed,true) . '</pre>';

	//	}



		foreach( $parsed['TABLE']['options'] as $option ){

			if( preg_match( '/^COMMENT\=/isum', $option['base_expr'] ) == true ){

				$table['comment'] = $option['sub_tree'][2]['base_expr'];

				$table['comment'] = trim( $table['comment'], "'" );

				//echo '<pre>' . var_export($option['sub_tree'][2]['base_expr'],true) . '</pre>';

			}


			if( preg_match( '/^ROW_FORMAT\=/isum', $option['base_expr'] ) == true ){

				$table['row_format'] = $option['sub_tree'][2]['base_expr'];

			//	$table['row_format'] = trim( $table['comment'], "'" );

				//echo '<pre>' . var_export($option['sub_tree'][2]['base_expr'],true) . '</pre>';

			}


		}





		foreach ( $parsed['TABLE']['create-def']['sub_tree'] as $item ) {


			if ( $item['expr_type'] != 'column-def' ) {

				continue;

			}


			echo '<pre>'. var_export($item,true) . '</pre>';

			$col_name = null;

			$col_ref = null;
			$col_type = null;

			foreach ( $item['sub_tree'] as $item2 ) {

				if ( $item2['expr_type'] == 'colref' ) {

					$col_ref = $item2;

				}
				else if ( $item2['expr_type'] == 'column-type' ) {

					$col_type = $item2;

				}

			}


			$col_name = $col_ref['no_quotes']['parts'][0];

			$table['fields'][ $col_name ] = [
				'name' => $col_name,
				'type' => '',
				'length' => '',
				'default' => null,
				'attribute' => '',
				'null' => false,
				'ai' => false,
				'comment' => '',
				'enums' => []
			];


			foreach ( $col_type['sub_tree'] as $item2 ) {

				//echo '<pre>'. var_export($item2,true) . '</pre>';

				if ( $item2['expr_type'] == 'data-type' || $item2['base_expr'] == 'enum' ) {

					$type = $item2['base_expr'];

					if( $item2['base_expr'] == 'enum' ){

						foreach( $item2['sub_tree']['sub_tree'] as $el ){

							$table['fields'][ $col_name ]['enums'][] = $el['base_expr'];

						}
					//	$type.= $item2['sub_tree']['base_expr'];

					}


			//		echo '<pre>' . var_export($table['fields'][ $col_name ]['enums'],true) . '</pre>';


					$table['fields'][ $col_name ]['type'] = $type;


					$arr_length = [];

					if ( array_key_exists('length', $item2) == true ) {

						$arr_length[] = $item2['length'];

					}

					if ( array_key_exists('decimals', $item2) == true ) {

						$arr_length[] = $item2['decimals'];

					}


					$table['fields'][ $col_name ]['length'] = implode( ',', $arr_length );




				}
				else if( $item2['expr_type'] == 'bracket_expression' ){

					if ( array_key_exists('unsigned', $item2) == true ) {

						if( $item2['unsigned'] == true ) {

							$table['fields'][ $col_name ]['attribute'] = 'UNSIGNED';

						}

					}

				}
				else if ( $item2['expr_type'] == 'comment' ) {

					$table['fields'][ $col_name ]['comment'] = trim($item2['base_expr'], "'");

				}
				else if ( $item2['expr_type'] == 'default-value' ) {

					$table['fields'][ $col_name ]['default'] = trim($item2['base_expr'], "'");

				}
				else if ( $item2['base_expr'] == 'AUTO_INCREMENT' ) {

					$table['fields'][ $col_name ]['ai'] = true;

				}




			}


		}



		$arr_index_converter = [
			'primary-key' => 'primary',
			'index' => 'index',
			'unique-index' => 'unique',
			'fulltext-index' => 'fulltext',
		];


		foreach ( $parsed['TABLE']['create-def']['sub_tree'] as $item ) {



			if ( $item['expr_type'] != 'primary-key'
				&& $item['expr_type'] != 'index'
				&& $item['expr_type'] != 'unique-index'
				&& $item['expr_type'] != 'fulltext-index'
			) {

				continue;

			}


			// Fix. Не распознаёт, поэтому введена доп. проверка.
			if( preg_match( '/^UNIQUE KEY/isum', $item['base_expr'] ) == true ){

				$item['expr_type'] = 'unique-index';

			}



			$arr_index = [
				'name' => $item['sub_tree'][1]['base_expr'],
				'type' => $arr_index_converter[ $item['expr_type'] ],
				'fields' => []
			];

			$arr_index['name'] = trim( $arr_index['name'], '`' );
			$arr_index['name'] = trim( $arr_index['name'] );

			if( $arr_index['type'] == 'primary' ){

				$arr_index['name'] = '';

			}



			//	if( is_array( $item['sub_tree'][2]['sub_tree'] ) == false ) {

		//		echo '<pre>' . var_export($item, true) . '</pre>';

		//	}

			foreach( $item['sub_tree'] as $i => $sub_tree ){

				if( $sub_tree['expr_type'] == 'column-list' ){



					foreach( $sub_tree['sub_tree']  as $arr_column ){

						$arr_column['name'] = trim( $arr_column['name'], '`' );
						$arr_column['name'] = trim( $arr_column['name'] );

						$arr_index['fields'][] = $arr_column['name'];

					}


				}

			}


			$table['indexes'][] = $arr_index;


		}

	}



	return $table;


	if( $extra_sql != '' ){

		$arr_type = [];
		$arr_type[] = 'ALTER DATABASE';
		$arr_type[] = 'ALTER EVENT';
		$arr_type[] = 'ALTER FUNCTION';
		$arr_type[] = 'ALTER INSTANCE';
		$arr_type[] = 'ALTER LOGFILE GROUP';
		$arr_type[] = 'ALTER PROCEDURE';
		$arr_type[] = 'ALTER SERVER';
		$arr_type[] = 'ALTER TABLE';
		$arr_type[] = 'ALTER TABLESPACE';
		$arr_type[] = 'ALTER VIEW';
		$arr_type[] = 'CREATE DATABASE';
		$arr_type[] = 'CREATE EVENT';
		$arr_type[] = 'CREATE FUNCTION';
		$arr_type[] = 'CREATE INDEX';
		$arr_type[] = 'CREATE LOGFILE GROUP';
		$arr_type[] = 'CREATE PROCEDURE';
		$arr_type[] = 'CREATE FUNCTION';
		$arr_type[] = 'CREATE SERVER';
		$arr_type[] = 'CREATE TABLE';
		$arr_type[] = 'CREATE TABLESPACE';
		$arr_type[] = 'CREATE TRIGGER';
		$arr_type[] = 'CREATE VIEW';
		$arr_type[] = 'DROP DATABASE';
		$arr_type[] = 'DROP EVENT';
		$arr_type[] = 'DROP FUNCTION';
		$arr_type[] = 'DROP INDEX';
		$arr_type[] = 'DROP LOGFILE GROUP';
		$arr_type[] = 'DROP PROCEDURE';
		$arr_type[] = 'DROP FUNCTION';
		$arr_type[] = 'DROP SERVER';
		$arr_type[] = 'DROP TABLE';
		$arr_type[] = 'DROP TABLESPACE';
		$arr_type[] = 'DROP TRIGGER';
		$arr_type[] = 'DROP VIEW';
		$arr_type[] = 'RENAME TABLE';
		$arr_type[] = 'TRUNCATE TABLE';


		$queries = [];

		$len = strlen( $extra_sql );

		$opened_quote = false;
		$opened_comment = false;
		$query_start = false;
		$query = '';

	//	$tmp = '';

		for( $pos = 0; $pos < $len; $pos++ ){

			$query_type = '';

			$char = $extra_sql{ $pos };

			$last_char = '';

			if( $pos > 0 ){
				$last_char = substr( $extra_sql, $pos - 1, 1 );
			}

			if( in_array( $char, ["'",'"','`'] ) == true && $last_char != '\\' ){

				$opened_quote = !$opened_quote;

			}

			//
			// BEGIN Открыть комментарий.
			//

			if( $opened_quote == false && $opened_comment == false ){

				if( $char == '-' && $last_char != '\\' ){

					$str = substr( $extra_sql, $pos, 3 );

					if( $str == '-- ' || $str == "--\n" || $str == "--\r" ){
						$opened_comment = true;
						//		echo "Комментарий открыт $pos <br>";
					}

				}
				else if( $char == '#' && $last_char != '\\' ){

					$opened_comment = true;
					//	echo "Комментарий открыт $pos <br>";

				}

			}

			//
			// END Открыть комментарий.
			//



			if( $opened_comment == true ){
				if( $char == "\n" || $char == "\r" ){
					$opened_comment = false;
					//		echo "Комментарий закрыт $pos <br>";
				}
			}


		//	if( $opened_comment == false ){
		//		$tmp.= $char;
		//	}

			if( $opened_comment == false && $query_start == false ){

				$query_start = true;
				$query = '';

				//	echo 'Начало запроса ' . $pos . '<br>';

			}

			if( $opened_comment == false && $query_start == true ){
				$query.= $char;
			}

			if( ( $opened_comment == false && $char == ';' && $last_char != '\\' )
				|| ( $opened_comment == false && $last_char != '\\' && $pos == $len - 1 ) ){

				//	echo 'Конец запроса ' . $pos . '<br>';

				$query = trim( $query );
				$query = trim( $query, ';' );






				$queries[] = $query;


				$query_start = false;

			}

		}



		print_r($queries);



		echo $extra_sql;
		exit;

	}


	return $table;

}




/**
 * Метод проверяет, в каких группах состоит текущий пользователь.
 *
 * @param mixed
 * 		Первый параметр $uid
 * 		Остальные, название группы.
 * $groups Массив с названиями групп.
 * Имена групп не чувствительны к регистру.
 * @return bool
 * 		true - если пользователь состоит во всех
 * 		перечисленных в $groups группах.
 * 		false - если пользователь не состоит в одной или более
 * 		из перечисленных групп.
 *
 * TODO Добавить тип сравнения OR или AND
 */
function user_check_groups(){

	if( func_num_args() < 2 )
		return false;

	$uid = func_get_arg(0);

	$groups = [];

	$args = func_get_args();

	// Убрать uid.
	array_shift( $args );

	foreach( $args as $arg ){
		if( is_array( $arg ) == true ){
			foreach( $arg as $group ){
				$groups[] = $group;
			}
		}else{
			$groups[] = $arg;
		}
	}



	if( count( $groups ) == 0 )
		return false;



	$groups_list = user_get_user_groups($uid);


	$exist = true;

	$c = 0;

	foreach( $groups as $group ){
		$group = mb_strtolower( $group );
		if( isset( $groups_list[ $group ] ) === false ){
			break;
			$exist = false;
		}else if( isset( $groups_list[ $group ] ) === true ){
			$c++;
		}
	}

	if( $c != count( $groups ) )
		return false;

	return $exist;

}


/**
 * Метод возвращает список пользователей перечисленных групп.
 *
 * @return null | array
 */
function user_get_users_by_groups(){

	$arguments = func_get_args();

	$id_list = [];

	$groups = user_get_groups_by_name( $arguments );

	if( is_array( $groups ) == true ){

		foreach( $groups as $group ){

			$id_list[] = $group['id'];

		}

	}

	$sql = 'SELECT u.*, ug.gid, g.name AS `group_name` FROM ?_users u';
	$sql.= ' LEFT JOIN ?_users_groups ug';
	$sql.= ' ON ( ug.uid = u.id )';
	$sql.= ' LEFT JOIN ?_groups g';
	$sql.= ' ON ( ug.gid = g.id )';
	$sql.= ' WHERE';
	$sql.= ' ug.gid IN (?a)';
	$sql.= ' AND u.remove_ts = ?d';

	app::$db->field_as_key = 'id';

	$records = app::$db->sel( $sql, $id_list, 0 );

	return $records;

}



/**
 * Метод возвращает список пользователей по названию группы.
 */
function user_get_users_by_group_name( $name ){

	$users = [];

	$groups = user_get_groups();

	$gid = 0;

	$name = mb_strtolower( $name );

	foreach( $groups as $group_name => $group ){



		if( $group_name == $name ){
			$gid = $group['id'];
			break;
		}

	}


	if( $gid > 0 ){

		$sql = 'SELECT uid FROM ?_users_groups WHERE gid = ?d';
		$records = app::$db->sel($sql, $gid);

		$id_list = [];

		foreach( $records as $record ){
			$id_list[] = $record['uid'];
		}

		if( count( $id_list ) > 0 ){

			$sql = 'SELECT * FROM ?_users WHERE id IN (' . implode(',', $id_list) . ')';

			$users = app::$db->sel($sql);



		}



	}

	return $users;

}

/**
 * Метод возвращает группы текущего либо указанного пользователя.
 *
 * @param int $uid
 * @return arr $groups_list
 */
function user_get_user_groups( $uid ){
	$groups_list = [];

	$uid = uintval($uid);

	if( $uid == 0 )
		return $groups_list;

	/*
	$groups_list = cache::get('groups|uid=' . $uid);

	if( $groups_list === false ){
		$groups_list = [];

		$sql = 'SELECT * FROM ?_users_groups ug';
		$sql.= ' LEFT JOIN ?_groups g';
		$sql.= ' ON ug.gid = g.id';
		$sql.= ' WHERE ug.uid = ?d';
		$sql.= ' ORDER BY g.name';

		$records = app::$db->sel($sql, $uid);

		foreach( $records as $record ){
			$groups_list[ mb_strtolower( $record['name'] ) ] = $record;
		}
		unset($records);
		cache::set('groups|uid=' . $uid,$groups_list,0);
	}
	*/


	$sql = 'SELECT * FROM ?_users_groups ug';
	$sql.= ' LEFT JOIN ?_groups g';
	$sql.= ' ON ug.gid = g.id';
	$sql.= ' WHERE ug.uid = ?d';
	$sql.= ' ORDER BY g.name';

	$records = app::$db->sel($sql, $uid);

	if( is_array( $records ) == true ){
		foreach( $records as $record ){
			$groups_list[ mb_strtolower( $record['name'] ) ] = $record;
		}
	}


	unset($records);



	return $groups_list;

}


/**
 * Метод возвращает список всех групп, которые есть в базе.
 *
 * @return arr $groups_list
 */
function user_get_groups(){

	$groups_list = cache::get('groups');
	if( $groups_list === false ){
		$groups_list = [];
		$records = app::$db->sel('SELECT * FROM ?_groups ORDER BY name');
		foreach( $records as $record ){
			$groups_list[ mb_strtolower( $record['name'] ) ] = $record;
		}
		unset($records);
		cache::set('groups',$groups_list,0);
	}

	return $groups_list;
}


/**
 * Метод устанавливает группы указанному пользователю.
 *
 * @param int $id Код пользователя.
 * @param arr $groups Перечисленные названия групп.
 * @return bool
 */
function user_set_groups($id, $groups = []){
	if( empty($groups) == true )
		return false;

	$groups_list = user_get_groups();

	foreach( $groups as &$group ){
		$group = mb_strtolower( $group );
		if( isset( $groups_list[$group] ) == false )
			return false;
	}

	$user = app::$db->selrow('SELECT id FROM ?_users WHERE id = ?d', $id);

	if( empty($user) == true )
		return false;



	// TODO Переделать.
	app::$db->q('DELETE FROM ?_users_groups WHERE uid = ?d', $id);



	foreach( $groups as $group ){
		$group = $groups_list[$group];

		//	app::cons( $group );
		app::$db->q('INSERT ?_users_groups SET uid = ?d, gid = ?d', $id, $group['id']);
	}


	cache::refresh('groups|uid='.$id);

	return true;

}


function user_get_user( $id ){

	$user = null;

	$user = new User();

	if( $user->init( $id ) == false ){

		$user = null;

	}

	return $user;

}

function user_unset_groups(){

}

/**
 * Метод добавляет нового пользователя.
 *
 * Метод не осуществляет проверок, только вставляет запись.
 *
 * @param array $params - Можно задать список групп.
 *
 * 		arr $params['groups'] - Список названий групп.
 * 		str $params['login']
 * 		str $params['email']
 * 		str $params['password']
 *
 *
 *
 * @return int $id - Код нового пользователя или false.
 */
function user_create( $params = [] ){

	$groups = $params['groups'];

	$data = [];

	if( $params['login'] == '' ){

		return false;

	}

	$data['login'] = $params['login'];
	$data['email'] = $params['email'];
	$data['password_hash'] = md5( $params['password'] );

	$data['reg_ts'] = time();
	$data['active'] = 1;

	$sql = 'INSERT INTO ?_users SET ?l, reg_ip = INET6_ATON(?)';

	$id = app::$db->ins($sql, $data, $_SERVER['REMOTE_ADDR'] );

	if( $id > 0 ){
		user_set_groups( $id, $groups );
	}

	return $id;

}

/**
 * Перечисленные через запятую названия групп. Регистр не имеет значения.
 * Имена групп регистронезависимые.
 * @return array
 */
function user_get_groups_by_name(){

	$groups = null;

	$names = [];

	$arguments = func_get_args();

	// TODO Вынести данную конструкцию в utils.
	if( count( $arguments ) > 0 ){

		foreach( $arguments as $argument ){

			if( is_array( $argument ) == true ){

				foreach( $argument as $item ){

					$names[] = (string) $item;

				}

			}
			else if( is_string( $argument ) == true ){

				$names[] = (string) $argument;

			}



		}

	}

	if( count( $names ) > 0 ){

		$sql = 'SELECT * FROM ?_groups WHERE name IN (?a)';

		app::$db->field_as_key = 'id';

		$groups = app::$db->sel( $sql, $names );

	}


	return $groups;

}

function user_get_group_by_name( $name ){

	$groups = user_get_groups();

	$name = mb_strtolower($name);

	foreach( $groups as $group_name => $data ){
		if( $group_name == $name ){
			return $data;
		}
	}

	return false;

}



/**
 * Склеиватель файлов
 *
 * @deprecated
 *
 * @param array $files
 * @param string $content_type
 * @param $config
 * @throws exception
 */
function glue_files($files=[],$content_type='text/plain',$config){
	$content = '';

	foreach($files as $file){
		if( $content_type == 'text/css' ){
			$content.= '/***********************************************************************************'."\n";
			$content.= ' * начало ' . $file . "\n";
			$content.= ' ***********************************************************************************/'."\n";
		}else{
			$content.= '//////////////////////////////////////////////////////////////////////////////////'."\n";
			$content.= '// начало ' . $file . "\n";
			$content.= '//////////////////////////////////////////////////////////////////////////////////'."\n";
		}
		$content.= read_file($file)."\n";
		if( $content_type == 'text/css' ){
			$content.= '/***********************************************************************************'."\n";
			$content.= ' * конец ' . $file . "\n";
			$content.= ' ***********************************************************************************/'."\n\n";
		}else{
			$content.= '//////////////////////////////////////////////////////////////////////////////////'."\n";
			$content.= '// конец ' . $file . "\n";
			$content.= '//////////////////////////////////////////////////////////////////////////////////'."\n\n";
		}
	}

	header('Content-Type: ' . $content_type . '; charset=utf-8');

	if( $config['output']['gzip'] === true ){
		header('Content-Encoding: gzip');
		echo gzencode($content, $config['output']['level']);
	}else{
		echo $content;
	}

}

/**
 * Метод для распаковки архива.
 *
 * @param string $file
 * @param string $dir
 * @return boolean
 */
function unzip( $file, $dir = '' ){

	if( is_file( $file ) == false )
		return false;

	if( extension_loaded('zlib') == false )
		return false;

	if( is_dir($dir) == false )
		mkdir( $dir, 0777, true );

	if( is_dir($dir) == false )
		return false;

	$zip_handle = zip_open($file);

	if( is_resource( $zip_handle ) == true ){
		while( $zip_entry = zip_read($zip_handle) ){
			if( $zip_entry !== false ){
				$zip_name = zip_entry_name($zip_entry);
				$zip_size = zip_entry_filesize($zip_entry);
				if( ( $zip_size == 0 ) && ( $zip_name[ strlen( $zip_name ) - 1 ] == '/' ) ){

					$sub_dir = $dir . '/' . $zip_name;
					if( is_dir( $sub_dir ) == false )
						mkdir( $sub_dir, 0777, true );
				}else{
					@zip_entry_open( $zip_handle, $zip_entry, 'r' );
					$fp = @fopen( $dir . '/' . $zip_name, 'wb+' );
					@fwrite( $fp, zip_entry_read($zip_entry, $zip_size), $zip_size );
					@fclose($fp);
					@chmod( $dir . '/' . $zip_name, 0777 );
					@zip_entry_close( $zip_entry );
				}
			}
		}
		zip_close($zip_handle);
		return true;
	}else{
		return false;
	}
}



function file_info( $file ){

	if( file_exists( $file ) == false ){
		return null;
	}


	$info = [];

	$info['file'] = $file;

	// Тип файла.
	$info['type'] = '';

	$perms = fileperms( $info['file'] );

	$info['mode'] = substr( sprintf( '%o', fileperms( $info['file'] ) ), -4 );

	if ( ( $perms & 0xC000 ) == 0xC000 ) {
		// Сокет.
		$info['type'] = 's';
	}
	elseif ( ( $perms & 0xA000 ) == 0xA000 ) {
		// Символическая ссылка.
		$info['type'] = 'l';
	}
	elseif ( ( $perms & 0x8000 ) == 0x8000 ) {
		// Обычный.
		$info['type'] = '-';
	}
	elseif ( ( $perms & 0x6000 ) == 0x6000 ) {
		// Специальный блок.
		$info['type'] = 'b';
	}
	elseif ( ( $perms & 0x4000 ) == 0x4000 ) {
		// Директория.
		$info['type'] = 'd';
	}
	elseif ( ( $perms & 0x2000 ) == 0x2000 ) {
		// Специальный символ.
		$info['type'] = 'c';
	}
	elseif ( ( $perms & 0x1000 ) == 0x1000 ) {
		// Поток FIFO.
		$info['type'] = 'p';
	}
	else {
		// Неизвестный.
		$info['type'] = 'u';
	}






	$info['perms']['owner']['read']         = false;
	$info['perms']['owner']['write']        = false;
	$info['perms']['owner']['execute']      = false;
	$info['perms']['owner']['set_uid']      = false;

	$info['perms']['group']['read']         = false;
	$info['perms']['group']['write']        = false;
	$info['perms']['group']['execute']      = false;
	$info['perms']['group']['set_gid']      = false;

	$info['perms']['other']['read']         = false;
	$info['perms']['other']['write']        = false;
	$info['perms']['other']['execute']      = false;
	$info['perms']['other']['sticky_bit']   = false;

	$info['string'] = [];


	$info['string'][] = $info['type'];


	//
	// BEGIN Owner.
	//

	if( $perms & 0x0100 ){
		$info['perms']['owner']['read'] = true;
		$info['string'][] = 'r';
	}
	else {
		$info['perms']['owner']['read'] = false;
		$info['string'][] = '-';
	}


	if( $perms & 0x0080 ){
		$info['perms']['owner']['write'] = true;
		$info['string'][] = 'w';
	}
	else {
		$info['perms']['owner']['write'] = false;
		$info['string'][] = '-';
	}


	if( $perms & 0x0040 ){

		$info['perms']['owner']['execute'] = true;

		if ( $perms & 0x0800 ){
			$info['string'][] = 's';
			$info['perms']['owner']['set_uid'] = true;
		}
		else {
			$info['string'][] = 'x';
		}

	}
	else {

		if ( $perms & 0x0800 ){
			$info['string'][] = 'S';
			$info['perms']['owner']['set_uid'] = true;
		}
		else {
			$info['string'][] = '-';
		}

	}

	//
	// END Owner.
	//



	//
	// BEGIN Group.
	//

	if( $perms & 0x0020 ){
		$info['perms']['group']['read'] = true;
		$info['string'][] = 'r';
	}
	else {
		$info['perms']['group']['read'] = false;
		$info['string'][] = '-';
	}


	if( $perms & 0x0010 ){
		$info['perms']['group']['write'] = true;
		$info['string'][] = 'w';
	}
	else {
		$info['perms']['group']['write'] = false;
		$info['string'][] = '-';
	}


	if( $perms & 0x0008 ){

		$info['perms']['group']['execute'] = true;

		if ( $perms & 0x0400 ){
			$info['string'][] = 's';
			$info['perms']['group']['set_gid'] = true;
		}
		else {
			$info['string'][] = 'x';
		}

	}
	else {

		if ( $perms & 0x0400 ){
			$info['string'][] = 'S';
			$info['perms']['group']['set_gid'] = true;
		}
		else {
			$info['string'][] = '-';
		}

	}

	//
	// END Group.
	//










	//
	// BEGIN Other.
	//

	if( $perms & 0x0004 ){
		$info['perms']['other']['read'] = true;
		$info['string'][] = 'r';
	}
	else {
		$info['perms']['other']['read'] = false;
		$info['string'][] = '-';
	}


	if( $perms & 0x0002 ){
		$info['perms']['other']['write'] = true;
		$info['string'][] = 'w';
	}
	else {
		$info['perms']['other']['write'] = false;
		$info['string'][] = '-';
	}


	if( $perms & 0x0001 ){

		$info['perms']['other']['execute'] = true;

		if ( $perms & 0x0200 ){
			$info['string'][] = 't';
			$info['perms']['other']['sticky_bit'] = true;
		}
		else {
			$info['string'][] = 'x';
		}

	}
	else {

		if ( $perms & 0x0200 ){
			$info['string'][] = 'T';
			$info['perms']['other']['sticky_bit'] = true;
		}
		else {
			$info['string'][] = '-';
		}

	}

	//
	// END Other.
	//

	$info['string'] = implode( '', $info['string'] );

	$info['owner'] = posix_getpwuid( fileowner( $info['file'] ) );
	$info['group'] = posix_getgrgid( filegroup( $info['file'] ) );

	return $info;

}

function db( $index = 0 ){

	return dbm::get( $index );

}

function srv( $index = 0 ){

	return db( $index );

}

function dbsrv( $index = 0 ){

	return db( $index );

}

function db_server( $index = 0 ){

	return db( $index );

}


/**
 * Метод для преобразования URL-адресов найденных в CSS.
 * Метод преобразует адреса начинающиеся с ./ и ../, в адреса от начала домена (абсолютный URL).
 *
 * ./images/1.jpg
 * ../other_images/2.jpg
 * images/3.jpg
 *
 * Всё это преобразуется в адрес относительно начала домена.
 *
 * /images/1.jpg
 * /interface/other_images/2.jpg
 * /images/3.jpg
 *
 * Метод вызывается из preg_replace_callback, поэтому дополнительные данные,
 * берутся из app::$data['correct_url'].
 *
 * > ? app::$data['correct_url']['dirs'] - директории, которые <
 *
 */

function css_correct_url( $value, $path ){

	$url = '';

	$reg_exp = '/^' . preg_quote( app::$config['document_root'], '/' ) . '/';

	$value[1] = trim( $value[1], "'" );
	$value[1] = trim( $value[1], '"' );

	if( preg_match('/^data:/isum', $value[1] ) == true ){

		$url = "url('" . $value[1] . "')";

		return $url;

	}

	if( substr( $value[1], 0, 3 ) == '../' || substr( $value[1], 0, 2 ) == './' ){

		$dir = dirname( $path );

		$path = normalize_path( $dir . '/' . $value[1] );

		if( is_file( $path ) == true){

			$url = preg_replace( $reg_exp, '', $path );

			// Если файл физически не сущесвует, тогда не преобразовывать.
		}
		else{

			$url = $value[1];

		}

	}
	else if( substr( $value[1], 0, 1 ) == '/' ){ // От начала домена.

		$url = $value[1];

	}
	else{

		$url = dirname( $path );

		$url = preg_replace( $reg_exp, '', $url );

		//	echo $reg_exp . '<br />';

		$url = $url . '/' . $value[1];

	}

	$url = "url('" . $url . "')";

	return $url;

}



/**
 *
 *
 * @link http://www.456bereastreet.com/archive/200502/efficient_css_with_shorthand_properties/
 * @param $css
 * @return mixed
 */
function css_native_compessor( $css ){

	// Удалить комментарии.
	// Бывают хаки вида html>/**/body, поэтому не трогать /**/
	$css = preg_replace( '/\/\*.*?\*\//s', '', $css );



	// Удалить лишние пробелы.
	$css = preg_replace( '/\s+/', ' ', $css );
	$css = preg_replace( '/ ?(;|:|}|{|!|>|,) ?/', '\1', $css );
	$css = preg_replace( '/;}/', '}', $css );



	// Сомнительная работа.
	// Бывают случаи 0.5 0.3
	$css = preg_replace( '/0(\.\d*?(em|}| |;))/', '\1', $css );

	$css = preg_replace( '/0px/', '0', $css );


	// none не у всех атрибутов есть. Нужно получить список, кто может иметь число, у тех убрать none.
	$css = preg_replace( '/(border|outline|background):none/i', '\1:0', $css );

	// Сокращение Hex цвета от 6 до 3 символов.
	$css = preg_replace_callback('/#([0-9A-F]{6})/i', 'hex_color', $css);

	// Убрать пустые классы .highslide-image-blur{}
	$css = preg_replace( '/\.[^{]+{}/', '', $css );


	$css = trim( $css );


	return $css;

}

function js_native_compressor( $js ){


	return $js;

}


// Формирует консоль отладки.
// TODO Проверка группы Debuggers / Developers / Administrators
// TODO не захватывает в рендере подключение шаблона.
function debug_console( $ajax_mode = false ){

	$included_files = '';
	$module = app::get_module('main','kernel');

	//		app::add_style( $module->url . '/debug/console.css' );

	//		app::add_style( '/kernel/interface/css/kernel.css' );
	//		app::add_script( '/kernel/interface/js/kernel.js' );

	$html = '';

	for($c=1;$c<=count(app::$db->queries);$c++){
		$html .= $c . '. ' . htmlspecialchars(app::$db->queries[$c-1],ENT_COMPAT,'utf-8') . '<br />';
	}

	$files = get_included_files();
	$inc_count = count($files);

	foreach($files as $file){
		$included_files .= '<div>' . $file . '</div>';
	}

	$time_end = microtime(true);
	$time = $time_end - app::$start_time;
	$time < 0 ? $time = round(($time_end-app::$start_time),3) : $time = round($time,3);

	$vars = [];

	$vars['css_url'] = $module->url . '/debug/console.css';

	$vars['db'] = [
		'name' => app::$config['db']['db'],
		'host' => app::$config['db']['host'],
		'port' => app::$config['db']['port'],
		'user' => app::$config['db']['user'],
		'persistent' => app::$config['db']['persistent']
	];


	if( app::$config['use_cache'] == true ) {
		$vars['cache'] = cache::get_debug_info();
	}

	// Информация о пространстве диска.
	$arr = [];
	exec('df -h', $arr);

	$html2 = '<pre style="padding: 10px; background: #EEEEEE;">';
	$html2.= 'Disk space:' . "\n";
	$html2.= implode( "\n", $arr );
	$html2.= '</pre>';

	$vars['disk_space'] = $html2;

	$vars['cache_engine'] = app::$config['cache_engine'];
	$vars['session_engine'] = app::$config['session_engine'];

	$vars['php_version'] = phpversion();
	$vars['memory_get_usage'] 		= color( number_format( memory_get_usage(),0,'',' ' ), '#0000FF' );
	$vars['memory_limit'] 			= color( number_format( (ini_get('memory_limit') * 1048576 ), 0, '', ' '), '#FF9900');
	$vars['memory_get_peak_usage'] 		= color( number_format( memory_get_peak_usage(true),0,'',' ' ), '#0000FF' );
	$vars['remote_addr'] 			= $_SERVER['REMOTE_ADDR'];
	$vars['session_id'] 			= session_id();
	$vars['query_string'] 			= $_SERVER['QUERY_STRING'];
	$vars['request_method'] 		= $_SERVER['REQUEST_METHOD'];
	$vars['request_uri'] 			= $_SERVER['REQUEST_URI'];
	$vars['queries_count'] 			= count( app::$db->queries );
	$vars['gen_time'] 				= $time;
	$vars['max_execution_time'] 	= ini_get('max_execution_time');
	$vars['queries'] 				= $html;
	$vars['document_root'] 			= $_SERVER['DOCUMENT_ROOT'];
	$vars['included_files'] 		= $included_files;
	$vars['included_files_count'] 	= $inc_count; // . ' ' . datext::proceedTextual($inc_count,'файлов','файл','файла'),

//	$vars['variables'] 				= class_trace::get_var_export();
//	$output = '';
//	foreach(self::$variables as $variable){
//		$output .= '<div style="padding: 10px;"><pre style="padding: 10px; font-family: Courier; margin-bottom: 10px; background: #EEEEEE;">'.var_export($variable,true).'</pre></div>';
//	}



	if( $ajax_mode == true ){

		$template = $module->dir . '/debug/request.phtml';

	}
	else {

		if( app::$tpl->name == 'smarty' ){
			$template = $module->dir . '/debug/console.tpl';
		}
		else {
			$template = $module->dir . '/debug/console.phtml';
		}

	}


	// $mes.= 'Date and time: ' . date('d.m.Y H:i:s') . "\n";
	//$mes.= var_export( $_REQUEST, true );
	//$mes.= var_export( $_SERVER, true );
	//$mes.= var_export( $_SESSION, true );



	return app::$tpl->fetch( $template, $vars );

}




// $month - порядковый номер месяца (0-12).
// $variant - вариант склонения названия месяца (1-3).
function month_name($month=1, $variant=1, $language = null ){

	if( $language == null ){
		$language = app::$language;
	}

	if( $language == 'ru' ){

		$months = array(
			array('январь','января','январе'),
			array('февраль','февраля','феврале'),
			array('март','марта','марте'),
			array('апрель','апреля','апреле'),
			array('май','мая','мае'),
			array('июнь','июня','июне'),
			array('июль','июля','июле'),
			array('август','августа','августе'),
			array('сентябрь','сентября','сентябре'),
			array('октябрь','октября','октябре'),
			array('ноябрь','ноября','ноябре'),
			array('декабрь','декабря','декабре')
		);

	}else if( $language == 'en' ){

		$month = intval($month);

		$months = array(
			1 => 'January',
			2 => 'February',
			3 => 'March',
			4 => 'April',
			5 => 'May',
			6 => 'June',
			7 => 'July',
			8 => 'August',
			9 => 'September',
			10 => 'October',
			11 => 'November',
			12 => 'December'
		);

		// error_log(  $month );

		return $months[ $month ];

	}

	if(($month >= 1 && $month <= 12)&&($variant >= 1 && $variant <= 3)){
		return $months[$month-1][$variant-1];
	}else{
		return false;
	}
}

/**
 * Метод возвращает дату с видом:
 *
 * 13:18 сегодня
 * 20:40 вчера
 * 10:02 позавчера
 * 11:55 22 августа
 * 09:00 16 июня 2010
 *
 */
function date_to_str( $ts, $with_time = true, $as_array = false, $glue = '<br />', $reverse = false ){

	$date = [];

	if( $reverse == false ){
		$date[] = _date('H:i', $ts);
	}

	$year = _date('Y');
	$month = _date('m');
	$day = _date('d');

	$year2 = _date('Y', $ts);
	$month2 = _date('m', $ts);
	$day2 = _date('d', $ts);

	if( _date('d.m.Y') == _date('d.m.Y', $ts) ){
		$date[] = 'сегодня';
	}else if( $year == $year2 && $month == $month2 && ( $day - $day2 ) == 1  ){
		$date[] = 'вчера';
	}else if( $year == $year2 && $month == $month2 && ( $day - $day2 ) == 2  ){
		$date[] = 'позавчера';
	}else{
		$date[] = _date('d', $ts ) . ' ' . month_name( _date('m', $ts ), 2 );

		if( _date('Y') != _date('Y', $ts ) ){
			$date[] = _date('Y', $ts );
		}
	}

	if( $reverse == true ){
		$date[] = 'в ' . _date('H:i', $ts);
	}



	if( $as_array == false ){
		return implode( $glue, $date );
	}else{
		return $date;
	}



}

/**
 * Метод считывает содержимое файла и выдаёт в браузер для скачивания.
 * @param arr $params
 * 		$params['file_path'] 	str 	Абсолютный путь к файлу.
 * 		$params['name'] 		str 	Имя файла которое метод выдаст в браузер.
 * 		$params['safe_name'] 	bool 	Если true, символы в параметре $name будут преобразованы
 * 										в безопасное написание.
 * 		$params['xsendfile']	bool	Заголовок X-Sendfile
 * 										https://tn123.org/mod_xsendfile/
 * @param bool
 * 		true Файл отдан.
 * 		false Проблема с отдачей файла.
 *
 * В конфиге Apache для хоста прописать
 *
 * # https://tn123.org/mod_xsendfile/
 * XSendFile on
 * XSendFileIgnoreEtag on
 * XSendFileIgnoreLastModified on
 * XSendFilePath /var/www/site.com/site/upload/data
 *
 */
function download_file( $params ){

	$default_params = [];
	$default_params['safe_name'] = false;
	$default_params['xsendfile'] = false;
	$default_params['name'] = '';
	$default_params['file_path'] = '';

	$error = false;

	foreach( $default_params as $key => $value ){
		if( isset( $params[ $key ] ) === true ){
			$default_params[ $key ] = $params[ $key ];
		}
	}

	$params = $default_params;

	$mimetype = get_mime($params['file_path']);

	if( $params['xsendfile'] == true ){

		if( function_exists('apache_get_modules') == true ){
			if( in_array( 'mod_xsendfile', apache_get_modules() ) == false ){
				$error = true;
			}
		}
	}else{
		if( is_file( $params['file_path'] ) == true ){
			$content = read_file($params['file_path']);
		}else{
			$error = true;
		}
	}

	if( $error == false ){

		if( $params['safe_name'] == true ){
			// $params['name'] = urlencode($params['name']);
			$params['name'] = class_rus::translit( $params['name'] );
		}

		$headers = [];

		if( $params['xsendfile'] == true ){



			if( preg_match( '/nginx/i', $_SERVER['SERVER_SOFTWARE'] ) == true ){
				$headers[] = 'X-Accel-Redirect: ' . $params['file_path'];
			}
			else {
				$headers[] = 'X-Sendfile: ' . $params['file_path'];
			}


			//	print_r($headers);
			//	exit;

		}

		// $headers[] = 'Content-Description: File Transfer';
		// $headers[] = 'Pragma: public';
		// $headers[] = 'Expires: 0';
		// $headers[] = 'Cache-Control: must-revalidate, post-check=0, pre-check=0';
		// $headers[] = 'Cache-Control: public';

		if( $mimetype !== false ){
			// $headers[] = 'Content-Type: ' . $mimetype . '; charset=utf-8';
			//$headers[] = 'Content-Type: ' . $mimetype;
		}else{
			// $headers[] = 'Content-Type: application/octet-stream; charset=utf-8';
			//$headers[] = 'Content-Type: application/octet-stream';
		}

		$headers[] = 'Content-Type: application/octet-stream';
		$headers[] = 'Content-Disposition: attachment; filename="' . $params['name'] . '"';

		$headers[] = 'Content-Length: ' . filesize( $params['file_path'] );



		//print_r($headers);
		//exit;

		foreach( $headers as $header ){
			header( $header . "\r\n" );
		}

		if( $params['xsendfile'] == false ){
			echo $content;
		}

	}

	return !$error;

}


/**
 * @param $path
 * @param null $download_name
 * @param string $mime
 * @param bool|true $partial Включить поддержку режима скачивания частями. НЕ РЕАЛИЗОВАНО
 */
function download( $path, $download_name = null, $mime = 'application/octet-stream', $partial = false ){

	if( is_file( $path ) == false ){

		return false;

	}

	$fsize = filesize( $path );

	$headers = [];
	$headers[] = 'Pragma: no-cache';
	$headers[] = 'Content-Type: ' . $mime . '; charset=utf-8';
	$headers[] = 'Content-Disposition: attachment; filename="' . $download_name . '"';
	$headers[] = 'Content-Type: application/force-download';
	$headers[] = 'Content-Type: application/octet-stream';
	$headers[] = 'Content-Type: application/download';
	$headers[] = 'Content-Description: File Transfer';
	$headers[] = 'Content-Transfer-Encoding: binary';

	$fp = fopen( $path, 'rb' );

	if( $fp === false ){

		return false;

	}



	if( $partial == true ){


		$headers[] = 'HTTP/1.1 206 Partial Content';


	}
	else {

		$headers[] = 'HTTP/1.1 200 OK';


	}

	$headers[] = 'Content-Length: ' . $fsize;



	if( $partial == true ){



		$begin = 0;
		$end = 0;

		if( array_key_exists( 'HTTP_RANGE', $_SERVER ) == true ){

			app::cons($_SERVER['HTTP_RANGE']);

			$matches = [];

			if( preg_match('/bytes=(\d+)-(\d+)?/i', $_SERVER['HTTP_RANGE'], $matches ) == true ) {

				$begin = intval( $matches[1] );
				$end = intval( $matches[2] );

			}

			$headers[] = 'Accept-Ranges: bytes';
			$headers[] = 'Content-Range: bytes ' . $begin . '-' . $end . '/' . $fsize;

			fseek( $fp, $begin );

		}


	}
	else {



	}




	foreach( $headers as $header ){

		header( $header, true );

	}


	while ( $buffer = fread( $fp, 1024 ) ){

		echo $buffer;

	}

	fclose($fp);

	return true;

}

function download_content( $content, $download_name = null, $mime = 'application/octet-stream' ){

	if( $download_name == null ){
		return false;
	}

	$headers = [];
	$headers[] = 'Pragma: no-cache';
	$headers[] = 'Content-Type: ' . $mime . '; name="' . $download_name . '"';
	$headers[] = 'Content-disposition: attachment; filename=' . $download_name;



	foreach( $headers as $header ){
		header( $header );
	}

	echo $content;

}

function subtract_path( $path, $subtraction_path ){

	$path = preg_replace(
		'@^' . preg_quote( $subtraction_path, '@' ) . '@',
		'',
		$path
	);

	return $path;

}

/**
 * Метод записывает данные о файле в БД.
 *
 * @param $file Элемент массива $_FILES.
 */
function prepare_file( array $file ){

	if( $file['error'] !== 0 ){
		return null;
	}

	$ins_data = [];
	$ins_data['create_ts'] = time();
	$ins_data['uid'] = app::$user->id;
	$ins_data['size'] = $file['size'];
	$ins_data['original_name'] = $file['name'];
	$ins_data['mime'] = get_mime( $file['tmp_name'] );
	$ins_data['name'] = md5( $file['name'] . time() . randstr(100) );
	$ins_data['tmp'] = 1;

	list( $type, $subtype ) = explode('/',$ins_data['mime']);

	if( $type == 'image' ){
		$image_info = getimagesize( $file['tmp_name'] );

		$ins_data['width'] = $image_info[0];
		$ins_data['height'] = $image_info[1];
	}



	$sql = 'INSERT INTO files SET ?l';

	$file_id = app::$db->ins( $sql, $ins_data );


	if( $file_id > 0 ){
		$sql = 'SELECT * FROM files WHERE id = ?d';
		$file = app::$db->selrow( $sql, $file_id );
		return $file;
	}
	else {
		return null;
	}

}



/**
 * Метод осуществляет замену плейсхолдеров даты и времени.
 *
 * @param array $arr_date
 * 		year
 * 		month
 * 		day
 * 		hours
 * 		minutes
 * 		seconds
 *
 */
function date_to_format( $format = 'DD.MM.YYYY HH:MI:SS', $arr_date = null ){

	$output = '';

	$arr_date['year'] = intval($arr_date['year']);
	$arr_date['month'] = intval($arr_date['month']);
	$arr_date['day'] = intval($arr_date['day']);
	$arr_date['hours'] = intval($arr_date['hours']);
	$arr_date['minutes'] = intval($arr_date['minutes']);
	$arr_date['seconds'] = intval($arr_date['seconds']);


	foreach( $arr_date as $k => $v ){



		if( $v > 0 ){



			if( in_array( $k, array( 'month', 'day', 'hours', 'minutes', 'seconds' ) ) == true && strlen( $v ) == 1 ){

				$v = '0' . $v;

			}

		}
		else{

			$v = '';

		}

		$arr_date[ $k ] = $v;


	}




	$output = preg_replace(
		array(
			'@YYYY@i',
			'@MM@i',
			'@DD@i',
			'@HH@i',
			'@MI@i',
			'@SS@i'
		),
		array(
			$arr_date['year'],
			$arr_date['month'],
			$arr_date['day'],
			$arr_date['hours'],
			$arr_date['minutes'],
			$arr_date['seconds']
		),
		$format
	);

	return $output;

}



/**
 * Преобразовывает дату
 * из MySQL DATETIME в UNIX TIMESTAMP
 * Минимальная дата в формате DATETIME
 * 1970-01-01 00:00:00
 * @param str $dt Дата в формате YYYY-MM-DD HH:MM:SS
 */
function dt2ts($dt){

	$arr_date = parse_date( $dt );

	$ts = mktime(
		$arr_date['hours'],
		$arr_date['minutes'],
		$arr_date['seconds'],
		$arr_date['month'],
		$arr_date['day'],
		$arr_date['year']
	);




	/*
	list( $date, $time ) = explode(' ', $dt);
	list( $year, $month, $day ) = explode('-', $date);
	list( $hours, $minutes, $seconds ) = explode(':', $time);
	return mktime(
		intval($hours),
		intval($minutes),
		intval($seconds),
		intval($month),
		intval($day),
		intval($year)
	);

	*/


	return $ts;

}



function date_to_str2( $ts = null ){

	if( $ts === null ){
		$ts = time();
	}

	$arr = parse_timestamp( $ts );

	$str = $arr['day'] . ' ' . month_name( $arr['month'], 2 ) . ' ' . $arr['year'];

	return $str;

}



// Преобразует строку вида 22.12.1983 в переменные $day, $month, $year.
// возвращает false, если передан плохой формат
function strdate2vars($str,&$day,&$month,&$year,&$hours,&$minutes,&$seconds){
	$matches = [];

	if( $str == ''){
		$day = 0;
		$month = 0;
		$year = 0;
		$hours = 0;
		$minutes = 0;
		$seconds = 0;
		return false;
	}

	// ДД.ММ.ГГГГ ЧЧ:ММ:СС
	$res = preg_match('/^(\d\d)\.(\d\d)\.(\d\d\d\d) ?(\d\d)?\:?(\d\d)?\:?(\d\d)?$/',$str,$matches);



	//print_r($matches);
	//print $str;
	if(count($matches)>3){
		$day = intval($matches[1]);
		$month = intval($matches[2]);
		$year = intval($matches[3]);
		if(isset($matches[4])){
			$hours = intval($matches[4]);
		}else{
			$hours = 0;
		}
		if(isset($matches[5])){
			$minutes = intval($matches[5]);
		}else{
			$minutes = 0;
		}
		if(isset($matches[6])){
			$seconds = intval($matches[6]);
		}else{
			$seconds = 0;
		}
		//print_r($matches);
		return true;
	}else{
		return false;
	}
}

// Преобразует строковое представление даты/времени в timestamp.
// Можно передать:
//		22.12.1983
//		22.12.1983 04:30:20
//
// Функция вернёт timestamp.
function strdate2timestamp($strdate,$sep='.',$format=1){
	if( $strdate == '' ) return 0;

	$matches = [];
	// ДД.ММ.ГГГГ ЧЧ:ММ:СС
	if($format==1){
		preg_match('/^((\d\d)\\'.$sep.'(\d\d)\\'.$sep.'(\d\d\d\d)){0,1}[ ]{0,1}((\d\d):(\d\d):(\d\d)){0,1}$/',$strdate,$matches);
	}else if($format==2){
		preg_match('/^((\d\d\d\d)\\'.$sep.'(\d\d)\\'.$sep.'(\d\d)){0,1}[ ]{0,1}((\d\d):(\d\d):(\d\d)){0,1}$/',$strdate,$matches);

		//	print_r($matches);
	}

	//print_r($matches);
	//print '/^((\d\d)\\'.$sep.'(\d\d)\\'.$sep.'(\d\d\d\d)){0,1}[ ]{0,1}((\d\d):(\d\d):(\d\d)){0,1}$/';
	//print $strdate;
	if(count($matches)==9){
		if($format==2){
			$day = $matches[4];
			$month = $matches[3];
			$year = $matches[2];

			$h = $matches[6];
			$m = $matches[7];
			$s = $matches[8];

		}else{
			$day = $matches[2];
			$month = $matches[3];
			$year = $matches[4];

			$h = $matches[6];
			$m = $matches[7];
			$s = $matches[8];

		}

		return mktime($h,$m,$s,$month,$day,$year);
	}

	if(count($matches)==5){
		$day = $matches[2];
		$month = $matches[3];
		$year = $matches[4];

		$h = 0;
		$m = 0;
		$s = 0;

		return mktime($h,$m,$s,$month,$day,$year);
	}

	return false;
}


/**
 * Метод возвращает индекс знака зодиака.
 *
 * Пример использования:
 *
 * $sign = get_zodiac($birth_date);
 * if( $sign != false )
 * 		$zodiac = $zodiac_signs[ app::$language ][ $sign ];
 *
 * @param str $birth_date Дата рождения в формате YYYY-MM-DD или YYYY-MM-DD 00:00:00
 * @param bool $ret_name
 * 		false Вернуть индекс знака Зодиака.
 * 		true Вернуть название знака.
 * @param mixed
 * 		bool false В случае ошибки.
 *  	int Индекс знака Зодиака.
 */
function get_zodiac($birth_date, $ret_name = false){

	/**
	 * Знаки Зодиака.
	 *
	 * DD-MM
	 *
	 * @link http://en.wikipedia.org/wiki/Western_astrology
	 */
	$zodiac_signs_dates = array(
		1 => array('21-03','20-04'),
		2 => array('21-04','20-05'),
		3 => array('21-05','21-06'),
		4 => array('22-06','22-07'),
		5 => array('23-07','22-08'),
		6 => array('23-08','22-09'),
		7 => array('23-09','22-10'),
		8 => array('23-10','22-11'),
		9 => array('23-11','21-12'),
		10 => array('22-12','20-01'),
		11 => array('21-01','18-02'),
		12 => array('19-02','20-03')
	);

	$zodiac_signs = array(
		'ru' => array(
			1 => 'Овен',
			2 => 'Телец',
			3 => 'Близнецы',
			4 => 'Рак',
			5 => 'Лев',
			6 => 'Дева',
			7 => 'Весы',
			8 => 'Скорпион',
			9 => 'Стрелец',
			10 => 'Козерог',
			11 => 'Водолей',
			12 => 'Рыбы'
		),
		'en' => array(
			1 => 'Aries',
			2 => 'Taurus',
			3 => 'Gemini',
			4 => 'Cancer',
			5 => 'Leo',
			6 => 'Virgo',
			7 => 'Libra',
			8 => 'Scorpio',
			9 => 'Sagittarius',
			10 => 'Capricorn',
			11 => 'Aquarius',
			12 => 'Pisces'
		)
	);




	$sign = 0;

	if( $birth_date == '' )
		return false;

	$birth_date = preg_replace('@ \d{1,2}:\d{1,2}:\d{1,2}$@','',$birth_date);

	list( $year, $month, $day ) = explode('-', $birth_date);

	foreach( $zodiac_signs_dates as $index => $interval ){
		list( $d1, $m1 ) = explode('-', $interval[0] );
		list( $d2, $m2 ) = explode('-', $interval[1] );

		if( ( $month == $m1 && $day >= $d1 ) || ( $month == $m2 && $day <= $d2 ) ){
			$sign = $index;
			break;
		}
	}

	if( $ret_name == true && $sign > 0 ){
		$zodiac = $zodiac_signs[ app::$language ][ $sign ];
		return $zodiac;
	}

	return $sign;
}

function _strdate2vars($str,&$day,&$month,&$year,&$hours,&$minutes,&$seconds){

	$matches = [];

	if( preg_match('/^(\d\d\d\d)\-(\d\d)\-(\d\d) (\d\d)\:(\d\d)\:(\d\d)$/',$str,$matches) ){
		$day = $matches[3];
		$month = $matches[2];
		$year = $matches[1];
		$hours = $matches[4];
		$minutes = $matches[5];
		$seconds = $matches[6];
		return true;
	}else if( preg_match('/^(\d\d)\.(\d\d)\.(\d\d\d\d)( (\d\d)\:(\d\d)\:(\d\d))?$/',$str,$matches) ){
		$day = $matches[1];
		$month = $matches[2];
		$year = $matches[3];

		$hours = $matches[5];
		$minutes = $matches[6];
		$seconds = $matches[7];

		return true;
	}else{
		return false;
	}
}



function normalize_path( $path = '', $ds = '/') {

	if( !isset($path[0]) || $path[0] !== $ds) {

		$result = explode($ds, getcwd());

	}else{

		$result = array('');

	}

	$parts = explode($ds, $path);

	foreach( $parts as $part ){

		if( $part == '' || $part == '.' ){

			continue;

		}

		if( $part == '..' ){

			array_pop($result);

		}else{

			$result[] = $part;

		}
	}

	$path = implode( $ds, $result );

	return $path;

}



/**
 * Метод проверяет наличие необходимых директорий,
 * и если они отсутствуют, тогда будут созданы.
 */
function check_dirs(){

	foreach( app::$config['dirs'] as $dir ){
		if( is_dir($dir) === false ){
			mkdir( $dir, 0755, true );
		}
	}

	foreach( app::$config['dirs'] as $dir ){
		if( is_dir($dir) === false ){
			// Не удаётся создать директорию приложения.
			throw new exception('Can not create application directory "' . $dir . '".');
		}
	}
}





function create_dir( $path, $mode = 0777, $recursive = true, $uid = null, $gid = null ){

	$result = false;

	if( is_dir( $path ) == false ){

		$result = mkdir( $path, $mode, $recursive );

	}

	if( $result == true ){

		$result = chmod( $path, $mode );

		if( $result == true ){

			if( $uid != null ){

				$result = chown( $path, $uid );

			}

			if( $gid != null ){

				$result = chgrp( $path, $gid );

			}

		}

	}

	return $result;


}






/**
 * Метод требует установленного расширения ffmpeg.
 * @link http://ffmpeg-php.sourceforge.net/
 * @link http://ffmpeg-php.sourceforge.net/doc/api/
 * @param str $file Абсолютный путь к файлу.
 * @return
 * 		arr $info Массив с данными о файле.
 * 		bool false В случае проблем.
 */
function get_ffmpeg_info( $file ){



	app::load_module('ffmpeg', 'site');

	$info = ffmpeg::get_info($file);

	return $info;

	$info = [];

	if( is_file($file) === false )
		return false;

	if( extension_loaded('ffmpeg') === false )
		return false;

	$movie = new ffmpeg_movie( $file );

	if( $movie === false )
		return false;

	// Return boolean value indicating whether the movie has a video stream.
	$info['has_video'] = $movie->hasVideo();

	// Return boolean value indicating whether the movie has an audio stream.
	$info['has_audio'] = $movie->hasAudio();

	// Return the duration of a movie or audio file in seconds.
	$info['duration'] = round( $movie->getDuration() );

	// Return the number of frames in a movie or audio file.
	$info['frame_count'] = $movie->getFrameCount();

	// Return the frame rate of a movie in fps.
	$info['frame_rate'] = $movie->getFrameRate();

	// Return the comment field from the movie or audio file.
	$info['comment'] = $movie->getComment();

	// Return the title field from the movie or audio file.
	$info['title'] = $movie->getTitle();

	// Return the author field from the movie or the artist ID3 field from an mp3 file.
	$info['author'] = $movie->getAuthor(); // alias $movie->getArtist()

	// Return the copyright field from the movie or audio file.
	$info['copyright'] = $movie->getCopyright();

	// Return the artist ID3 field from an mp3 file.
	$info['artist'] = $movie->getArtist();

	// Return the genre ID3 field from an mp3 file.
	$info['genre'] = $movie->getGenre();

	// Return the track ID3 field from an mp3 file.
	$info['track_number'] = $movie->getTrackNumber();

	// Return the year ID3 field from an mp3 file.
	$info['year'] = $movie->getYear();

	// Return the width of the movie in pixels.
	$info['frame_width'] = $movie->getFrameWidth();

	// Return the height of the movie in pixels.
	$info['frame_height'] = $movie->getFrameHeight();

	// Return the pixel format of the movie.
	$info['pixel_format'] = $movie->getPixelFormat();

	// Return the bit rate of the movie or audio file in bits per second.
	$info['bit_rate'] = $movie->getBitRate();

	// Return the bit rate of the video in bits per second.
	$info['video_bit_rate'] = $movie->getVideoBitRate();

	// NOTE: This only works for files with constant bit rate.

	// Return the audio bit rate of the media file in bits per second.
	$info['audio_bit_rate'] = $movie->getAudioBitRate();

	// Return the audio sample rate of the media file in bits per second.
	$info['audio_sample_rate'] = $movie->getAudioSampleRate();

	// Return the current frame index.
	$info['frame_number'] = $movie->getFrameNumber();

	// Return the name of the video codec used to encode this movie as a string.
	$info['video_codec'] = $movie->getVideoCodec();

	// Return the name of the audio codec used to encode this movie as a string.
	$info['audio_codec'] = $movie->getAudioCodec();

	// Return the number of audio channels in this movie as an integer.
	$info['audio_channels'] = $movie->getAudioChannels();

	unset($movie);

	return $info;

}


/**
 * Функция возвращает содержимое указанной директории.
 *
 * @params int $type
 * 		0 - файлы и директории
 * 		1 - файлы
 * 		2 - директории
 *
 * @todo Опциональное добавление полного пути.
 * @TODO Перейти на scandir().
 * @TODO $type сделать константу
 */
function get_dir($dir, $type = 0){
	$_['files'] = [];
	$_['dirs'] = [];
	// Пропустить ссылку. ! Зачем пропускать ссылку?
	if(!is_dir($dir) || is_link($dir) == true ){
		// TODO Ворнинг
		return $_;
	}
	$dir_handle = opendir($dir);
	// В начало директории.
	rewinddir($dir_handle);
	while(false!==($file = readdir($dir_handle))) {
		if($file!='.' and $file!='..'){
			if(is_dir($dir . '/' . $file)){ // Это файл
				array_push($_['dirs'],$file);
			}else if(is_file($dir . '/' . $file)){ // Это директория
				array_push($_['files'],$file);
			}
		}
	}
	closedir($dir_handle);

	if( $type == 0 ){
		return $_;
	}else if( $type == 1 ){
		return $_['files'];
	}else if( $type == 2 ){
		return $_['dirs'];
	}
}


/**
 * Метод удаляет файл или директорию со всем содержимым (рекурсивно).
 */
function delete($fs_item, $mode = 1){
	if( $mode == 1 ){
		if( is_dir( $fs_item ) == true ){
			exec('rm -rf ' . $fs_item);
		}else if( is_file( $fs_item ) == true ){
			exec('rm -f ' . $fs_item);
		}
	}else if( $mode == 2 ){

	}
}



/**
 * Метод отличается от стандартной функции rename, тем, что
 * создаёт не достающие каталоги.
 * Переименовывает / перемещает, директорию или каталог.
 */
function rename_file($source, $destination, $mode = 1){
	if( is_file( $source ) == true ){
		//$dir = dirname( $destination );
		//mkdir( $dir, 0777, true );
		//if( is_dir( $dir ) == true ){
		//exec('mv -f ' . $source . ' ' . $destination);
		//}
	}else if( is_dir( $source ) == true ){

	}


	exec('mv -f ' . $source . ' ' . $destination);
}


/**
 * Метод вычисляет размер файла или директории.
 */
function get_size($path){

	$size = 0;

	if( is_file( $path ) == true ){
		$size = filesize( $path );
	}else if( is_dir( $path ) == true ){
		$arr = get_dir_recursion( $path );

		foreach( $arr as $file ){

			$file = $path . '/' . $file;
			//	error_log( $file );

			if( is_file( $file ) == true ){
				$size = $size + @filesize( $file );
			}
		}
	}

	return $size;

}


/**
 * @param int $allowed_level разрешённая глубина. 0 - любая.
 */
// $regexp = '/\.(php|css|tpl|htaccess|js|png|jpg|gif)$/';
function get_dir_recursion( $path, $regexp = '', $allowed_level = 0 ){
	$list = [];

	_get_dir_recursion( $path, $list, $allowed_level );

	foreach( $list as $index => &$item ){
		$item = preg_replace('@^'.$path.'@', '', $item);
		if( $regexp != '' && preg_match( $regexp, $item ) === 0 )
			unset($list[$index]);
	}
	return $list;
}






// Рекурсивное чтение директорий.
function _get_dir_recursion( $path = '', &$list, $allowed_level = 0, $current_level = 1 ){

	if( $allowed_level > 0 && $allowed_level < $current_level )
		return;

	$arr = get_dir( $path );
	foreach( $arr['dirs'] as $dir ){
		$list[] = preg_replace('@//?@','/',$path . '/' . $dir);
		$current_level++;
		_get_dir_recursion( $path . '/' . $dir, $list, $allowed_level, $current_level );
	}
	foreach( $arr['files'] as $file ){
		$list[] = preg_replace('@//?@','/',$path . '/' . $file);;
	}
}


/**
 * Функция преобразует секунды в вид: "1 ч. 16 мин. 21 сек."
 * @param int $seconds
 * @return str
 */
function get_hours_str( $seconds, $without_seconds = false ){

	// для остатков
	$s = 0;
	$m = 0;
	// свободные секунды, которые не образуют целую минуту.
	$s = $seconds % 60;
	// минуты
	$minutes = ($seconds - $s) / 60;
	$seconds = $s;
	// часы
	if($minutes >= 60){
		$hours = 0;
		$m = $minutes % 60;
		$hours = ($minutes - $m) / 60;
		$minutes = $m;
	}

	$str = '';

	// TODO Вынести в класс.
	// array( short, one, two, many )
	$dictionary['en'] = array(
		'year' 		=> array('yr.','year','years','years'),
		'month' 	=> array('mo.','month','months','months'),
		'day' 		=> array('d.','day','days','days'),
		'hour' 		=> array('h.','hour','hours','hours'),
		'minute' 	=> array('min.','minute','minutes','minutes'),
		'second' 	=> array('sec.','second','seconds','seconds')
	);

	$dictionary['ru'] = array(
		'year' 		=> array('г.','год','года','лет'),
		'month' 	=> array('м.','месяц','месяца','месяцев'),
		'day' 		=> array('д.','день','дня','дней'),
		'hour' 		=> array('ч.','час','часа','часов'),
		'minute' 	=> array('мин.','минута','минуты','минут'),
		'second' 	=> array('сек.','секунда','секунды','секунд')
	);

	$language = app::$language;

	$arr_time = [];

	if( $hours > 0 ){
		$arr_time[] = $hours . ' ' . $dictionary[ $language ]['hour'][0];
	}

	if( $minutes > 0 ){
		$arr_time[] = $minutes . ' ' . $dictionary[ $language ]['minute'][0];
	}

	if( $s > 0 && $without_seconds == false ){
		$arr_time[] = $s . ' ' . $dictionary[ $language ]['second'][0];
	}

	$str = implode( ' ', $arr_time );

	return $str;

}




/**
 * Функция преобразует секунды в вид: "3 мин. 43 сек." или "1 ч. 16 мин. 21 сек."
 * @param int $seconds
 * @return str
 */
function get_time_str($seconds){


	// для остатков
	$s = 0;
	$m = 0;
	// свободные секунды, которые не образуют целую минуту.
	$s = $seconds % 60;
	// минуты
	$minutes = ($seconds - $s) / 60;
	$seconds = $s;
	// часы
	if($minutes >= 60){
		$hours = 0;
		$m = $minutes % 60;
		$hours = ($minutes - $m) / 60;
		$minutes = $m;
	}

	$str = '';

	// TODO Вынести в класс.
	// array( short, one, two, many )
	$dictionary['en'] = array(
		'year' 		=> array('yr.','year','years','years'),
		'month' 	=> array('mo.','month','months','months'),
		'day' 		=> array('d.','day','days','days'),
		'hour' 		=> array('h.','hour','hours','hours'),
		'minute' 	=> array('min.','minute','minutes','minutes'),
		'second' 	=> array('sec.','second','seconds','seconds')
	);

	$dictionary['ru'] = array(
		'year' 		=> array('г.','год','года','лет'),
		'month' 	=> array('м.','месяц','месяца','месяцев'),
		'day' 		=> array('д.','день','дня','дней'),
		'hour' 		=> array('ч.','час','часа','часов'),
		'minute' 	=> array('мин.','минута','минуты','минут'),
		'second' 	=> array('сек.','секунда','секунды','секунд')
	);

	$language = app::$language;



	if( $hours >= 24 ){
		$days = ($hours - ($hours % 24)) / 24;
		$hours = $hours % 24;

		$str = $days;
		$str.= ' ' . class_rus::word_ending(
				$days,
				$dictionary[ $language ]['day'][3],
				$dictionary[ $language ]['day'][1],
				$dictionary[ $language ]['day'][2]
			);

		if( $hours > 0 ){
			$str.= ' ' . $hours;
			$str.= ' ' . $dictionary[ $language ]['hour'][0];
		}

		if( $minutes > 0 ){
			$str.= ' ' . $minutes;
			$str.= ' ' . $dictionary[ $language ]['minute'][0];
		}

		if( $s > 0 ){
			$str.= ' ' . $s;
			$str.= ' ' . $dictionary[ $language ]['second'][0];
		}

	}
	else if( $hours > 0 && $hours < 24 ){ // до суток

		if( $hours > 0 ){

			$str = $hours;
			$str.= ' ' . $dictionary[ $language ]['hour'][0];

		}

		if( $minutes > 0 ){
			$str.= ' ' . $minutes;
			$str.= ' ' . $dictionary[ $language ]['minute'][0];
		}

		if( $s > 0 ){
			$str.= ' ' . $s;
			$str.= ' ' . $dictionary[ $language ]['second'][0];
		}

	}
	else {

		if( $minutes > 0 ){
			$str = $minutes;
			$str.= ' ' . $dictionary[ $language ]['minute'][0];
		}

		if( $s > 0 ){
			$str.= ' ' . $s;
			$str.= ' ' . $dictionary[ $language ]['second'][0];
		}
	}

	return $str;
}



/**
 * Метод преобразует секунды к виду
 *
 * HHH:MM:SS
 *
 * Используется, там, где необходимо показать сколько времени осталось.
 *
 * @todo Для миллисекунд.
 *
 */
function time_left( $seconds = 0 ){

	$hours = 0;
	$minutes = 0;

	$str = '';

	$seconds = intval( $seconds );

	if( $seconds >= TS_HOUR ){

		$r = $seconds % TS_HOUR;

		$hours = ( $seconds - $r ) / TS_HOUR;

		$seconds = $r;

	}

	if( $seconds >= TS_MINUTE ){

		$r  = $seconds % TS_MINUTE;

		$minutes = ( $seconds - $r ) / TS_MINUTE;

		$seconds = $r;

	}

	if( $hours < 100 && $hours > 9 ){

		$str = '0' . $hours;

	}
	else if( $hours < 10 ){

		$str = '00' . $hours;

	}
	else {

		$str = $hours;

	}

	$str.= ':';

	if( $minutes < 10 ){

		$str.= '0' . $minutes;

	}
	else {

		$str.= $minutes;

	}

	$str.= ':';

	if( $seconds < 10 ){

		$str.= '0' . $seconds;

	}
	else {

		$str.= $seconds;

	}


	return $str;

}


function get_format( $country_iso_code = 'RU', $format = 0 ){

	// Формат даты.
	// COUNTRY ISO CODE => array( DATE FORMAT, TIME FORMAT )
	$arr_formats = array(
		// Россия
		'RU' => array(
			// PHP date()
			0 => 'd.m.Y',
			1 => 'H:i:s',
			2 => 'd.m.Y H:i:s',
			3 => 'd.m.Y H:i',
			4 => 'H:i',
			// MySQL DATE_FORMAT()
			10 => '%d.%m.%Y',
			11 => '%H:%i:%s',
			12 => '%d.%m.%Y %H:%i:%s',
			13 => '%d.%m.%Y %H:%i',
			14 => '%H:%i',
			// Прочие
			20 => 'DD.MM.YYYY',
			21 => 'HH:MI:SS',
			22 => 'DD.MM.YYYY HH:MI:SS',
			23 => 'DD.MM.YYYY HH:MI',
			24 => 'HH:MI',
			// Регулярное выражение.
			30 => '@(\d\d)\.(\d\d)\.(\d\d\d\d)@',
			31 => '@(\d\d)\:(\d\d)\:(\d\d)@',
			32 => '@(\d\d)\.(\d\d)\.(\d\d\d\d) (\d\d)\:(\d\d)\:(\d\d)@',
			33 => '@(\d\d)\.(\d\d)\.(\d\d\d\d) (\d\d)\:(\d\d)@',
			34 => '@(\d\d)\:(\d\d)@'
		),
		// США
		'US' => array( 'MM-DD-YYYY', 'HH:MI:SS' ),
		// Великобритания
		'UK' => array( 'DD/MM/YYYY', 'HH:MI:SS' ),
		// Польша
		'PL' => array( 'YYYY-MM-DD', 'HH:MI:SS' ),
		// Финляндия
		'FI' => array( 'YYYY-MM-DD', 'HH.MI.SS' ),
		// Швейцария
		'CH' => array( 'DD.MM.YYYY', 'HH,MI,SS' ),
		// Дания
		'DK' => array( 'DD-MM-YYYY', 'HH.MI.SS' ),
		// Италия
		'IT' => array( 'DD/MM/YYYY', 'HH.MI.SS' ),
		// Нидерланды (Голландия)
		'NL' => array( 'DD-MM-YYYY', 'HH:MI:SS' ),
		// Сербия
		'RS' => array( 'DD.MM.YYYY', 'HH.MI.SS' )
	);

	if( isset( $arr_formats[ $country_iso_code ][ $format ] ) == true ){

		return $arr_formats[ $country_iso_code ][ $format ];

	}
	else{

		return $arr_formats[ 'RU' ][ 0 ];

	}
}


/**
 * Возвращает timestamp с учётом временного смещения.
 */
function get_ts( $base_ts = null, $timezone = null ){


	$timezone_offset = array(
		1 => -720,
		2 => -660,
		3 => -600,
		4 => -570,
		5 => -540,
		6 => -480,
		7 => -420,
		8 => -360, // -6
		9 => -300, // -5
		10 => -270,
		11 => -240,
		12 => -210,
		13 => -180,
		14 => -120,
		15 => -60,
		16 => 0,
		17 => 60,
		18 => 120,
		19 => 240,
		20 => 210,
		21 => 240,
		22 => 270,
		23 => 360,
		24 => 330,
		25 => 345,
		26 => 360,
		27 => 390,
		28 => 420,
		29 => 480,
		30 => 525,
		31 => 540,
		32 => 570,
		33 => 600,
		34 => 630,
		35 => 660,
		36 => 690,
		37 => 720,
		38 => 765,
		39 => 780,
		40 => 840,
		41 => 180
	);


	if( $base_ts == null ){
		$base_ts = time();
	}

	if( $timezone != null ){

		$offset = $timezone_offset[ $timezone ];
		$offset = $offset * 60;

	}else{

		$offset = $timezone_offset[ app::$config['timezone'] ];
		$offset = $offset * 60;

	}

	$timestamp = $base_ts + $offset;

	return $timestamp;

}


/**
 * Метод возвращает дату и время в формате текущей страны (языка)
 * и с учётом текущего часового пояса пользователя.
 */
function _date( $format = '', $timestamp = null, $timezone = null ){
	/*
			if( $timestamp == null ){
				$timestamp = time();
			}

	//		$offset = 0;

		//	if( app::$user->id > 0 ){
		//		$offset = $timezone_offset[ app::$user->get_option('timezone') ];
		//		$offset = $offset * 60;
		//	}else{


			if( $timezone != null ){

				$offset = $timezone_offset[ $timezone ];
				$offset = $offset * 60;

			}else{

				$offset = $timezone_offset[ app::$config['timezone'] ];
				$offset = $offset * 60;

			}


		//	}



			$timestamp = $timestamp + $offset;

			*/

	if( $timestamp == null ){
		$timestamp = time();
	}

	//		$timestamp = self::get_ts( $timestamp, $timezone );
	//		return gmdate( $format, $timestamp );

	return date($format,$timestamp);

}


function get_timezones2(){

	// http://ru.wikipedia.org/wiki/Часовой_пояс
	// Взять список.
	/**
	 * Функции для работы с датой и временем.
	 *
	 * Список часовых поясов:
	 *
	 * @link http://www.iana.org/time-zones
	 * @link https://timezonedb.com/download
	 *
	 *
	 */
	$timezones2 = array(
		1 => '(UTC -12:00) Международная Западная Линия перемены даты',
		2 => '(UTC -11:00) Остров Мидувей, Самоа',
		3 => '(UTC -10:00) Гавайи',
		4 => '(UTC -09:30) Тэйоха, Маркизские острова',
		5 => '(UTC -09:00) Аляска',
		6 => '(UTC -08:00) Тихоокеанское время (США и Канада)',
		7 => '(UTC -07:00) Горное время (США и Канада)',
		8 => '(UTC -06:00) Центральное время (США и Канада), Мехико',
		9 => '(UTC -05:00) Восточное время (США и Канада), Богота, Лима',
		10 => '(UTC -04:30) Венесуэла',
		11 => '(UTC -04:00) Атлантическое время (Канада), Каракас, Ла-Пас',
		12 => '(UTC -03:30) Св. Джонс, Ньюфаундленд и Лабрадор',
		13 => '(UTC -03:00) Бразилия, Буэнос-Айрес, Джорджтаун',
		14 => '(UTC -02:00) Центральная Атлантика',
		15 => '(UTC -01:00) Азорские острова, Острова Зеленого Мыса',
		16 => '(UTC 00:00) Западно-Европейское время, Лондон, Лиссабон, Касабланка',
		17 => '(UTC +01:00) Амстердам, Берлин, Брюссель, Копенгаген, Мадрид, Париж',
		18 => '(UTC +02:00) Киев, Стамбул, Иерусалим, Калининград, Южная Африка',
		19 => '(UTC +04:00) Багдад, Эр-Рияд, Москва, Санкт-Петербург',
		20 => '(UTC +03:30) Тегеран',
		21 => '(UTC +04:00) Абу-Даби, Мускат, Баку, Тбилиси',
		22 => '(UTC +04:30) Кабул',
		23 => '(UTC +06:00) Екатеринбург, Исламабад, Карачи, Ташкент',
		24 => '(UTC +05:30) Бомбей, Калькутта, Мадрас, Нью-Дели, Коломбо',
		25 => '(UTC +05:45) Катманду',
		26 => '(UTC +06:00) Алма-Ата, Дхака, Коломбо',
		27 => '(UTC +06:30) Ягун',
		28 => '(UTC +07:00) Бангкок, Ханой, Джакарта, Новокузнецк',
		29 => '(UTC +08:00) Пекин, Перт, Сингапур, Гонконг',
		30 => '(UTC +08:00) Улан-Батор, Западная Австралия',
		31 => '(UTC +09:00) Токио, Сеул, Осака, Саппоро, Якутск',
		32 => '(UTC +09:30) Аделаида, Дарвин, Якутск',
		33 => '(UTC +10:00) Восточная Австралия, Гуам, Владивосток',
		34 => '(UTC +10:30) Остров Впадины Бога (Австралия)',
		35 => '(UTC +11:00) Магадан, Соломоновы острова, Новая Каледония',
		36 => '(UTC +11:30) Остров Норфолк',
		37 => '(UTC +12:00) Окленд, Веллингтон, Фиджи, Камчатка',
		38 => '(UTC +12:45) Остров Чатем',
		39 => '(UTC +13:00) Тонга',
		40 => '(UTC +14:00) Кирибати',
		41 => '(UTC +03:00) Минск'

	);


	return $timezones2;


}

function get_timezones(){






	/**
	 * Часовые пояса.
	 * @link http://en.wikipedia.org/wiki/List_of_time_zones_by_country
	 */
	$timezones = array(
		'ru' => array(
			'-660' => '(UTC -11:00) Самоа',
			'-600' => '(UTC -10:00) Гавайи',
			'-570' => '(UTC -9:30) Французская Полинезия',
			'-540' => '(UTC -9:00) Аляска',
			'-480' => '(UTC -8:00) Лос-Анджелес',
			'-420' => '(UTC -7:00) Денвер',
			'-360' => '(UTC -6:00) Чикаго',
			'-300' => '(UTC -5:00) Нью-Йорк',
			'-240' => '(UTC -4:00) Каракас',
			'-210' => '(UTC -3:30) Ньюфаундленд',
			'-180' => '(UTC -3:00) Буэнос-Айрес',
			'0' => '(Greenwich) Лондон',
			'60' => '(UTC +1:00) Берлин, Париж',
			'120' => '(UTC +2:00) Киев, Минск, Калининград',
			'180' => '(UTC +3:00) Москва, Санкт-Петербург',
			'240' => '(UTC +4:00) Ереван',
			'270' => '(UTC +4:30) Кабул',
			'300' => '(UTC +5:00) Екатеринбург, Ташкент',
			'330' => '(UTC +5:30) Дели, Коломбо',
			'345' => '(UTC +5:45) Катманду',
			'360' => '(UTC +6:00) Новосибирск, Алматы',
			'390' => '(UTC +6:30) Янгон',
			'420' => '(UTC +7:00) Красноярск, Бангкок',
			'480' => '(UTC +8:00) Иркутск, Пекин',
			'525' => '(UTC +8:45) Кейгуна, Юкла',
			'540' => '(UTC +9:00) Якутск, Токио',
			'570' => '(UTC +9:30) Аделаида, Дарвин',
			'600' => '(UTC +10:00) Владивосток, Сидней',
			'660' => '(UTC +11:00) Магадан',
			'690' => '(UTC +11:30) Норфолк',
			'720' => '(UTC +12:00) Камчатка',
			'765' => '(UTC +12:45) Чатем',
			'780' => '(UTC +13:00) Тонга',
			'840' => '(UTC +14:00) Острова Лайн'
		),
		'en' => array(
		)
	);


	/**
	 * Часовые пояса в формате PHP.
	 */
	$timezones_php = array(
		'-660' => 'Pacific/Samoa',
		'-600' => 'US/Hawaii',
		'-570' => 'Pacific/Marquesas',
		'-540' => 'US/Alaska',
		'-480' => 'America/Los_Angeles',
		'-420' => 'America/Denver',
		'-360' => 'America/Chicago',
		'-300' => 'America/New_York',
		'-240' => 'America/Caracas',
		'-210' => 'Canada/Newfoundland',
		'-180' => 'America/Buenos_Aires',
		'0' => 'Europe/London',
		'60' => 'Europe/Berlin',
		'120' => 'Europe/Kiev',
		'180' => 'Europe/Moscow',
		'240' => 'Asia/Yerevan',
		'270' => 'Asia/Kabul',
		'300' => 'Asia/Yekaterinburg',
		'330' => 'Asia/Colombo',
		'345' => '(GMT +5:45) Катманду',
		'360' => 'Asia/Novosibirsk',
		'390' => '(GMT +6:30) Янгон',
		'420' => 'Asia/Krasnoyarsk',
		'480' => 'Asia/Singapore',
		'525' => 'Australia/Eucla',
		'540' => 'Asia/Tokyo',
		'570' => 'Australia/Adelaide',
		'600' => 'Asia/Vladivostok',
		'660' => 'Australia/Sydney',
		'690' => 'Pacific/Norfolk',
		'720' => 'Asia/Kamchatka',
		'765' => 'Pacific/Chatham',
		'780' => 'Pacific/Tongatapu',
		'840' => '(GMT +14:00) Острова Лайн'
	);


}




/**
 * Метод сортирует массив по значению ключа из элемента, который тоже является массивом.
 *
 * @param array $array
 * @param int $key_in_item Ключ в элементе с весом, по которому будет происходит сортировка.
 * @param string $direction
 * @return array
 */
function _sort( $array = [], $direction = 'asc', $key_in_item = null ){

	if( $key_in_item == null ){

		return $array;

	}

	$direction = mb_strtolower( $direction );

	if( is_array( $array ) == false ){

		$array = [];

	}

	uasort( $array, function( $item1, $item2 ) use ( $direction, $key_in_item ) {

		if( $direction == 'asc' ){

			if ( $item1[ $key_in_item ] == $item2[ $key_in_item ] ) {

				$result = 0;

			}

			if( $item1[ $key_in_item ] < $item2[ $key_in_item ] ){

				$result = -1;

			}

			if( $item1[ $key_in_item ] > $item2[ $key_in_item ] ){

				$result = 1;

			}

		}
		else if( $direction == 'desc' ){

			if ( $item1[ $key_in_item ] == $item2[ $key_in_item ] ) {
				$result = 0;
			}

			if( $item1[ $key_in_item ] < $item2[ $key_in_item ] ){
				$result = 1;
			}

			if( $item1[ $key_in_item ] > $item2[ $key_in_item ] ){
				$result = -1;
			}

		}

		return $result;


	});


	return $array;

}


/**
 * @param array $files массив в формате $_FILES.
 */
function normalize_files( $files ){

	$arr_files = [];

	foreach( $files as $key => $file ){

		if( is_array( $file['name'] ) == true ){

			foreach( $file as $name => $arr ){

				foreach( $arr as $i => $value ){

					$arr_files[ $key ][ $i ][ $name ] = $value;

				}

			}

		}
		else {

			$arr_files[ $key ][0] = $file;

		}

	}

	return $arr_files;

}


// TODO
function prepare_sql(){

}


function get_phone( $name ){

	$value = '';

	if( array_key_exists( $name, $_REQUEST ) == true ){

		$value = (string) $_REQUEST[ $name ];

	}

	$phone = sanitize_phone( $value );


	return $phone;

}


function sanitize_phone( $phone ){

	$phone = preg_replace( '/[^\d]/', '', $phone );

	$full_phone = null;

	$matches = [];

	$phone = ltrim( $phone, '0' );

	if( preg_match( '/^(\d)(\d{10})$/', $phone, $matches ) == true ){

		$phone = $matches[2];
		$country_code = $matches[1];

		if( $country_code == '' ){

			$country_code = '7';

		}

		if( $country_code == '8' ){

			$country_code = '7';

		}

		$country_code = '+' . $country_code;

		$full_phone = $country_code . $phone;

	}
	else if( preg_match( '/^(\d{9,})$/', $phone, $matches ) == true ){

		$full_phone = '+' . $phone;

	}

	return $full_phone;

}


function is_phone( $phone ){

	$phone = sanitize_phone( $phone );

	if( $phone !== null ){

		return true;

	}
	else {

		return false;

	}

}


/**
 * @param $name
 * @return null | array
 */
function get_json( $name ){

	$str = get_str( $name );

	$arr = json_decode( $str, true );

	return $arr;

}


function get_sms_template( $sms_template_id ){

	$sql = 'SELECT * FROM sms_template WHERE id = ?d OR str_id = ?';

	$sms_template = app::$db->get_record( $sql, $sms_template_id, $sms_template_id );

	$sms_template['recipients'] = unserialize( $sms_template['recipients'] );

	return $sms_template;

}


/**
 * Функция отправляет SMS одному получателю.
 *
 * @param $phone
 * @param $message
 * @param null $provider_id
 * @param int $template_id Тип сообщения (код шаблона).
 *
 * @return bool
 * @throws exception
 */
function send_sms( $phone, $message = null, $provider_id = null, $template_id = null, $params = [] ){

	if( $provider_id == null ){

		$provider_id = app::$config['sms_provider'];

	}

	if( is_array( $params ) == false ){

		$params = [];

	}

	if( $template_id !== null ){

		$sms_template = get_sms_template( $template_id );


		if( $sms_template != null ){

			if( $sms_template['active'] == true ) {

				$arr = [];

				foreach( $params as $key => $value ){

					$arr[ '{' . $key . '}' ] = $value;

				}

				$message = strtr( $sms_template['message'], $arr );

			}
			else {

				return false;

			}

		}
		else {

			return false;

		}

	}




	$sql = 'SELECT * FROM sms_provider WHERE id = ?d OR str_id = ?';

	$provider = app::$db->get_record( $sql, $provider_id, $provider_id );

	$result = false;

	$debug = false;

	// Fix debug mode
	if( $_SERVER['SERVER_ADDR'] == '192.168.1.240' ){

		$debug = true;

	}



	if( $provider != null && $message != null ){

		$provider['data'] = unserialize( $provider['data'] );

		$response = [];

		if( $provider['str_id'] == 'plivo.com' ){

			$url = 'https://api.plivo.com/v1/Account/' . $provider['data']['auth_id'] . '/Message/';

			$post_data = [
				'src' => 'site.ru',
				'dst' => $phone,
				'text' => $message
			];

			$params['headers'][] =

			$post_data = json_encode( $post_data );

			$params = [
				'userpwd' => $provider['data']['auth_id'] . ':' . $provider['data']['auth_token'],
				'headers' => [
					'Content-Type: application/json'
				]
			];

			if( $debug == false ) {

				$response = http_post($url, $post_data, $params);

			}

			// TODO учитывать
			//$response['http_code']

		}
		else if( $provider['str_id'] == 'smsc.ru' ){



		}

		$sql = 'INSERT INTO sms SET ?l';

		$ins_data = [];
		$ins_data['create_ts'] = time();
		$ins_data['message'] = $message;
		$ins_data['phone'] = $phone;
		$ins_data['user_id'] = app::$user->id;
		$ins_data['template_id'] = $template_id;
		$ins_data['provider_id'] = $provider_id;
		$ins_data['cost'] = 0;
		$ins_data['provider_response'] = $response['content'];

		app::$db->insert( $sql, $ins_data );

		$result = true;

	}


	return $result;



}


/**
 * Функция возвращает время в пути и расстояние между двумя точек.
 *
 * Описание
 *
 * @link https://developers.google.com/maps/documentation/directions/intro?hl=ru
 *
 * Лимиты
 *
 * @link https://developers.google.com/maps/documentation/directions/usage-limits?hl=ru
 *
 * Получение ключа
 *
 * @link https://developers.google.com/maps/documentation/directions/get-api-key?hl=ru
 *
 * Кабинет ключей
 *
 * @link https://console.developers.google.com/apis/credentials
 *
 * Разделителем дробной части в широте и долготе, должна быть точка.
 *
 * @param $origin Начальная точка. Адрес или координаты в формате "широта,долгота".
 * @param $destination Конечная точка. Адрес или координаты в формате "широта,долгота".
 */
function google_map_route( $origin, $destination ){

	error_log('google_map_route');

	$data = [
		// В метрах.
		'distance' => 0,
		// В секундах.
		'duration' => 0,
	];


	$params = [];
	$params['origin'] = $origin;
	$params['destination'] = $destination;
	$params['key'] = 'AIzaSyAePP6TqLtOw1xMd555CCrFoE2FwHk3tA4';

	$url = 'https://maps.googleapis.com/maps/api/directions/json?' . http_build_query( $params );

	$response = http_get( $url );

	$response = json_decode( $response['content'], true );

	if( $response['status'] == 'OK' ){

		// Маршруты.
		foreach( $response['routes'] as $route ){

			// Участки маршрута.
			foreach( $route['legs'] as $leg ){

				// В секундах.
				$data['duration'] += $leg['duration']['value'];

				// В метрах.
				$data['distance'] += $leg['distance']['value'];

			}

		}

	}


	$data['distance'] = intval( $data['distance'] );
	$data['duration'] = intval( $data['duration'] );


	return $data;

}


function get_url_path(){

	$parsed_url = parse_url( $_SERVER['REQUEST_URI'] );

	if( $parsed_url === false ){

		$parsed_url['path'] = '/';

	}

	if( array_key_exists( 'path', $parsed_url ) == false ){

		$parsed_url['path'] = '/';

	}

	return $parsed_url['path'];


}


/**
 * Функция возвращает размер удалённого/внешнего файла.
 *
 * TODO Тестировать HTTP-авторизацию.
 *
 * @param $url
 * @param null $http_user
 * @param null $http_password
 * @return int
 */
function get_remote_file_size( $url, $http_user = null, $http_password = null, &$http_code = 0, &$headers = [], &$has_content_length = false ){

	$file_size = 0;

	$ch = curl_init( $url );

	curl_setopt( $ch, CURLOPT_HEADER, true );

	// Опция действительно отключает скачивание файла, получает только заголовки.
	// Протестировано с помощью memory_get_usage().
	curl_setopt( $ch, CURLOPT_NOBODY, true );

	curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	if( $http_user != null && $http_password != null ){

		$http_user = '';
		$http_password = '';

		curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt( $ch, CURLOPT_USERPWD, $http_user . ':' . $http_password );

	}

	$content = curl_exec( $ch );

	$http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );

	curl_close( $ch );

	$headers = explode( "\n", $content );

	foreach( $headers as $i => $header ){

		$headers[ $i ] = trim( $header );

	}


	if( $http_code == 200 ){

		foreach( $headers as $header ){

			$matches = [];

			if( preg_match( '/^Content-Length: (\d+)/i', $header, $matches ) == true ){

				$file_size = intval( $matches[1] );

				$has_content_length = true;

				break;

			}

		}


	}

	return $file_size;

}


function get_max_upload_size(){

	$post_max_size = php_size_to_bytes( ini_get('post_max_size') );
	$upload_max_filesize = php_size_to_bytes( ini_get('upload_max_filesize') );

	$min_size = min( $post_max_size, $upload_max_filesize );

	return $min_size;

}


function php_size_to_bytes( $str ){

	$matches = [];

	$size = 0;

	$kilobyte = 1024;
	$megabyte = 1048576;
	$gigabyte = 1073741824;
	$terabyte = 1099511627776;
	$petabyte = 1125899906842624;

	if( preg_match( '/(\d+)(k|m|g|t|p)?/i', $str, $matches ) == true ){

		$size = intval( $matches[1] );

		if( array_key_exists( 2, $matches ) == true ){

			$unit_name = strtolower( $matches[2] );

			switch( $unit_name ){

				case 'k':

					$size *= $kilobyte;

					break;

				case 'm':

					$size *= $megabyte;

					break;

				case 'g':

					$size *= $gigabyte;

					break;

				case 't':

					$size *= $terabyte;

					break;

				case 'p':

					$size *= $petabyte;

					break;

			}

		}

	}


	return $size;

}


/**
 * Данная функция устраняет проблему с кэшированием размера файла на уровне файловой системы.
 *
 * @param $file
 * @return int
 */
function get_filesize( $file ){

	clearstatcache();

	return filesize( $file );

}


?>