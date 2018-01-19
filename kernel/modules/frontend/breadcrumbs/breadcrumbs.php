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

/*
	Хлебные крошки

	Функция формирует последовательность ссылок
	до текущей страницы (горизонтальная навигация).

	Параметры функции:
		$links - массив ссылок на страницы. $links[N]['text'] - текст между <a></a>, $links[N]['href'] - href;
		$between - если стоит true, то разделитель идёт между крошками, false, тогда после каждой крошки.

*/
function breadcrumbs( $links, $url = '', $separator = '/', $between = true, $show_last_link = true ){

	$html = '';

	if( is_array( $links ) == true ){

		$link_count = count( $links );

		if( $link_count > 0 ){

			$c = 0;
			$i = 0;

			foreach( $links as $link ){

				if( $link['text'] == '' ){
					continue;
				}

				$i++;

				if( $between == true ){

					$c++;

					if( $i == $link_count && $show_last_link == false ){

						$html .= '<span class="last_breadcrumb">' . $link['text'] . '</span>';

					}
					else {

						$html .= '<a href="'.$url.$link['href'].'" title="'.htmlspecialchars( $link['text'], ENT_SUBSTITUTE | ENT_QUOTES ).'">' . htmlspecialchars( $link['text'], ENT_SUBSTITUTE | ENT_QUOTES ).'</a>';

					}



					if($c<$link_count) $html .= $separator;

				}
				else {

					if( $i == $link_count && $show_last_link == false ){

						$html .= $link['text'];

					}
					else {

						$html .= '<a href="'.$url.$link['href'].'" title="'.htmlspecialchars( $link['text'], ENT_SUBSTITUTE | ENT_QUOTES ).'">' . htmlspecialchars( $link['text'], ENT_SUBSTITUTE | ENT_QUOTES ) .'</a>&nbsp;' . $separator . '&nbsp;';

					}


				}

			}


		}

	}


	return $html;

}

?>