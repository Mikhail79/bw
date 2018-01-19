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


/**********************************************************************************************
 *
 *		Манипулятор картинок.
 *
 **********************************************************************************************/
// ih - image handler
// Текущий функционал
// - Показать исходное изображение из хранилища.
// - Уменьшить/увеличить изображение пропорционально (один параметр: width или height).
// - Уменьшить/увеличить изображение по заданным размерам (два параметра: width или height).
// - Уменьшить/увеличить изображение по заданным размерам (два параметра: width и height).
// - Уменьшить/увеличить изображение с кадрированием по центру по заданным размерам (два параметра: width и height).
// - Фильтры
// TODO Сохранение прозрачности при изменении размера.
class class_image_handler {

	protected $config = [];

	// Данные о картинке.
	public $image = null;

	// Фильтр обработки.
	public $filter = null;

	public $width = 0;
	public $height = 0;



	/**
	 * Метод возвращает пропорцию сторон.
	 */
	static public function calc_ratio( $width = 0, $height = 0 ){

		$ratio = 1;

		if( $width < $height ){

			$ratio = $height / $width;

		}else if( $width > $height ){

			$ratio = $width / $height;

		}

		return $ratio;

	}

	// Возвращает строку вида 4:3
	static public function get_ratio(){

	}


	/**
	 * Метод вычисляет неизвестную сторону.
	 * Поиск неизвестной переменной, исходя из пропорции сторон оригинальной картинки.
	 *
	 * @param integer $original_width
	 * @param integer $original_height
	 * @param integer &$width Ширина миниатюры.
	 * @param integer &$height Высота миниатюры.
	 * @return boolean
	 */
	static public function calc_side( $original_width, $original_height, &$width, &$height ){
		if( $width == 0 && $height == 0 || $original_width == 0 && $original_height == 0 )
			return false;

		$ratio = self::calc_ratio( $original_width, $original_height );

		// Задана только ширина, найти высоту.
		if( $width > 0 && $height == 0 ){

			if( $original_width < $original_height ){

				$height = round( $width * $ratio );

			}else if( $original_width > $original_height ){

				$height = round( $width / $ratio );

			}else if( $original_width == $original_height ){

				$height = $width;

			}

			// Задана только высота, найти ширину.
		}else if( $width == 0 && $height > 0 ){

			if( $original_width < $original_height ){

				$width = round( $height / $ratio );

			}else if( $original_width > $original_height ){

				$width = round( $height * $ratio );

			}else if( $original_width == $original_height ){

				$width = $height;

			}

		}else if( $ratio == 1 ){

			$width = $original_width;

			$height = $original_height;

			///	error_log( $width . 'x' . $height );

		}


		if( $width > 0 && $height > 0 ){
			return true;
		}else{
			return false;
		}


	}

	public function __construct(){
		// Установка значений по умолчанию.

		// Наложить водяной знак.
		$this->config['watermark'] = false;
		// Тип водяного знака: текст или картинка.
		// image или text
		$this->config['watermark_mode'] = 'text';
		/**
		 * Положение водяного знака.
		 * lt	t	rt
		 * l	c	r
		 * lb	b	rb
		 */
		$this->config['watermark_position'] = 'rb';
		// Текст по умолчанию, для текстового водяного знака.
		$this->config['watermark_text'] = 'CMS «Синий Кит»';
		// Абсолютный путь к шрифту для текстового водяного знака.
		$this->config['watermark_font'] = app::$config['dirs']['engine'] . '/services/image/tahoma.ttf';
		// Уровень прозрачности текстового водяного знака.
		$this->config['alpha_level'] = 50;
		// Водяной знак в виде картинки.
		$this->config['watermark_image'] = app::$config['dirs']['engine'] . '/services/image/watermark.png';

		// Предопределённые хранилища картинок.
		//		$this->config['dirs'] = [];

		// Размеры
		$this->config['sizes'] = [];
		// Ширина и высота.
		// Если 0, параметр не задан и будет подоброн исходя
		// из пропорции начальной картинки или внешней переменной.
		$this->config['sizes']['custom'] 	= array(0, 0);
		$this->config['sizes']['verysmall'] = array(100, 100);
		$this->config['sizes']['small'] 	= array(160, 160);
		$this->config['sizes']['medium'] 	= array(800, 600);
		$this->config['sizes']['rectangle'] = array(400, 200);
		$this->config['sizes']['mini'] 		= array(40, 30);

		// Полный путь к файлу картинки.
		$this->image['file'] = '';
		// Картинка в представлении GD библиотеки.
		$this->image['image'] = null;
		$this->image['tmp_image'] = null;
		$this->image['width'] = 0;
		$this->image['height'] = 0;
		// MIME картинки
		$this->image['mime'] = '';

	}

	// Инициализация. Тут устанавливаются технические параметры.
	public function init( $config = [] ){
		// Наложить водяной знак.
		if( isset($config['watermark']) && is_bool($config['watermark']) )
			$this->config['watermark'] = $config['watermark'];

		// Тип водяного знака.
		if( isset($config['watermark_mode']) && in_array($config['watermark_mode'],array('text', 'image')) )
			$this->config['watermark_mode'] = $config['watermark_mode'];

		// Текст для текстового водяного знака.
		if( isset($config['watermark_text']) && $config['watermark_text'] != '' )
			$this->config['watermark_text'] = $config['watermark_text'];

		// Шрифт для текстового водяного знака.
		// Файл шрифта должен существовать.
		if( isset($config['watermark_font']) && is_file($config['watermark_font']) )
			$this->config['watermark_font'] = $config['watermark_font'];

		// Уровень прозрачности водяного знака.
		if( isset($config['alpha_level']) )
			$this->config['alpha_level'] = intval($config['alpha_level']);

		if( isset($config['watermark_image']) )
			$this->config['watermark_image'] = $config['watermark_image'];

		if( isset($config['sizes']) )
			$this->config['sizes'] = $config['sizes'];

		// TODO Убрать dirs.
		/*
		$this->config['dirs'][0] = app::$config['dirs']['uploads'] . '/images';
		$this->config['dirs'][1] = app::$config['dirs']['tmp'];

		// Переопределить хранилища картинок.
		if( isset($config['dirs']) && is_array($config['dirs']) ){
			$this->config['dirs'] = [];
			foreach( $config['dirs'] as $dir ){
				if( is_dir($dir) ){
					$this->config['dirs'][] = $dir;
				}
			}
		}
		*/
	}

	public function exist($img, $dir = 0){

		if( !isset($this->config['dirs'][$dir]) )
			return false;

		preg_replace('/[^A-Z_.-]*/i',$img,'');

		$file = $this->config['dirs'][$dir] . '/' . $img;

		$path_parts = pathinfo($file);
		$mime = ext2mime($path_parts['extension']);

		if( is_file($file) && is_image($mime) )
			return true;

	}

	/**
	 * Открыть картинку
	 *
	 * @param str $img имя файла картинки.
	 * @param int $dir индекс хранилища.
	 * @param str $type
	 * 					file - передано имя файла, которое требуется открыть.
	 * 					gd - передан объект GD.
	 * @return bool
	 * 		true - удалось загрузить картинку
	 * 		false - не удалось загрузить картинку
	 */
	public function open($img, $type = 'file'){

		if( $type == 'file' ){

			$file = $img;

			//	app::cons($img);

			//			if( !isset($this->config['dirs'][$dir]) )
			//				return false;

			//		preg_replace('/[^A-Z_.-]*/i',$img,'');

			//			$file = $this->config['dirs'][$dir] . '/' . $img;

			$path_parts = pathinfo($file);
			//		$mime = class_mime::ext2mime($path_parts['extension']);

			//	error_log($file);
			//		exit;

			//	if( is_file($file) && in_array( $mime, class_mime::$images ) ){
			if( is_file($file) === true ){

				$content = file_get_contents($file);

				$this->image['file'] = $file;
				$this->image['image'] = imagecreatefromstring($content);
				$this->image['width'] = imagesx($this->image['image']);
				$this->image['height'] = imagesy($this->image['image']);

				$this->width = $this->image['width'];
				$this->height = $this->image['height'];

				$image_type = exif_imagetype($file);

				switch( $image_type ){
					case 1:
						$this->image['mime'] = 'image/gif';
						break;
					case 2:
						$this->image['mime'] = 'image/jpeg';
						break;
					case 3:
						$this->image['mime'] = 'image/png';
						break;
					case 6:
						$this->image['mime'] = 'image/bmp';
						break;
				}


				//	app::cons($this->image);

				//$this->image['mime'] = $mime;

				unset($content);

				return true;
			}
			else{

				throw new exception('The file on path "' . $img . '" not exists.');
				//return false;
			}


		}else if( $type == 'gd' ){

			if( is_resource($img) == true && get_resource_type($img) == 'gd' ){
				$this->image['image'] = $img;
				$this->image['width'] = imagesx($this->image['image']);
				$this->image['height'] = imagesy($this->image['image']);

			}

		}


	}

	/**
	 * Применить фильтр.
	 * @param arr $filter
	 * 		$filter['watermark'] bool Наложить водяной знак.
	 * 		$filter['grayscale'] bool Перевести изображение чёрно-белый режим.
	 *
	 *
	 */
	public function filter($filter = null){
		// Временная картинка.///
		$image = null;
		$width = 0;
		$height = 0;

		if( isset($filter['size']) && isset($this->config['sizes'][$filter['size']]) ){
			$width = $this->config['sizes'][$filter['size']][0];
			$height = $this->config['sizes'][$filter['size']][1];

			// Попытаться получить ширину из внешней переменной.
			if( $width == 0 && isset($filter['width']) )
				$width = intval($filter['width']);

			// Попытаться получить высоту из внешней переменной.
			if( $height == 0 && isset($filter['height']) )
				$height = intval($filter['height']);

			// Вычислить сторону, по одной известной стороне.
			// Предварительно вычисляется соотношение сторон оригинальной картинки.

			// Соотношение сторон исходной картинки.
			// По умолчанию квадрат.
			$ratio = 1;

			// Задана только ширина, найти высоту.
			if( $width > 0 && $height == 0 ){
				if( $this->image['width'] < $this->image['height'] ){
					$ratio = $this->image['height'] / $this->image['width'];
				}else if( $this->image['width'] > $this->image['height'] ){
					$ratio = $this->image['height'] / $this->image['width'];
				}
				$height = round( $width * $ratio );
				// Задана только высота, найти ширину.
			}else if( $width == 0 && $height > 0 ){
				if( $this->image['width'] < $this->image['height'] ){
					$ratio = $this->image['width'] / $this->image['height'];
				}else if( $this->image['width'] > $this->image['height'] ){
					$ratio = $this->image['width'] / $this->image['height'];
				}
				$width = round( $height * $ratio );
			}

			// Размеры не могут быть больше размеров исходной картинки.
			if( $width > $this->image['width'] )
				$width = $this->image['width'];

			if($height > $this->image['height'])
				$height = $this->image['height'];




			$stretch = true;

			if( $stretch == true ){

				$ratio = self::calc_ratio( $this->config['sizes'][$filter['size']][0], $this->config['sizes'][$filter['size']][1] );

				$bound_orientation = $this->get_orientation( $this->config['sizes'][$filter['size']][0], $this->config['sizes'][$filter['size']][1] );
				$image_orientation = $this->get_orientation( $this->image['width'], $this->image['height'] );

				if( $bound_orientation == 'landscape' ){
					if( $this->config['sizes'][$filter['size']][0] > $this->image['width'] ){

						$width = $this->config['sizes'][$filter['size']][0];
						if( $image_orientation == 'square' ){
							$height = $width;
						}
						else {
							$height = round( $width / $ratio );
						}
					}
				}
				else if( $bound_orientation == 'portrait' ){
					if( $this->config['sizes'][$filter['size']][1] > $this->image['height'] ){
						$height = $this->config['sizes'][$filter['size']][1];

						if( $image_orientation == 'square' ){
							$width = $height;
						}
						else {
							$width = round( $height / $ratio );
						}
					}
				}
				else {

				}



				error_log($width . 'x' . $height);

			}



			if( $width > 0 && $height > 0 ){
				if( $filter['crop'] ){
					// портрет
					if( $this->image['width'] < $this->image['height'] ){
						$ratio = $this->image['height'] / $this->image['width'];

						$crop_width = $width;

						// Высота должна получится более $height пикселей.
						$crop_height = round( $crop_width * $ratio );

						// Перепроверить, ширина и высота не должны быть меньше $width и $height пикселей.
						if( $crop_height < $height ){
							$crop_height = $height;
							$crop_width = round( $crop_height / $ratio );
						}

						// альбом
					}else if( $this->image['width'] > $this->image['height'] ){
						$ratio = $this->image['width'] / $this->image['height'];

						$crop_height = $height;
						// Ширина должна получится более $width пикселей.
						$crop_width = round( $crop_height * $ratio );
						// Перепроверить, ширина и высота недолжны быть меньше $width и $height пикселей.
						if( $crop_width < $width ){
							$crop_width = $width;
							$crop_height = round( $crop_width / $ratio );
						}
						// квадрат
					}else{
						$crop_width = $width;
						$crop_height = $height;
					}

					$width_remainder = 0;
					$height_remainder = 0;

					$left = 0;
					$top = 0;

					if( $crop_width > $width )
						$width_remainder = $crop_width - $width;

					if( $crop_height > $height )
						$height_remainder = $crop_height - $height;


					$left = ($width_remainder - ($width_remainder % 2)) / 2;
					$top = ($height_remainder - ($height_remainder % 2)) / 2;


					$crop_image = imagecreatetruecolor($crop_width, $crop_height);
					imagecopyresampled( $crop_image, $this->image['image'], 0, 0, 0, 0, $crop_width, $crop_height, $this->image['width'], $this->image['height']);

					$image = imagecreatetruecolor($width, $height);
					imagecopyresampled( $image, $crop_image, 0, 0, $left, $top, $width, $height, $width, $height);

					unset($crop_image, $left, $top, $crop_width, $crop_height, $width_remainder, $height_remainder);

				}
				else{

					$image = imagecreatetruecolor($width, $height);
					imagecopyresampled( $image, $this->image['image'], 0, 0, 0, 0, $width, $height, $this->image['width'], $this->image['height']);
				}

				$this->image['tmp_image'] = $image;
			}
		}

		// Наложить водяной знак.
		if( $this->config['watermark'] == true || $filter['watermark'] == true ){
			$this->watermak_overlay();
		}

		// Перевести изображение чёрно-белый режим.
		if( isset($filter['grayscale']) && $filter['grayscale'] == true )
			imagefilter($this->image['tmp_image'], IMG_FILTER_GRAYSCALE);

		unset($image, $width, $height);

	}

	public function save( $path, $fix = '', $quality = 100 ){
		$this->output( true, $path, $fix, $quality );
	}

	public function set_watermark( $watermark_path ){

		$result = false;

		if( is_file( $watermark_path ) == true ){

			$watermark = imagecreatefrompng( $watermark_path );

			if( $watermark != false ){

				$padding = 10;

				$rect = [];
				$rect['x'] = 0;
				$rect['y'] = 0;
				$rect['w'] = 0;
				$rect['h'] = 0;

				$rect['w'] = imagesx( $watermark );
				$rect['h'] = imagesy( $watermark );

				$width = imagesx( $this->image['tmp_image'] );
				$height = imagesy( $this->image['tmp_image'] );

				switch( $this->config['watermark_position'] ){
					case 'lt':
						$rect['x'] = $padding;
						$rect['y'] = $padding;
						break;
					case 't':
						break;
					case 'rt':
						break;
					case 'l':
						break;
					case 'c':
						break;
					case 'r':
						break;
					case 'lb':
						break;
					case 'b':
						break;
					case 'rb':
						$rect['x'] = $width - ( $rect['w'] + $padding );
						$rect['y'] = $height - ( $rect['h'] + $padding );
						break;
				}

				//imagealphablending($this->image['tmp_image'],true);
				//imagealphablending($watermark,true);


				//imagesavealpha($this->image['tmp_image'],true);
				//imagesavealpha($watermark,true);

				//$transparent_color = imagecolorallocate($watermark, 255, 255, 255);
				//imagecolortransparent( $watermark, $transparent_color);

				imagecopy( $this->image['tmp_image'], $watermark, $rect['x'], $rect['y'], 0, 0, $rect['w'], $rect['h'] );

				imagedestroy( $watermark );

				$result = true;

			}

		}

		return $result;

	}


	/**
	 * Вывести картинку.
	 *
	 * @param bool $to_file - сохранить картинку на диск.
	 */
	public function output($to_file = false, $file_name = '', $mime = '', $quality = 100 ){

		if( empty( $this->image['image'] ) )
			return false;

		if( $mime != '' )
			$this->image['mime'] = $mime;

		if( $this->image['tmp_image'] != null ){



			$image = $this->image['tmp_image'];

		}
		else
			$image = $this->image['image'];

		if( $to_file == true ){

			switch( $this->image['mime'] ){
				case 'image/gif':
					imagegif($image,$file_name);
					break;
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/pjpeg': // progressive jpeg


					imagejpeg($image,$file_name,$quality);

					break;
				case 'image/vnd.wap.wbmp':
				case 'image/bmp':



					imagewbmp($image,$file_name);
					break;
				case 'image/png':
					imagepng($image,$file_name);
					break;
			}
		}else{
			header('Content-type: ' . $this->image['mime'],true);
			switch( $this->image['mime'] ){
				case 'image/gif':
					imagegif($image,null);
					break;
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/pjpeg': // progressive jpeg
					imagejpeg($image,null,100);
					break;
				case 'image/bmp':
				case 'image/vnd.wap.wbmp':
					imagewbmp($image,null);
					break;
				case 'image/png':
					imagepng($image,null);
					break;
			}
		}

	}

	/**
	 *
	 *
	 *
	 */
	public function close(){
		imagedestroy($this->image['image']);
	}


	/**
	 * Средний цвет с учётом прозрачности альфа-канала.
	 * TODO
	 */
	protected function average_color( $color1, $color2, $alpha_level ){
		return 0;
	}

	/**
	 * Метод возвращает название ориентации картинки.
	 * @return string $orientation Название ориентации.
	 *
	 * 			landscape
	 * 			portrait
	 * 			square
	 *
	 */
	function get_orientation($width = 1, $height = 1){

		$orientation = '';

		// Определение ориентации изображения.
		if( $width > $height ){

			$orientation = 'landscape'; // Альбомная ориентация.

		}else if( $width < $height ){

			$orientation = 'portrait'; // Портретная ориентация.

		}else if( $width == $height ){

			$orientation = 'square'; // Квадрат.

		}

		return $orientation;

	}


	/**
	 * Наложение водяного знака.
	 *
	 */
	protected function watermak_overlay(){
		if( $this->config['watermark_mode'] == 'image' ){
			if( is_file($this->config['watermark_image']) === true ){
				$watermark = imagecreatefrompng($this->config['watermark_image']);
				if( $watermark != false ){

					$padding = 10;

					$rect = [];
					$rect['x'] = 0;
					$rect['y'] = 0;
					$rect['w'] = 0;
					$rect['h'] = 0;

					$rect['w'] = imagesx($watermark);
					$rect['h'] = imagesy($watermark);

					$width = imagesx($this->image['tmp_image']);
					$height = imagesy($this->image['tmp_image']);

					switch( $this->config['watermark_position'] ){
						case 'lt':
							$rect['x'] = $padding;
							$rect['y'] = $padding;
							break;
						case 't':
							break;
						case 'rt':
							break;
						case 'l':
							break;
						case 'c':
							break;
						case 'r':
							break;
						case 'lb':
							break;
						case 'b':
							break;
						case 'rb':
							$rect['x'] = $width - ( $rect['w'] + $padding );
							$rect['y'] = $height - ( $rect['h'] + $padding );
							break;
					}

					//imagealphablending($this->image['tmp_image'],true);
					//imagealphablending($watermark,true);


					//imagesavealpha($this->image['tmp_image'],true);
					//imagesavealpha($watermark,true);

					//$transparent_color = imagecolorallocate($watermark, 255, 255, 255);
					//imagecolortransparent( $watermark, $transparent_color);

					imagecopy($this->image['tmp_image'], $watermark, $rect['x'], $rect['y'], 0, 0, $rect['w'], $rect['h']);

					imagedestroy($watermark);
				}
			}
		}else{
			$width = imagesx($this->image['tmp_image']);
			$height = imagesy($this->image['tmp_image']);
			$angle = -rad2deg(atan2((-$height),($width)));
			// Небольная корректировка, чтобы текст не был прижат к краям.
			$text = ' ' . $this->config['watermark_text'] . ' ';

			$red = 186;
			$green = 203;
			$blue = 205;

			imagealphablending($this->image['tmp_image'],true);
			$color = imagecolorallocatealpha($this->image['tmp_image'], $red, $green, $blue, $this->config['alpha_level']);
			$size = ( ( $width + $height ) / 2 ) * 2 / strlen($text);
			$box = imagettfbbox( $size, $angle, $this->config['watermark_font'], $text );
			$x = $width / 2 - abs($box[4] - $box[0]) / 2;
			$y = $height / 2 + abs($box[5] - $box[1]) / 2;
			imagettftext($this->image['tmp_image'], $size, $angle, $x, $y, $color, $this->config['watermark_font'], $text);
		}
	}

	/**
	 * Метод возвращает информацию о размере по его названию.
	 *
	 * @return arr list($width,$height);
	 */
	public function get_size_info($name){
		if( isset($this->config['sizes'][$name]) )
			return $this->config['sizes'][$name];
	}


	public function resize( $new_width = null, $new_height = null, $crop = false ){

		$config = [];
		$config['sizes']['100'] = [$new_width,$new_height];

		$this->init($config);

		$filter = [];
		$filter['size'] = '100';
		$filter['crop'] = $crop;


		$this->filter( $filter );

	}

	public function rotate( $degrees = 0 ){

		$degrees = intval( $degrees );

		if( $degrees == 0 ){
			return true;
		}

		$result = imagerotate( $this->image['tmp_image'], $degrees, 0 );

		if( is_resource( $result ) == true ){
			$this->image['tmp_image'] = $result;
			return true;
		}
		else {
			return false;
		}

	}

	public function set_corner( $radius_x = null, $radius_y = null ){

		if( $radius_x == null && $radius_y == null ){
			return false;
		}

		if( $radius_x == null ){
			$radius_x = $radius_y;
		}

		if( $radius_y == null ){
			$radius_y = $radius_x;
		}

		$this->image['tmp_image'] = $this->image['image'];

		//
		// BEGIN Создать маску.
		//

		$gdimg_cornermask = imagecreatetruecolor( $this->width, $this->height );
		$gdimg_cornermask_triple = imagecreatetruecolor( $radius_x * 6, $radius_y * 6 );

		$color_transparent = ImageColorAllocate($gdimg_cornermask_triple, 255, 255, 255);
		ImageFilledEllipse($gdimg_cornermask_triple, $radius_x * 3, $radius_y * 3, $radius_x * 4, $radius_y * 4, $color_transparent);

		ImageFilledRectangle($gdimg_cornermask, 0, 0, $this->width, $this->height, $color_transparent);

		ImageCopyResampled($gdimg_cornermask, $gdimg_cornermask_triple,                           0,                           0,     $radius_x,     $radius_y, $radius_x, $radius_y, $radius_x * 2, $radius_y * 2);
		ImageCopyResampled($gdimg_cornermask, $gdimg_cornermask_triple,                           0, $this->height - $radius_y,     $radius_x, $radius_y * 3, $radius_x, $radius_y, $radius_x * 2, $radius_y * 2);
		ImageCopyResampled($gdimg_cornermask, $gdimg_cornermask_triple, $this->width - $radius_x, $this->height - $radius_y, $radius_x * 3, $radius_y * 3, $radius_x, $radius_y, $radius_x * 2, $radius_y * 2);
		ImageCopyResampled($gdimg_cornermask, $gdimg_cornermask_triple, $this->width - $radius_x,                           0, $radius_x * 3,     $radius_y, $radius_x, $radius_y, $radius_x * 2, $radius_y * 2);


		/*
				header('Content-type: image/png',true);
				//imagejpeg($gdimg_cornermask,null,100);
				imagepng($gdimg_cornermask,null);
				exit;
		*/



		//
		// END Создать маску.
		//




		$this->ApplyMask($gdimg_cornermask, $this->image['tmp_image']);

		/*
		header('Content-type: image/png',true);
		//imagejpeg($gdimg_cornermask,null,100);
		imagepng($this->image['tmp_image'],null);
		exit;
		*/


		imagedestroy( $gdimg_cornermask );
		imagedestroy( $gdimg_cornermask_triple );

		return true;

	}

	function GrayscaleValue($r, $g, $b) {
		return round(($r * 0.30) + ($g * 0.59) + ($b * 0.11));
	}

	function GrayscalePixel($OriginalPixel) {
		$gray = $this->GrayscaleValue($OriginalPixel['red'], $OriginalPixel['green'], $OriginalPixel['blue']);
		return array('red'=>$gray, 'green'=>$gray, 'blue'=>$gray);
	}

	function ImageColorAllocateAlphaSafe(&$gdimg_hexcolorallocate, $R, $G, $B, $alpha=false) {

		return ImageColorAllocateAlpha($gdimg_hexcolorallocate, $R, $G, $B, intval($alpha));

	}

	public function ApplyMask(&$gdimg_mask, &$gdimg_image) {

		$gdimg_mask_resized = $gdimg_mask;

		//$gdimg_mask_resized = imagecreatetruecolor( $this->width, $this->height );
		//ImageCopyResampled($gdimg_mask_resized, $gdimg_mask, 0, 0, 0, 0, $this->width, $this->height, ImageSX($gdimg_mask), ImageSY($gdimg_mask));

		$gdimg_mask_blendtemp = imagecreatetruecolor( $this->width, $this->height );

		$color_background = ImageColorAllocate($gdimg_mask_blendtemp, 0, 0, 0);
		ImageFilledRectangle($gdimg_mask_blendtemp, 0, 0, ImageSX($gdimg_mask_blendtemp), ImageSY($gdimg_mask_blendtemp), $color_background);
		ImageAlphaBlending($gdimg_mask_blendtemp, false);
		ImageSaveAlpha($gdimg_mask_blendtemp, true);

		for ($x = 0; $x < $this->width; $x++) {
			for ($y = 0; $y < $this->height; $y++) {




				$RealPixel = $this->GetPixelColor($gdimg_image, $x, $y);
				$MaskPixel = $this->GrayscalePixel($this->GetPixelColor($gdimg_mask_resized, $x, $y));
				$MaskAlpha = 127 - (floor($MaskPixel['red'] / 2) * (1 - ($RealPixel['alpha'] / 127)));

				$newcolor = $this->ImageColorAllocateAlphaSafe($gdimg_mask_blendtemp, $RealPixel['red'], $RealPixel['green'], $RealPixel['blue'], $MaskAlpha);

				ImageSetPixel($gdimg_mask_blendtemp, $x, $y, $newcolor);

			}
		}


		ImageAlphaBlending($gdimg_image, false);
		ImageSaveAlpha($gdimg_image, true);


		ImageCopy($gdimg_image, $gdimg_mask_blendtemp, 0, 0, 0, 0, ImageSX($gdimg_mask_blendtemp), ImageSY($gdimg_mask_blendtemp));







		ImageDestroy($gdimg_mask_blendtemp);
		ImageDestroy($gdimg_mask_resized);




		return true;
	}

	function GetPixelColor(&$img, $x, $y) {
		if (!is_resource($img)) {
			return false;
		}
		return @ImageColorsForIndex($img, @ImageColorAt($img, $x, $y));
	}


}




class Image extends class_image_handler {

	protected $config = [];

	// Данные о картинке.
	public $image = null;

	// Фильтр обработки.
	public $filter = null;



	/**
	 * Метод возвращает пропорцию сторон.
	 */
	static public function calc_ratio( $width = 0, $height = 0 ){

		$ratio = 1;

		if( $width < $height ){

			$ratio = $height / $width;

		}
		else if( $width > $height ){

			$ratio = $width / $height;

		}

		return $ratio;

	}


	/**
	 * Метод вычисляет неизвестную сторону.
	 * Поиск неизвестной переменной, исходя из пропорции сторон оригинальной картинки.
	 *
	 * @param integer $original_width
	 * @param integer $original_height
	 * @param integer &$width Ширина миниатюры.
	 * @param integer &$height Высота миниатюры.
	 * @return boolean
	 */
	static public function calc_side( $original_width, $original_height, &$width, &$height ){
		if( $width == 0 && $height == 0 || $original_width == 0 && $original_height == 0 )
			return false;

		$ratio = self::calc_ratio( $original_width, $original_height );

		// Задана только ширина, найти высоту.
		if( $width > 0 && $height == 0 ){

			if( $original_width < $original_height ){

				$height = round( $width * $ratio );

			}else if( $original_width > $original_height ){

				$height = round( $width / $ratio );

			}else if( $original_width == $original_height ){

				$height = $width;

			}

			// Задана только высота, найти ширину.
		}else if( $width == 0 && $height > 0 ){

			if( $original_width < $original_height ){

				$width = round( $height / $ratio );

			}else if( $original_width > $original_height ){

				$width = round( $height * $ratio );

			}else if( $original_width == $original_height ){

				$width = $height;

			}

		}else if( $ratio == 1 ){

			$width = $original_width;

			$height = $original_height;

			///	error_log( $width . 'x' . $height );

		}


		if( $width > 0 && $height > 0 ){
			return true;
		}else{
			return false;
		}


	}

	public function __construct(){
		// Установка значений по умолчанию.

		// Наложить водяной знак.
		$this->config['watermark'] = false;
		// Тип водяного знака: текст или картинка.
		// image или text
		$this->config['watermark_mode'] = 'text';
		/**
		 * Положение водяного знака.
		 * lt	t	rt
		 * l	c	r
		 * lb	b	rb
		 */
		$this->config['watermark_position'] = 'rb';
		// Текст по умолчанию, для текстового водяного знака.
		$this->config['watermark_text'] = 'текст';
		// Абсолютный путь к шрифту для текстового водяного знака.
		//		$this->config['watermark_font'] = app::$config['dirs']['engine'] . '/services/image/tahoma.ttf';
		// Уровень прозрачности текстового водяного знака.
		$this->config['alpha_level'] = 50;
		// Водяной знак в виде картинки.
		//		$this->config['watermark_image'] = app::$config['dirs']['engine'] . '/services/image/watermark.png';

		// Предопределённые хранилища картинок.
		//		$this->config['dirs'] = [];

		// Размеры
		$this->config['sizes'] = [];
		// Ширина и высота.
		// Если 0, параметр не задан и будет подоброн исходя
		// из пропорции начальной картинки или внешней переменной.
		$this->config['sizes']['custom'] 	= array(0, 0);
		$this->config['sizes']['verysmall'] = array(100, 100);
		$this->config['sizes']['small'] 	= array(160, 160);
		$this->config['sizes']['medium'] 	= array(800, 600);
		$this->config['sizes']['rectangle'] = array(400, 200);
		$this->config['sizes']['mini'] 		= array(40, 30);

		// Полный путь к файлу картинки.
		$this->image['file'] = '';
		// Картинка в представлении GD библиотеки.
		$this->image['image'] = null;
		$this->image['tmp_image'] = null;
		$this->image['width'] = 0;
		$this->image['height'] = 0;
		// MIME картинки
		$this->image['mime'] = '';

	}

	// Инициализация. Тут устанавливаются технические параметры.
	public function init( $config = [] ){
		// Наложить водяной знак.
		if( isset($config['watermark']) && is_bool($config['watermark']) )
			$this->config['watermark'] = $config['watermark'];

		// Тип водяного знака.
		if( isset($config['watermark_mode']) && in_array($config['watermark_mode'],array('text', 'image')) )
			$this->config['watermark_mode'] = $config['watermark_mode'];

		// Текст для текстового водяного знака.
		if( isset($config['watermark_text']) && $config['watermark_text'] != '' )
			$this->config['watermark_text'] = $config['watermark_text'];

		// Шрифт для текстового водяного знака.
		// Файл шрифта должен существовать.
		if( isset($config['watermark_font']) && is_file($config['watermark_font']) )
			$this->config['watermark_font'] = $config['watermark_font'];

		// Уровень прозрачности водяного знака.
		if( isset($config['alpha_level']) )
			$this->config['alpha_level'] = intval($config['alpha_level']);

		if( isset($config['watermark_image']) )
			$this->config['watermark_image'] = $config['watermark_image'];

		if( isset($config['sizes']) )
			$this->config['sizes'] = $config['sizes'];

		//	error_log(var_export($this->config,true));

		// TODO Убрать dirs.
		/*
		$this->config['dirs'][0] = app::$config['dirs']['uploads'] . '/images';
		$this->config['dirs'][1] = app::$config['dirs']['tmp'];

		// Переопределить хранилища картинок.
		if( isset($config['dirs']) && is_array($config['dirs']) ){
			$this->config['dirs'] = [];
			foreach( $config['dirs'] as $dir ){
				if( is_dir($dir) ){
					$this->config['dirs'][] = $dir;
				}
			}
		}
		*/
	}

	public function exist($img, $dir = 0){

		if( !isset($this->config['dirs'][$dir]) )
			return false;

		preg_replace('/[^A-Z_.-]*/i',$img,'');

		$file = $this->config['dirs'][$dir] . '/' . $img;

		$path_parts = pathinfo($file);
		$mime = ext2mime($path_parts['extension']);

		if( is_file($file) && is_image($mime) )
			return true;

	}

	/**
	 * Открыть картинку
	 *
	 * @param str $img имя файла картинки.
	 * @param int $dir индекс хранилища.
	 * @param str $type
	 * 					file - передано имя файла, которое требуется открыть.
	 * 					gd - передан объект GD.
	 * @return bool
	 * 		true - удалось загрузить картинку
	 * 		false - не удалось загрузить картинку
	 */
	public function open($img, $type = 'file'){

		if( $type == 'file' ){

			$file = $img;

			//	app::cons($img);

			//			if( !isset($this->config['dirs'][$dir]) )
			//				return false;

			//		preg_replace('/[^A-Z_.-]*/i',$img,'');

			//			$file = $this->config['dirs'][$dir] . '/' . $img;

			$path_parts = pathinfo($file);
			//		$mime = class_mime::ext2mime($path_parts['extension']);

			//	error_log($file);
			//		exit;

			//	if( is_file($file) && in_array( $mime, class_mime::$images ) ){
			if( is_file($file) === true ){

				$content = file_get_contents($file);

				$this->image['file'] = $file;
				$this->image['image'] = imagecreatefromstring($content);

				imageSaveAlpha($this->image['image'], true);

				$this->image['width'] = imagesx($this->image['image']);
				$this->image['height'] = imagesy($this->image['image']);

				$image_type = exif_imagetype($file);

				switch( $image_type ){
					case 1:
						$this->image['mime'] = 'image/gif';
						break;
					case 2:
						$this->image['mime'] = 'image/jpeg';
						break;
					case 3:
						$this->image['mime'] = 'image/png';
						break;
					case 6:
						$this->image['mime'] = 'image/bmp';
						break;
				}


				//	app::cons($this->image);

				//$this->image['mime'] = $mime;

				unset($content);

				return true;
			}
			else{

				throw new exception('The file on path "' . $img . '" not exists.');
				//return false;
			}


		}else if( $type == 'gd' ){

			if( is_resource($img) == true && get_resource_type($img) == 'gd' ){
				$this->image['image'] = $img;
				$this->image['width'] = imagesx($this->image['image']);
				$this->image['height'] = imagesy($this->image['image']);

			}

		}


	}

	/**
	 * Применить фильтр.
	 * @param arr $filter
	 * 		$filter['watermark'] bool Наложить водяной знак.
	 * 		$filter['grayscale'] bool Перевести изображение чёрно-белый режим.
	 *
	 *
	 */
	public function filter($filter = null){
		// Временная картинка.///
		$image = null;
		$width = 0;
		$height = 0;

		if( isset($filter['size']) && isset($this->config['sizes'][$filter['size']]) ){
			$width = $this->config['sizes'][$filter['size']][0];
			$height = $this->config['sizes'][$filter['size']][1];

			// Попытаться получить ширину из внешней переменной.
			if( $width == 0 && isset($filter['width']) )
				$width = intval($filter['width']);

			// Попытаться получить высоту из внешней переменной.
			if( $height == 0 && isset($filter['height']) )
				$height = intval($filter['height']);

			// Вычислить сторону, по одной известной стороне.
			// Предварительно вычисляется соотношение сторон оригинальной картинки.

			// Соотношение сторон исходной картинки.
			// По умолчанию квадрат.
			$ratio = 1;

			// Задана только ширина, найти высоту.
			if( $width > 0 && $height == 0 ){
				if( $this->image['width'] < $this->image['height'] ){
					$ratio = $this->image['height'] / $this->image['width'];
				}else if( $this->image['width'] > $this->image['height'] ){
					$ratio = $this->image['height'] / $this->image['width'];
				}
				$height = round( $width * $ratio );
				// Задана только высота, найти ширину.
			}else if( $width == 0 && $height > 0 ){
				if( $this->image['width'] < $this->image['height'] ){
					$ratio = $this->image['width'] / $this->image['height'];
				}else if( $this->image['width'] > $this->image['height'] ){
					$ratio = $this->image['width'] / $this->image['height'];
				}
				$width = round( $height * $ratio );
			}

			// Размеры не могут быть больше размеров исходной картинки.
			if( $width > $this->image['width'] )
				$width = $this->image['width'];

			if($height > $this->image['height'])
				$height = $this->image['height'];


			if( $width > 0 && $height > 0 ){
				if( $filter['crop'] ){
					// портрет
					if( $this->image['width'] < $this->image['height'] ){
						$ratio = $this->image['height'] / $this->image['width'];

						$crop_width = $width;

						// Высота должна получится более $height пикселей.
						$crop_height = round( $crop_width * $ratio );

						// Перепроверить, ширина и высота не должны быть меньше $width и $height пикселей.
						if( $crop_height < $height ){
							$crop_height = $height;
							$crop_width = round( $crop_height / $ratio );
						}

						// альбом
					}else if( $this->image['width'] > $this->image['height'] ){
						$ratio = $this->image['width'] / $this->image['height'];

						$crop_height = $height;
						// Ширина должна получится более $width пикселей.
						$crop_width = round( $crop_height * $ratio );
						// Перепроверить, ширина и высота недолжны быть меньше $width и $height пикселей.
						if( $crop_width < $width ){
							$crop_width = $width;
							$crop_height = round( $crop_width / $ratio );
						}
						// квадрат
					}else{
						$crop_width = $width;
						$crop_height = $height;
					}

					$width_remainder = 0;
					$height_remainder = 0;

					$left = 0;
					$top = 0;

					if( $crop_width > $width )
						$width_remainder = $crop_width - $width;

					if( $crop_height > $height )
						$height_remainder = $crop_height - $height;


					$left = ($width_remainder - ($width_remainder % 2)) / 2;
					$top = ($height_remainder - ($height_remainder % 2)) / 2;


					$crop_image = imagecreatetruecolor($crop_width, $crop_height);
					imagecopyresampled( $crop_image, $this->image['image'], 0, 0, 0, 0, $crop_width, $crop_height, $this->image['width'], $this->image['height']);

					$image = imagecreatetruecolor($width, $height);
					imagecopyresampled( $image, $crop_image, 0, 0, $left, $top, $width, $height, $width, $height);

					unset($crop_image, $left, $top, $crop_width, $crop_height, $width_remainder, $height_remainder);

				}else{
					$image = imagecreatetruecolor($width, $height);
					imagecopyresampled( $image, $this->image['image'], 0, 0, 0, 0, $width, $height, $this->image['width'], $this->image['height']);
				}

				$this->image['tmp_image'] = $image;
			}
		}

		// Наложить водяной знак.
		if( $this->config['watermark'] == true || $filter['watermark'] == true ){
			$this->watermak_overlay();
		}

		// Перевести изображение чёрно-белый режим.
		if( isset($filter['grayscale']) && $filter['grayscale'] == true )
			imagefilter($this->image['tmp_image'], IMG_FILTER_GRAYSCALE);

		unset($image, $width, $height);

	}

	public function save( $path, $fix = '', $quality = 100 ){
		$this->output( true, $path, $fix, $quality );
	}

	/**
	 * Вывести картинку.
	 *
	 * @param bool $to_file - сохранить картинку на диск.
	 */
	public function output($to_file = false, $file_name = '', $fix = '', $quality = 100 ){
		if( empty( $this->image['image'] ) )
			return false;

		if( $fix == 'image/jpg' )
			$this->image['mime'] = 'image/jpg';

		if( $this->image['tmp_image'] != null )
			$image = $this->image['tmp_image'];
		else
			$image = $this->image['image'];

		if( $to_file == true ){

			switch( $this->image['mime'] ){
				case 'image/gif':
					imagegif($image,$file_name);
					break;
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/pjpeg': // progressive jpeg


					imagejpeg($image,$file_name,$quality);

					break;
				case 'image/bmp':
					imagewbmp($image,$file_name);
					break;
				case 'image/png':
					imagepng($image,$file_name);
					break;
			}
		}else{
			header('Content-type: ' . $this->image['mime'],true);
			switch( $this->image['mime'] ){
				case 'image/gif':
					imagegif($image);
					break;
				case 'image/jpeg':
				case 'image/jpg':
				case 'image/pjpeg': // progressive jpeg
					imagejpeg($image,'',100);
					break;
				case 'image/bmp':
					imagewbmp($image);
					break;
				case 'image/png':
					imagepng($image);
					break;
			}
		}

	}

	/**
	 *
	 *
	 *
	 */
	public function close(){
		imagedestroy($this->image['image']);
	}


	/**
	 * Средний цвет с учётом прозрачности альфа-канала.
	 * TODO
	 */
	protected function average_color( $color1, $color2, $alpha_level ){
		return 0;
	}

	/**
	 * Метод возвращает название ориентации картинки.
	 * @return string $orientation Название ориентации.
	 *
	 * 			landscape
	 * 			portrait
	 * 			square
	 *
	 */
	function get_orientation($width = 1, $height = 1){

		$orientation = '';

		// Определение ориентации изображения.
		if( $width > $height ){

			$orientation = 'landscape'; // Альбомная ориентация.

		}else if( $width < $height ){

			$orientation = 'portrait'; // Портретная ориентация.

		}else if( $width == $height ){

			$orientation = 'square'; // Квадрат.

		}

		return $orientation;

	}


	/**
	 * Наложение водяного знака.
	 *
	 */
	public function watermak_overlay( $watermark_image = null, $watermark_mode = 'image' ){


		if( $watermark_mode != null ){
			$this->config['watermark_mode'] = $watermark_mode;
		}

		if( $watermark_image != null ){
			$this->config['watermark_image'] = $watermark_image;
		}

		if( $this->config['watermark_mode'] == 'image' ){
			if( is_file($this->config['watermark_image']) === true ){
				$watermark = imagecreatefrompng($this->config['watermark_image']);
				if( $watermark != false ){

					$padding = 10;

					$rect = [];
					$rect['x'] = 0;
					$rect['y'] = 0;
					$rect['w'] = 0;
					$rect['h'] = 0;

					$rect['w'] = imagesx($watermark);
					$rect['h'] = imagesy($watermark);

					$width = imagesx($this->image['image']);
					$height = imagesy($this->image['image']);

					switch( $this->config['watermark_position'] ){
						case 'lt':
							$rect['x'] = $padding;
							$rect['y'] = $padding;
							break;
						case 't':
							break;
						case 'rt':
							break;
						case 'l':
							break;
						case 'c':
							break;
						case 'r':
							break;
						case 'lb':
							break;
						case 'b':
							break;
						case 'rb':
							$rect['x'] = $width - ( $rect['w'] + $padding );
							$rect['y'] = $height - ( $rect['h'] + $padding );
							break;
					}

					//imagealphablending($this->image['tmp_image'],true);
					//imagealphablending($watermark,true);


					//imagesavealpha($this->image['tmp_image'],true);
					//imagesavealpha($watermark,true);

					//$transparent_color = imagecolorallocate($watermark, 255, 255, 255);
					//imagecolortransparent( $watermark, $transparent_color);

					imagecopy($this->image['image'], $watermark, $rect['x'], $rect['y'], 0, 0, $rect['w'], $rect['h']);

					imagedestroy($watermark);
				}
			}
		}else{
			$width = imagesx($this->image['tmp_image']);
			$height = imagesy($this->image['tmp_image']);
			$angle = -rad2deg(atan2((-$height),($width)));
			// Небольная корректировка, чтобы текст не был прижат к краям.
			$text = ' ' . $this->config['watermark_text'] . ' ';

			$red = 186;
			$green = 203;
			$blue = 205;

			imagealphablending($this->image['tmp_image'],true);
			$color = imagecolorallocatealpha($this->image['tmp_image'], $red, $green, $blue, $this->config['alpha_level']);
			$size = ( ( $width + $height ) / 2 ) * 2 / strlen($text);
			$box = imagettfbbox( $size, $angle, $this->config['watermark_font'], $text );
			$x = $width / 2 - abs($box[4] - $box[0]) / 2;
			$y = $height / 2 + abs($box[5] - $box[1]) / 2;
			imagettftext($this->image['tmp_image'], $size, $angle, $x, $y, $color, $this->config['watermark_font'], $text);
		}
	}

	/**
	 * Метод возвращает информацию о размере по его названию.
	 *
	 * @return arr list($width,$height);
	 */
	public function get_size_info($name){
		if( isset($this->config['sizes'][$name]) )
			return $this->config['sizes'][$name];
	}


	public function resize( $new_width = null, $new_height = null, $crop = false ){

		$config = [];
		$config['sizes'][$new_width] = array($new_width,$new_height);

		$this->init($config);

		$filter = [];
		$filter['size'] = $new_width;
		$filter['crop'] = $crop;

		$this->filter( $filter );

	}

	public function rotate( $degrees = 0 ){

		$degrees = intval( $degrees );

		if( $degrees == 0 ){
			return true;
		}

		$result = imagerotate( $this->image['image'], $degrees, 0 );



		if( $result !== false ){
			$this->image['image'] = $result;
			return true;
		}
		else {
			return false;
		}

	}


}


?>