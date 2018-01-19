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

class ImageHandler {

	static public $arr_extensions = [
		1 => 'JPG',
		2 => 'PNG',
		3 => 'GIF',
		4 => 'BMP'
	];

	// TODO __get
	protected $data = [];

	public function __construct( $ih_id ){

		$sql = 'SELECT * FROM image_handler WHERE id = ?d';
		$row = app::$db->selrow( $sql, $ih_id );

		if( $row == null ){
			throw new Exception('Image handler not exists.');
		}

		$extension = mb_strtolower( self::$arr_extensions[ $row['save_type'] ] );
		$mime = ext2mime( $extension );

		$row['extension'] = $extension;
		$row['mime'] = $mime;

		$this->data = $row;

	}


	public function get_data(){
		return $this->data;
	}

	public function handle( $source_image, $destination_image = null, $name = null, $save_path = null ){

		$ih = $this->data;

		$extension = mb_strtolower( self::$arr_extensions[ $ih['save_type'] ] );
		$mime = ext2mime( $extension );

		if( $mime == 'image/bmp' ){
			$mime = 'image/vnd.wap.wbmp';
		}


		if( $save_path != null ){
			$ih['save_path'] = $save_path;
		}


		if( is_dir( $ih['save_path'] ) == false ){
			mkdir( $ih['save_path'], 0777, true );
		}

		if( $destination_image == null ){
			$destination_image = $ih['save_path'] . '/' . $name .  '.' . $extension;

			error_log($destination_image);

		}

		$image = new Image();
		$image->open( $source_image );

		$image->resize( $ih['width'], $ih['height'], (boolean) $ih['crop'] );

		if( $ih['watermark'] == true ){
			$image->set_watermark( $ih['watermark_path'] );
		}

		// TODO quality
		$ih['quality'] = 80;

		$image->save( $destination_image, $mime, $ih['quality'] );

		if( is_file( $destination_image ) == true ){
			return true;
		}
		else {
			return false;
		}
	}

}

?>