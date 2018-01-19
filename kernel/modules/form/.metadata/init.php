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

app::add_style( $module->url . '/form/form.css' );
app::add_script( $module->url . '/form/form.js' );

app::add_style( $module->url . '/field_key_value/style.css' );

//app::add_script( app::$kernel_url . '/other/jquery/jquery.maskedinput.js' );

// Добавляет табуляцию.
//app::add_script( app::$kernel_url . '/other/jquery/jquery.textarea.js', 0, false, 'async_load' );
//app::add_script( app::$kernel_url . '/other/jquery/jquery.textarea.js' );

?>