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

class FieldTags extends Field {

	public $type = 'tags';

	public function __construct( $form = null, $properties = []){

		parent::__construct( $form, $properties );

		$this->inner_data['list'] = [];

		// Список полученных тегов. Массив содержит только id.
		$this->inner_data['tags'] = [];

	}

	public function handle(){

		parent::handle();

		if( $this->error == true ){

			return !$this->error;

		}



		$ext_tags = $this->value;

		$ext_tags = explode( ',', $ext_tags );

		$tags = [];

		$hash_list = [];

		if( is_array( $ext_tags ) == true ) {

			foreach ( $ext_tags as $i => $tag ) {

				// Удалить символы с 0-31.
				$tag = preg_replace( '/[\x00-\x1F]/usim', ' ', $tag );

				$tag = preg_replace( '/(\x20)+/usim', ' ', $tag );

				$tag = trim( $tag );

				if( $tag != '' ){

					$hash = md5( mb_strtolower( $tag ) );

					$tags[] = [
						'id' => 0,
						'hash' => $hash,
						'name' => $tag
					];

					$hash_list[ $hash ] = $hash;

				}

			}

		}






		if( count( $tags ) > 0 ){

			$sql = 'SELECT * FROM tag WHERE hash IN (?a)';

			app::$db->field_as_key = 'hash';

			$db_tags = app::$db->sel( $sql, $hash_list );

			if( $db_tags == null ){

				$db_tags = [];

			}


			//$sql = 'INSERT INTO tag SET (hash,name) VALUES';

			//$sql_values = [];

			foreach( $tags as $i => $tag ){

				if( array_key_exists( $tag['hash'], $db_tags ) == true ){

					$tag['id'] = $db_tags[ $tag['hash'] ]['id'];

				}


				// TODO убрать отсюда вставку тегов.
				if( $tag['id'] == 0 ){

					$sql = 'INSERT INTO tag SET ?l';

					$ins_data = [];
					$ins_data['hash'] = $tag['hash'];
					$ins_data['name'] = $tag['name'];

					$tag['id'] = app::$db->ins( $sql, $ins_data );

					//$sql_values[] = app::$db->prepare_sql( '(?,?)', $tag['hash'], $tag['name'] );

				}

				$tags[ $i ] = $tag;

			}


			foreach( $tags as $tag ){

				if( $tag['id'] > 0 ){

					$this->tags[ $tag['id'] ] = $tag['id'];

				}

			}



		}



	}

	public function get_html(){

		if( $this->id == '' ){

			$this->id = randstr( 6 );

		}



		$html = '<div class="tags"><input type="text" name="' . $this->name . '" id="' . $this->id . '" /></div>';

		$js = '';

		$js.= '$("#' . $this->id . '").tokenInput(';
		$js.= '"", {';
		$js.= 'theme: "facebook",';
		$js.= 'tokenValue: "name",';
		$js.= 'allowFreeTagging: true,';
		$js.= 'prePopulate: ' . json_encode( $this->list ) ;
		$js.= '}';
		$js.= ');';

		if( app::$page != null ){

			app::$page->add_javascript( $js, 'default' );

		}
		else {

			$html.= '<script>';
			$html.= $js;
			$html.= '</script>';

		}



		return $html;

	}

}


?>