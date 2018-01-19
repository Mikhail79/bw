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
 * https://github.com/cakephp/cakephp/blob/master/src/Utility/Inflector.php
 *
 * Функции связанные с русским языком.
 * TODO Rename to class_text.
 */
class class_rus {
	
	static public $dictionary = array(
		1 => array(
			'',
			'один',
			'два',
			'три',
			'четыре',
			'пять',
			'шесть',
			'семь',
			'восемь',
			'девять'
		),
		
		2 => array(
			'',
			'одна',
			'две',
			'три',
			'четыре',
			'пять',
			'шесть',
			'семь',
			'восемь',
			'девять'		
		),
		
		10 => array(
			'',
			'',
			'двадцать',
			'тридцать',
			'сорок',
			'пятьдесят',
			'шестьдесят',
			'семьдесят',
			'восемьдесят',
			'девяносто',
			'сто'		
		),
		
		11 => array(
			10 => 'десять',
			11 => 'одиннадцать',
			12 => 'двенадцать',
			13 => 'тринадцать',
			14 => 'четырнадцать',
			15 => 'пятнадцать',
			16 => 'шестнадцать',
			17 => 'семнадцать',
			18 => 'восемнадцать',
			19 => 'девятнадцать'		
		),
		
		100 => array(
			'',
			'сто',
			'двести',
			'триста',
			'четыреста',
			'пятьсот',
			'шестьсот',
			'семьсот',
			'восемьсот',
			'девятьсот',
			'тысяча'		
		),
		
		'variants' => array(
			-1 => array('копейка', 'копейки', 'копеек', 2),
			0 => array('рубль', 'рубля', 'рублей', 1), // 10^0
			1 => array('тысяча','тысячи', 'тысяч', 2), // 10^3
			2 => array('миллион', 'миллиона', 'миллионов', 1), // 10^6
			3 => array('миллиард', 'миллиарда', 'миллиардов',1), // 10^9
			4 => array('триллион', 'триллиона', 'триллионов',1), // 10^12		
		)
	
	); 

	static public function transliterate($text){

		return self::translit($text);

	}

	/**
	 * Транслитерация текста по стандарту ISO 9:1995.
	 *
	 * @link http://www.iso.org/iso/catalogue_detail.htm?csnumber=3589
	 * @param string $text
	 * @return string
	 */
	static public function translit($text){
		$trans = array(
			'а' => 'a',
			'б' => 'b',
			'в' => 'v',
			'г' => 'g',
			'д' => 'd',
			'е' => 'e', 
			'ё' => 'e',
			'ж' => 'zh',
			'з' => 'z',
			'и' => 'i',
			'й' => 'y',
			'к' => 'k',
			'л' => 'l', 
			'м' => 'm',
			'н' => 'n',
			'о' => 'o',
			'п' => 'p',
			'р' => 'r',
			'с' => 's',
			'т' => 't',
			'у' => 'u',
			'ф' => 'f',
			'х' => 'kh',
			'ц' => 'ts',
			'ч' => 'ch',
			'ш' => 'sh',
			'щ' => 'shch',
			'ы' => 'y',
			'э' => 'e',
			'ю' => 'yu',
			'я' => 'ya',
			'А' => 'A',
			'Б' => 'B',
			'В' => 'V',
			'Г' => 'G',
			'Д' => 'D',
			'Е' => 'E',
			'Ё' => 'E',
			'Ж' => 'Zh',
			'З' => 'Z',
			'И' => 'I',
			'Й' => 'Y',
			'К' => 'K',
			'Л' => 'L',
			'М' => 'M',
			'Н' => 'N',
			'О' => 'O',
			'П' => 'P',
			'Р' => 'R',
			'С' => 'S',
			'Т' => 'T',
			'У' => 'U',
			'Ф' => 'F',
			'Х' => 'Kh',
			'Ц' => 'Ts',
			'Ч' => 'Ch',
			'Ш' => 'Sh',
			'Щ' => 'Shch',
			'Ы' => 'Y',
			'Э' => 'E',
			'Ю' => 'Yu',
			'Я' => 'Ya',
			'ь' => '',
			'Ь' => '',
			'ъ' => '',
			'Ъ' => '',
			' ' => '-'
		);
		
		if( preg_match('/[а-яеА-ЯЁ ]/u', $text) === 1 ){
			return strtr($text, $trans);
		}else{
			return $text;
		}
	                        
	}	

	
	/**
	 * Метод задаёт окончание слову, в зависимости от числового показателя.
	 * 
	 * echo 'онлайн 152 ' . class_rus::word_ending( 152, 'человек', 'человек', 'человека' );
	 * @return На выходе получаем 'онлайн 152 человека'.
	 */
	static public function word_ending( $num, $many, $one, $two ){
		$num = intval( abs($num) );
		$remainder10 = $num % 10;
		$remainder100 = $num % 100;
		if ( $remainder100 == 1 || ( ( $remainder100 > 20 ) && ( $remainder10 == 1 ) ) ) return $one;
		if ( $remainder100 == 2 || ( ( $remainder100 > 20 ) && ( $remainder10 == 2 ) ) ) return $two;
		if ( $remainder100 == 3 || ( ( $remainder100 > 20 ) && ( $remainder10 == 3 ) ) ) return $two;
		if ( $remainder100 == 4 || ( ( $remainder100 > 20 ) && ( $remainder10 == 4 ) ) ) return $two;
		return $many;
	}
	
	
	/**
	 * Сумма прописью.
	 * 
	 * @param float $sum
	 * @param bool $strip_coins Отсечь копейки (не округляет). 
	 * @return 
	 * 		sum2str(878867.15); 
	 * 		восемьсот семьдесят восемь тысяч восемьсот шестьдесят семь рублей пятнадцать копеек
	 */
	function sum2str($sum, $strip_coins = false) {
		$int = 0;
		$coins = 0;
		$out = [];

		$sum = number_format($sum, 2, '.', ' ');
		list( $int, $coins ) = explode('.', $sum);
		
		if( $coins < 10 ){
			$coins = str_pad( $coins, 2, '0', STR_PAD_LEFT );
		}else if( $coins == 0 ){
			$coins = '00';
		}
		
		$levels = explode(' ', $int);
		
		$ind = count($levels);
		
		foreach( $levels as $lev ){
			$lev = str_pad($lev, 3, '0', STR_PAD_LEFT);
			
			$ind--;
			
			if( $lev[0] != '0' )
				$out[] = class_rus::$dictionary[100][$lev[0]]; // сотни
				
			$lev = $lev[1] . $lev[2];
			$lev = (int) $lev;
			
			if( $lev > 19 ) { // больше девятнадцати
				$lev = ''.$lev;
				$out[] = class_rus::$dictionary[10][$lev[0]];
				$out[] = class_rus::$dictionary[class_rus::$dictionary['variants'][$ind][3]][$lev[1]];
			}else if( $lev > 9 ) {
				$out[] = class_rus::$dictionary[11][$lev];
			}else if( $lev > 0 ) {
				$out[] = class_rus::$dictionary[class_rus::$dictionary['variants'][$ind][3]][$lev];
			}
			
			if( $lev > 0 || $ind == 0 ) {
				$out[] = class_rus::word_ending(
					$lev,
					class_rus::$dictionary['variants'][$ind][2],
					class_rus::$dictionary['variants'][$ind][0],
					class_rus::$dictionary['variants'][$ind][1]
				);
			}
		}
		
		if( $strip_coins === false ) {
			$out[] = $coins; // копейки
			$out[] = class_rus::word_ending(
				$coins,
				class_rus::$dictionary['variants'][-1][2],
				class_rus::$dictionary['variants'][-1][0],
				class_rus::$dictionary['variants'][-1][1] 
			);
		}
		
		return implode(' ',$out);
	}


	/*

	$arr['name'] = null;

	if( isset( $arr['name'] ) ){

		echo 123;

	}


	exit;

	print_r($_SERVER);

	exit;


	$redsweet="Ура!! Мне необходимо разбить текст на предложения.
	Предложением является текст отделенный точкой с пробелом, восклицательным знаком с пробелом, либо вопросительным знаком с пробелом.
	Для того чтобы выбрать все разделяющие знаки?? Я написала такую регулярку...";

	$q=preg_match_all("/(.+?)(\.|\?|!|:){1,}(\s|<br(| \/)>|<\/p>|<\/div>)/is",$redsweet,$desc_out);

	echo "<pre>";
	print_r($desc_out);
	echo "</pre>";

	*/


}



/**
 *
 * Тест функции:
 *
 * for( $c = 1; $c <= 200; $c++ ){
 *      echo $c . '-' . word_ending( 2, $c ) . ' в рейтинге<br />';
 * }
 */
function word_ending( $gender, $number ){

	$we = '';

	$number = (int) $number;

	$last_number = $number;

	if( strlen( $number ) > 1 ){
		$part = substr( $number, -2, 2 );
		$last_number = substr( $number, -1, 1 );
	}


	if( $gender == 2 ){

		/**
		 * первая
		 * вторая
		 * третья
		 * четвёртая
		 * пятая
		 * шестая
		 * седьмая
		 * восьмая
		 * девятая
		 * десятая
		 * одиннадцатая
		 * двенадцатая
		 * тринадцатая
		 * двадцать третья
		 * тридцать третья
		 * сорок третья
		 * пятьдесят третья
		 * сотая
		 */
		if( $part != 13 && $last_number == 3 ){
			$we = 'я'; // третья
		}
		else {
			$we = 'ая';
		}


	}
	else {

		/**
		 * первый
		 * второй
		 * третий
		 * четвёртый
		 * пятый
		 * шестой
		 * седьмой
		 * восьмой
		 * девятый
		 * десятый
		 * одиннадцатый
		 * двенадцатый
		 * тринадцатый
		 * двадцать третий
		 * тридцать третий
		 * сорок третий
		 * пятьдесят третий
		 * сотый
		 */

		if(
			( in_array( $part, array( 12, 16, 17, 18 ) ) == false
				&& in_array( $last_number, array( 2, 6, 7, 8 ) ) == true )
			|| $part == 40
		){
			$we = 'ой';
		}
		elseif( $part != 13 && $last_number == 3 ){
			$we = 'ий';
		}
		else {
			$we = 'ый';
		}

	}

	return $we;

}

// $wd - порядковый день недели (1-7).
// $variant - вариант названия дня недели (1-4).
function week_day($wd=1,$variant=1){
	$week_days = array(
		array('понедельник','понедельника','в понедельник','ПН'),
		array('вторник','вторника','во вторник','ВТ'),
		array('среда','среды','в среду','СР'),
		array('четверг','четверга','в четверг','ЧТ'),
		array('пятница','пятницы','в пятницу','ПТ'),
		array('суббота','субботы','в субботу','СБ'),
		array('воскресенье','воскресенья','в воскресенье','ВС')
	);

	if(($wd >= 1 && $wd <= 7)&&($variant >= 1 && $variant <= 4)){
		return $week_days[$wd-1][$variant-1];
	}else{
		return false;
	}
}


?>