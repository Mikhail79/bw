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
 * Система кэширования.
 */
class CacheBase {


	/**
	 *
	 */
	public function init(){
	}


	/**
	 *
	 * @param int $expiry время, на которое нужно
	 * кэшировать относительно текущего timestamp.
	 * @param bool $now обновить сразу же cache_db.php, а не в конце cp.php.
	 */
	public function set( $cache_id, $data = null, $expiry = 3600 ){
		return true;
	}


	/**
	 *
	 * @return false - вышел срок или нет такого ключа.
	 */
	public function get( $cache_id ){
		return false;
	}

	public function exists( $cache_id ){
		return false;
	}

	public function delete( $cache_id ){
		return true;
	}


	/**
	 * Обновить закэшированный $cache_id.
	 */
	public function refresh( $cache_id ){
	}


	/**
	 * Сброс кэша.
	 *
	 * TODO Возможность указывать конкретные приложения [site,cp].
	 *
	 * @param boolean $full
	 * 		true Сброс кэша всех приложений.
	 * 		false Сброс кэша текущего приложения.
	 */
	public function flush( $full = false ){
	}

}

?>