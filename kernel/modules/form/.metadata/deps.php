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

// Fix. Так как модуль form ещё не загрузился, необходимо подключить класс формы.
require_once( $this->dir . '/form.php' );

app::load_module('frontend', 'kernel');

?>