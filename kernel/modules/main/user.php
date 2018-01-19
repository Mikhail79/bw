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
 * Класс для работы с сущностью "пользователь". 
 */
 
class User {
	
	// Код пользователя.
	public $id = 0;
	
	// Данные пользователя.
	public $data = [];

	protected $protected_data = [];

	// Дополнительные данные.
	protected $ds = null;
	
	// Признак инициализированности.
	protected $initialized = false;


	protected $avatar_url = null;
	public $avatar = null;

	public function get_avatar_url(){
		return $this->avatar_url;
	}

	/**
	 * Метод загружает данные, указанного пользователя.
	 * TODO Должна происходить загрузка информации по группам.
	 *
	 */
	public function init( $uid ){

		if( $this->initialized == true )
			return $this->initialized;
		
		if( $uid > 0 ){

			$sql = 'SELECT * FROM ?_users WHERE id = ?d AND active = ?d AND remove_ts = ?d';

			$user = app::$db->selrow( $sql, $uid, 1, 0 );

			if( $user != null ){

				//
				// BEGIN Деактивация пользователя.
				//

				// Если установлен срок действия учётной записи.
				if( $user['deactivation_ts'] > 0 && $user['active'] == 1 ){

					$ts = time();

					// Если наступил срок деактивации.
					if( $user['deactivation_ts'] <= $ts ){

						$sql = 'UPDATE ?_users SET active = ?d WHERE id = ?d';

						app::$db->q( $sql, 0, $user['id'] );

						error_log('The user account (ID: ' . $user['id'] . ') was deactivated.');

						return false;

					}

				}

				//
				// END Деактивация пользователя.
				//

				$this->initialized = true;
				$this->protected_data = $user;


				if( $user['avatar_id'] > 0 ){

					$sql = 'SELECT * FROM files WHERE id = ?d';
					$file = app::$db->selrow( $sql, $user['avatar_id'] );

					if( $file != null ){
						$this->avatar_url = app::$url . '/internals/uploads/avatars/100x100/' . $file['name'] . '.jpg';
						$this->avatar = $file;
					}


				}



				$this->id = $user['id'];

			}

			/*
			app::load_module('dataset', 'kernel');

			// Дополнительные данные.
			// Загрузить настройки пользователя.
			// TODO Сделать возможность кастомизации.
			$this->ds = new dataset('users');
			$filter = [];
			$filter[] = array( '', 'uid', '=', $uid );



			$this->ds->set_filter($filter);
			$this->ds->load();



			if( $this->ds->count() == 0 ){
				$this->ds->add('user');
				$this->ds->field('uid', $uid);
				$this->ds->update();
			}
			*/
			
		}
		
		return $this->initialized;
		
	}


	public function update_request_time(){

		if( $this->id == 0 ){
			return false;
		}

		$sql = 'UPDATE users SET last_request_ts = ?d WHERE id = ?d';
		app::$db->q( $sql, time(), $this->id );

		return true;

	}


	/**
	 * Записывает настройки пользователя.
	 * 
	 * @return boolean 
	 * 		true Всё ок.
	 * 		false Проблема.
	 */
	public function set_option($option, $value){
		if( is_object( $this->ds ) == false )
			return false;
			
	//	error_log( $value );
			
		$result = $this->ds->field( $option, $value );
		
		$this->ds->update();
		
		//error_log( $this->ds->field( $option ) );
		
		return $result;
	}
	
	
	/**
	 * Читает настройки пользователя.
	 */
	public function get_option($option){
		return $this->ds->field( $option );
	}

	public function __set($name, $value){
		if( $this->initialized == false )
			return;		
		
		$this->protected_data[$name] = $value;
    }

    public function &__get( $name ){

	    if( $this->initialized == false ){
		    return null;
		    // TODO Под гостем fatal. Выяснить позже.
		    // throw new Exception('The user object not initialized.');
		}

	    if ( array_key_exists( $name, $this->protected_data ) == false ){
			throw new Exception('The field "' . $name . '" not found in user object.');
	    }
    	

		return $this->protected_data[$name];

	    /*
		$trace = debug_backtrace();
		
		$msg = 'Undefined property via __get(): ' . $name;
		$msg.= ' in ' . $trace[0]['file']; 
		$msg.= ' on line ' . $trace[0]['line'];  
		
        trigger_error( $msg, E_USER_NOTICE );

        return null;
        */
    }


	public function get_full_name(){

		$arr_name = [];

		$arr_name[] = $this->first_name;
		$arr_name[] = $this->middle_name;
		$arr_name[] = $this->last_name;


		$name = implode( ' ', $arr_name );

		$name = trim( $name );

		return $name;

	}

}

?>