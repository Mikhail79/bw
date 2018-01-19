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
 * Метод для отправки писем. Позволяет отправлять письма с вложением.
 * 
 * Поле $this->to, может содержать один или несколько адресов.
 * 
 * user@example.com
 * user@example.com, anotheruser@example.com
 * User <user@example.com>
 * User <user@example.com>, Another User <anotheruser@example.com>
 * 
 * Пример:
 * 
 * $mail = new Mail();
 * $mail->from = 'user@site.ru';
 * $mail->to = 'John Doe <john.doe@site.com>';
 * $mail->subject = 'Тема письма';
 * $mail->add_attachment('Прикреплённый файлик.','descr.txt');
 * $mail->body = '<html><body><p>Привет Мир!</p></body></html>';
 * $mail->send();
 * 
 */
class Mail {
	
	/**
	 * Массив для хранения частей письма (файлы и прочие вложения).
	 */
	protected $parts = [];
	
	public $to = '';
	public $from = '';
	public $subject = '';
	public $body = '';
	
	protected $charset = 'utf-8';
	
	
	/**
	 * Для кодирования символов в полях: To, From, Subject.
	 */
	protected function field_encode($content){
		return '=?' . $this->charset . '?B?' . base64_encode($content) . '?=';
	}
	
	
	/**
	 * Добавить вложение.
	 */ 
	public function add_attachment($content, $name = '', $content_type = 'application/octet-stream', $encode = '') {
		$this->parts[] = array(
			'content' => $content,
			'name' => $name,
			'content_type' => $content_type,
			'encode' => $encode
		);
	}

	
	/**
	 * Метод для сборки письма из частей $this->parts.
	 */
	protected function build_multipart( $boundary ) {


		$multipart = '';
		$multipart.= '--' . $boundary;
		
		foreach( $this->parts as $part ){
			$multipart.= PHP_EOL;
			$multipart.= 'Content-Type: ' . $part['content_type'];
			$multipart.= ( $part['encode'] != '' ? '; charset=' . $part['encode'] : '' );
			$multipart.= ( $part['name'] != '' ? '; name = "' . $part['name'] . '"' : '' );
		 	$multipart.= PHP_EOL . 'Content-Transfer-Encoding: base64' . PHP_EOL . PHP_EOL;
		 	$multipart.= chunk_split( base64_encode( $part['content'] ) ) . PHP_EOL;
			$multipart.= '--' . $boundary;
		}
		
		$multipart.= "--" . PHP_EOL;
			
		return $multipart;
	}


	/**
	 * 
	 */
	protected function parser($list){
		$list = @explode(',', $list);
		
		$groups = [];

		if( is_array( $list ) == true ) {
			foreach( $list as $group ) {
				$matches = [];
				if( preg_match( '/(.*?)\<(.*?)\>/', $group, $matches ) ) {
					$name = trim( $matches[1] );
					$name = $this->field_encode( $name );
					$email = $matches[2];
					$groups[] = $name . ' <' . $email . '>';
				} else {
					$groups[] = $group;
				}
			}
		}
		return implode( ', ', $groups );
		
	}


	public function get_boundary( $length = 40 ){

		$chars = 'abcdefghijklmnoprstuvxyzABCDEFGHIJKLMNOPRSTUVXYZ0123456789';

		mt_srand();

		$str = '';

		for( $c = 0; $c < $length; $c++ ) {
			$str.= $chars[ mt_rand( 0, mb_strlen( $chars ) - 1 ) ];
		}

		return $str;

	}


	/**
	 * Отправка сообщения.
	 *
	 *
	$headers = [];

	$url = app::$url . '/unsubscribe/?token=123';

	$headers[] = 'List-Unsubscribe: <' . $url . '>';
	// https://support.google.com/mail/answer/81126?hl=ru#format
	$headers[] = 'Precedence: bulk';
	
	$params - mail params "-fadmin@site.ru"

	 */ 
	public function send( $arr_headers = [], $params = '' ){

		$from = $this->parser( $this->from );
		$to = $this->parser( $this->to );
		$subject = $this->field_encode( $this->subject );


		$boundary = $this->get_boundary();

		$arr_headers[] = 'MIME-Version: 1.0';
		$arr_headers[] = 'From: ' . $from;
		$arr_headers[] = 'Content-Type: multipart/mixed; boundary = ' . $boundary;

		$headers = implode( PHP_EOL, $arr_headers ) . PHP_EOL . PHP_EOL;

		// TODO Возможно стоит сделать hook для отправки onsend.

		// $this->body = preg_replace('@\{\$signature\}@is', dict::$dictionary['mail_signature'], $this->body);

  		// Тело.
		   
		if( $this->body != '' ){

			// fix

			if( preg_match( '/<body[^>]*>/i', $this->body ) == false ){
				$this->body = '<body>' . $this->body . '</body>';
			}


			if( preg_match( '/<html[^>]*>/i', $this->body ) == false ){
				$this->body = '<html>' . $this->body . '</html>';
			}



			$this->add_attachment( $this->body, '', 'text/html', $this->charset );

		}
		
	 	$content = $this->build_multipart( $boundary );

		/*
		if( DEV_IP == $_SERVER['SERVER_ADDR'] ){
	//	if( $_SERVER['REMOTE_ADDR'] == DEV_IP ){
			// write_file( app::$config['dirs']['tmp'] . '/mail.eml', $content );
			$name = app::$config['dirs']['tmp'] . '/body_' . randstr(10) . '_' . time() . '.html';
			write_file( $name, $this->body );
		}
		*/


		//
		// BEGIN Переделать
		//

		//echo $this->from;

		/*
		$params = '';

		if( preg_match( '/<([^>]+)>/', $this->from, $matches ) == true ){

			//print_r($matches);
			$params = '-f' . $matches[1];
		}
		*/



		if( app::$config['use_phpmailer'] === true || app::$config['mail_engine'] == 'phpmailer' ){

			require_once( app::$kernel_dir . '/other/PHPMailer/PHPMailerAutoload.php' );
			require_once( app::$kernel_dir . '/other/PHPMailer/class.phpmailer.php' );


			// http://www.web-development-blog.com/archives/send-e-mail-messages-via-smtp-with-phpmailer-and-gmail/
			$mail = new PHPMailer(true);

			$mail->IsSMTP();

			try {

				app::cons(app::$config['phpmailer']);


				ini_set('verify_peer', 0);
				ini_set('verify_peer_name', 0);


				$mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
				$mail->SMTPAuth = true;  // authentication enabled
				$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
				$mail->Host = app::$config['phpmailer']['host'];
				$mail->Port = app::$config['phpmailer']['port'];
				$mail->Username = app::$config['phpmailer']['user'];
				$mail->Password = app::$config['phpmailer']['password'];
				$mail->SetFrom( app::$config['phpmailer']['user'], '' );
				$mail->Subject = $subject;
				$mail->Body = $this->body;
				$mail->IsHTML(true);
				$mail->CharSet='UTF-8';

		//	print_r(app::$config['phpmailer']);

			//	$mail->IsSMTP(); // enable SMTP

				$name = '';

				if( is_array( $this->to ) == true ){
					$to = $this->to[0];
					$name = $this->to[1];
				}

				$mail->AddAddress( $to, $name );
				if(!$mail->Send()) {
					$error = 'Mail error: '.$mail->ErrorInfo;

				}
				else {
					$error = 'Message sent!';

				}




				error_log($error);


			}
			catch (phpmailerException $e) {
				error_log( $e->errorMessage() );
			}
			catch (Exception $e) {
				error_log( $e->getMessage() );
			}


		}
		else {

			return mail( $to, $subject, $content, $headers, $params );

		}


	}

}

?>