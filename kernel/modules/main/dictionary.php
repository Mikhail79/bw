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

class Dictionary {

	protected $list = [];

	public function __construct( $dictionary_name, $language = null, $dictionary_base_dir = null ){

		if( $language == null ){

			$language = app::$language;

		}

		$dictionary_name = (string) $dictionary_name;

		if( $dictionary_base_dir == null ){

			$dictionary_base_dir = app::$config['dirs']['dictionaries'];

		}

		$file = $dictionary_base_dir . '/' . $language . '/' . ltrim( $dictionary_name, '/' );

		if( preg_match( '/\.php$/i', $file ) == false ){

			$file.= '.php';

		}

		$list = [];

		require( $file );

		if( is_array( $list ) == true ){

			foreach( $list as $key => $item ){

				$this->list[ mb_strtolower( $key ) ] = $item;

			}

		}



	}

	public function translate( $text, $params = [] ){

		$text = mb_strtolower( $text );

		$translated_text = '';

		if( array_key_exists( $text, $this->list ) == true ){

			$translated_text = $this->list[ $text ];

		}

		return $translated_text;

	}

}

?>