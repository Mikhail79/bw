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

require( __DIR__ . '/dbm.php' );

/**
 * Class Database Object.
 * Класс для работы с БД.
 */
class DBO {
	
	// Указатель на соединение c БД.
	protected $connection = null;

	/**
	 * Признак того, что транзакция запущена. Является вспомогательным свойством.
	 *
	 * Введено для случая, когда в циклах используется $db->start();
	 * Если внутри цикла не был вызван $db->commit() или $db->rollback(), а запросы выполнялись, то при следующей итерации,
	 * в момент нового вызова $db->start(), все предыдущие запросы будут применены к БД (INSERT, DELETE, etc.), что
	 * не правильно и можно сказать неожиданный результат!
	 *
	 * @var bool
	 */
	protected $transaction_started = false;

	protected $engine = null;

	// fix для возврата только одной записи.
	private $selrow_mode = false;

	public $mysqli = true;
	
	public $host = 'localhost';
	
	public $port = 3306;
	
	public $user = 'root';
	
	public $password = '';
	
	public $db = '';
	
	public $tp = '';
	
	/**
	 * При true логирование запросов отключено.
	 * @var bool
	 */
	public $log_off = true;

	/**
	 * ТИПЫ МАРКЕРОВ:
	 * ? - строка или бинарная-строка (текст, файл, картинка).
	 * ?a -
	 * ?l - ассоциативный (ключ - имя поля)
	 * ?_ - префиксный (для названия таблиц), подставляется автоматически из константы TP.
	 * ?d или ?i - целочисленный
	 * ?f - вещественный (дробный)
	 * ?t - имя таблицы
	 * ?o - оригинал значения, в ставляется как есть.
	 *
	 * Смотрите метод prepare_sql()
	 */


	//static public $markers = array('?', '?f', '?d', '?t', '?a', '?l', '?o');
	public $markers = [
		// Строка.
		'?',
		// Дробное.
		'?f',
		// Целое.
		'?d',
		// Для имён таблиц и полей. Значение обрамляется в ``.
		'?t',
		// Массив. Значения экранируются и перечисляются через запятую.
		'?a',
		// Ассоциативный массив. field=value, fieldN=valueN
		'?l',
		// Значение вставляется без обработки.
		'?o'
	];

	// Имя поля, которое устанавливается в качестве ключа.
	// После выполнения запроса, сбрасывается в null.
	public $field_as_key = null;
	
	// Инициализационные запросы.
	/**
	 * mysqli_set_charset
	 *
	 * This is the preferred way to change the charset. Using mysqli::query() to execute SET NAMES .. is not recommended.
	 *
	 * @var array
	 */
	public $init_queries = array(
//		'SET NAMES utf8',
//		'SET AUTOCOMMIT = 0',
	);
	
	// Массив для хранения истории запросов.
	public $queries = [];
	
	public function __construct(){

	}
	
	public function is_connected(){

		return is_object( $this->connection );

	}

	public function close(){
		if( $this->connection !== null ){
			if( $this->mysqli === true )
				return mysqli_close( $this->connection );
			else
				return mysql_close( $this->connection );
		}
		return false;
	}

	/**
	 * TODO DSN
	 * TODO Убрать exception.
	 *
	 * @param string $host
	 * @param int $port
	 * @param string $db
	 * @param string $user
	 * @param string $password
	 * @return resource|void
	 * @throws exception
	 */
	public function connect( $host = '', $port = 3306, $db = '', $user = '', $password = '' ){
		
		if( $this->connection !== null )
			$this->close();
		
		$this->queries = [];
		$this->host = $host;
		$this->port = $port;
		$this->db = $db;
		$this->user = $user;
		$this->password = $password;

		if( $this->mysqli === true ){

			$this->connection = mysqli_connect( $this->host, $this->user, $this->password, $this->db, $this->port );

		}
		else{

			$this->connection = mysql_connect( $this->host . ':' . $this->port, $this->user, $this->password );

			$r = $this->select_db( $this->db );

			if( $r == false ){

				return false;

			}

		}

		if( $this->connection === false ){

			return false;
			//throw new exception('Can\'t connect to mysql server.');

		}

		if( $this->mysqli === true ){

			// Очень важная функция, так как влияет на работу mysqli_real_escape_string()
			// Подробности: http://php.net/manual/ru/mysqlinfo.concepts.charset.php
			// Примеры, показывающие ситуация:

			// $mysqli = new mysqli("localhost", "my_user", "my_password", "world");
			// Этот запрос не влияет на поведение ф-ии $mysqli->real_escape_string();
			// $mysqli->query("SET NAMES utf8");
			// И этот не влияет на $mysqli->real_escape_string();
			// $mysqli->query("SET CHARACTER SET utf8");
			// но вот этот запрос повлияет на поведение ф-ии $mysqli->real_escape_string();
			// $mysqli->set_charset('utf8');
			// а этот НЕ повлияет, потому что нельзя использовать "-" тире/дефис
			// $mysqli->set_charset('utf-8'); // (utf8, а не utf-8)


			$r = mysqli_set_charset( $this->connection, 'utf8' );

			if( $r === false ){

				error_log('Failed to set the encoding in mysqli_set_charset().');

			}


		}

		foreach( $this->init_queries as $sql ){
			$this->query($sql);
		}
		
		//return $this->connection;

		return true;
	}


	public function client_encoding(){


		return mysqli_character_set_name( $this->connection );

	}

	public function select_db( $db ){

		if( $this->connection === null ) {

			return false;

		}
		
		if( $this->mysqli === true ) {

			return mysqli_select_db($this->connection, $db);

		}
		else {

			return mysql_select_db($db, $this->connection);

		}

	}




	public function insert_data( $table_name, $data, $fields = [] ){



		$keys = array_keys( $fields );


		$sql = 'INSERT INTO ?t (`' . implode( '`,`', $keys ) . '`) VALUES';
		$sql = app::$db->prepare_sql( $sql, $table_name );

		$sql_values = [];

		$sql_pattern = '(' . implode( ',', $fields ) . ')';



		$db = app::$db;

		foreach( $data as $row ){

			$item = [];

			$item[] = $sql_pattern;

			foreach( $fields as $field_name => $field_type ){

				$item[ $field_name ] = '';

				if( array_key_exists( $field_name, $row ) == true ){

					$item[ $field_name ] = $row[ $field_name ];

				}

			}



			$sql_values[] = call_user_func_array( [ $db, 'prepare_sql' ], $item );

		}


		$sql.= implode( ',', $sql_values );

		return $this->query( $sql );

	}



	public function insert_list( $table_name, $fields = [], $list = [] ){

		/*
		if( count( $ext_answers ) > 0 ){

			$sql = 'INSERT INTO poll_results (poll_id, answer_id, ip, uid, create_ts) VALUES';

			$sql_parts = [];

			foreach ( $ext_answers as $answer_id ){

				$sql_parts[] = app::$db->prepare_sql(
					'(?d,?d,?d,?d,?d)',
					$poll['id'],
					$answer_id,
					$ip,
					app::$user->id,
					$ts
				);

			}

			$sql.= implode( ',', $sql_parts );

		}
		/*

/*
						if( count( $list_to_insert ) > 0 ){

					$sql = 'INSERT INTO resume_branches (resume_id,branch_id) VALUES';

					$c = count( $list_to_insert );
					$i = 0;

					foreach( $list_to_insert as $id ){
						$i++;
						$sql.= app::$db->prepare_sql( '(?d,?d)', $resume_id, $id );
						if( $i < $c ){
							$sql.= ',';
						}
					}

					app::$db->q( $sql );

				}
*/

	}


	/**
	 * Использовать в случае INSERT'а.
	 * @return int Возвращает идентификатор добавленной записи.
	 */
	public function insert(){
		$arguments = func_get_args();
		// Если аргументы в одном массиве, корректируем. 
		if( isset( $arguments[0] ) and is_array( $arguments[0] ) )
			$arguments = $arguments[0];
		
		if( is_array( $arguments ) and count( $arguments ) >= 1 ){

			//$sql = self::prepare_sql( $arguments );

			$sql = $this->prepare_sql( $arguments );

			$time_start = microtime(true);
			if( $this->mysqli === true ){
				$result = mysqli_query( $this->connection, $sql );
				$this->log( $sql, $time_start );
				if( $result === false ){
				//	error_log($sql);
					throw new exception('Query "' . $sql . '" not executed. ' . mysqli_errno( $this->connection ) . ': ' . mysqli_error( $this->connection ) );
				}
			//	$this->queries[] = $sql;
				return mysqli_insert_id($this->connection);
			}
			else{
				$result = mysql_query($sql,$this->connection);
				$this->log( $sql, $time_start );
				if( $result === false ){
				//	error_log($sql);
					throw new exception('Query "' . $sql . '" not executed. ' . mysql_errno( $this->connection ) . ': ' . mysql_error( $this->connection ) );
				}
			//	$this->queries[] = $sql;
				
				return mysql_insert_id($this->connection);
			}
		}
		else{
			return false;
		}	
	}
	
	// Использовать в случае SELECT'а
	// Возвращает ассоциативный массив с записями.
	// Например:
	//		// Запись 1
	// 		$records[0]['ID'];
	//		$records[0]['Name'];
	//		// Запись 2
	// 		$records[1]['ID'];
	//		$records[1]['Name'];
	//		// Кол-во полученных записей.
	//		count($records);
	//
	public function select(){
		$records = []; // массив записей
		$arguments = func_get_args();
		// Если аргументы в одном массиве, корректируем. 
		if( isset($arguments[0]) and is_array($arguments[0]) )
			$arguments = $arguments[0];

		if( is_array($arguments) and count($arguments) >= 1 ){
			//$sql = self::prepare_sql($arguments);
			$sql = $this->prepare_sql($arguments);

			$time_start = microtime(true);

			if( $this->mysqli === true ){

				$result = mysqli_query( $this->connection, $sql );



				if( $result !== false ){

					while( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ){
						if( $this->field_as_key != null ){
							$records[ $row[ $this->field_as_key ] ] = $row;
						}
						else{
							$records[] = $row;
						}
					}



					mysqli_free_result($result);

				}

			}
			else{

				$result = mysql_query( $this->connection, $sql );

				if( $result !== false ){
					while( $row = mysql_fetch_array( $result, MYSQL_ASSOC ) ){
						if( $this->field_as_key != null ){
							$records[ $row[ $this->field_as_key ] ] = $row;
						}else{
							$records[] = $row;
						}						
					}
					mysql_free_result($result);
				}

			}

			$this->log( $sql, $time_start );

			if( $result === false ){
				// error_log($sql);
				if( $this->mysqli === true ){
					throw new exception('Query "' . $sql . '" not executed. ' . mysqli_errno( $this->connection ) . ': ' . mysqli_error( $this->connection ) );
				}
				else {
					throw new exception('Query "' . $sql . '" not executed. ' . mysql_errno( $this->connection ) . ': ' . mysql_error( $this->connection ) );
				}				
			}

			/*
			$time_end = microtime(true);
			$time = $time_end - $time_start;
			$time < 0 ? $time = round(($time_start-$time_end),5) : $time = round($time,5);
			$this->queries[] = $sql . ' [время выполнения = ' . (string) $time . ' сек.]';
			*/
		}


		// Сбросить.
		$this->field_as_key = null;


		
		//if( $this->selrow_mode === true && count($records) > 0 ){
		if( $this->selrow_mode == true ){

			$this->selrow_mode = false;

			if( count($records) > 0 ){

				return $records[0];

			}
			else {

				return null;

			}

		}
		else {
			$this->selrow_mode = false;
			
			if( count($records) == 0 ){
				return null;
			}
			
			return $records;
		}


	}



	public function get_records(){

		$list = [];


		$records = $this->select( func_get_args() );


		if( is_array( $records ) == true ){

			$list = $records;

		}

		return $list;

	}




	public function select_cache(){

		$sql = call_user_func_array( [ $this, 'prepare_sql' ], func_get_args() );

		if( $sql === false ){

			return null;

		}


		$cache_id = 'sql|' . md5( $sql );

		$result = cache::get( $cache_id );

		if( $result === false ){

			$result = $this->select( $sql );

			cache::set( $cache_id, $result );

		}




		return $result;

	}

	public function select_row_cache(){

		$this->selrow_mode = true;

		$result = call_user_func_array( [ $this, 'select_cache' ], func_get_args() );

		// TODO Исправить.
		// По идеи, это отключение прописано в select(), но по каким-то причинам не сбрасывается в CP.
		$this->selrow_mode = false;

		return $result;

	}






	// Использовать просто для исполнения запросов. 
	// Если не требуется получить результат.
	function query(){
		$arguments = func_get_args();
		// Если аргументы в одном массиве, корректируем. 
		if( isset($arguments[0]) and is_array($arguments[0]) )
			$arguments = $arguments[0];
		if( is_array($arguments) and count($arguments)>=1){

			//$sql = self::prepare_sql($arguments);

			$sql = $this->prepare_sql($arguments);

			$time_start = microtime( true );

			if( $this->mysqli === true ){
				$result = mysqli_query( $this->connection, $sql );
			}
			else{
				$result = mysql_query( $this->connection, $sql );
			}

			$this->log( $sql, $time_start );

			if( $result === false ){
				//error_log($sql);
				if( $this->mysqli === true ){
					throw new exception('Query "' . $sql . '" not executed. ' . mysqli_errno( $this->connection ) . ': ' . mysqli_error( $this->connection ) );
				}
				else{
					throw new exception('Query "' . $sql . '" not executed. ' . mysql_errno( $this->connection ) . ': ' . mysql_error( $this->connection ) );
				}
			}


			/*
			$time_end = microtime(true);		
			$time = $time_end - $time_start;
			$time < 0 ? $time = round(($time_start-$time_end),5) : $time = round($time,5);
			$this->queries[] = $sql . ' [время выполнения = ' . (string) $time . ' сек.]';
			*/
			return $result;	
		}
		else{
			return false;
		}
	}
	
	// Функции "обёртки".
	public function ins(){ 
		return $this->insert(func_get_args()); 
	}
	
	public function q(){
		return $this->query(func_get_args());
	}
	
	public function sel(){
		return $this->select(func_get_args());
	}

	
	/**
	 * Запросить 1 запись.
	 * 
	 * Методика проверки возвращаемого результата
	 * 
	 * $row = $db->select_row($sql, $ts, $ip, $user['id']);
	 * 
	 * // Запись пуста (нет данных).
	 * if( empty($row) === true )
	 * // Запись не пуста
	 * if( empty($row) !== true )
	 */
	public function selrow(){
		$this->selrow_mode = true;
		return $this->select(func_get_args());
	}


	/**
	 * @return array|null
	 * @throws exception
	 */
	public function get_record(){
		$this->selrow_mode = true;
		return $this->select(func_get_args());
	}
	
	public function select_row(){
		$this->selrow_mode = true;
		return $this->select(func_get_args());
	}
	

	/**
	 * Возвращает количество рядов, затронутых последним INSERT, UPDATE, DELETE.
	 * При использовании транзакций, affected_rows() нужно вызывать после 
	 * INSERT, UPDATE, REPLACE, DELETE запроса, но перед COMMIT.
	 * 
	 */
	public function affected_rows(){
		if( $this->mysqli === true ){
			return mysqli_affected_rows( $this->connection );
		}else{
			return mysql_affected_rows( $this->connection );	
		}
	}
	
	/**
	 * Экранирует спец. символы в значение.
	 */
	public function real_escape_string( $value = '' ){
		if( $this->mysqli == true ){
			return mysqli_real_escape_string($this->connection, $value);
		}else{
			return mysql_real_escape_string($value, $this->connection);
		}		
	}
	


	/* 
		Функция для работы с sql-запросами.
		Позволяет избежать sql-injection атак.
		Производит замену специальных маркеров на значения, 
		в соответствии с типом маркера.
		
		ТИПЫ МАРКЕРОВ:
		
		? - строка или бинарная-строка (текст, файл, картинка).
		?a - списковый/ассоциативный
		?l - списковый (list)
		?_ - префиксный (для названия таблиц), подставляется автоматически из константы TP.
		?d - целочисленный
		?f - вещественный (дробный)
		?t - имя таблицы
		?o - оригинал значения, в ставляется как есть.
		
		Параметры функции:
			$arguments[0] - sql-запрос;
			$arguments[x] - переменные для подстановки, где x > 0;

	*/ 
	public function prepare_sql(){

		$arguments = func_get_args();



		// Если аргументы в одном массиве, корректируем. 
		if(isset($arguments[0]) and is_array($arguments[0]))
			$arguments = $arguments[0];

		// Выделяем sql-запрос
		$sql = array_shift($arguments);



		// Части запроса
		$sql_parts = [];

		// Поиск маркеров.
		$position = 0;

		$marker = '';

		// Кол-во маркеров.
		$marker_count = 0;

		// Кол-во префиксов таблицы.
		// Ввёл специально, чтобы не нарушить логику.
		$table_prefix_count = 0;

		// Сколько маркеров в запросе.
		$a = [];
		$find_markers = preg_match_all('/\?/',$sql,$a);

		// Начало следующего "куска" строки.
		$begin = 0;

		while (false !== ($position = mb_strpos($sql, '?', $position))) {

			$find_markers--;

			// Запомнить "кусок" строки.
			$sql_parts[] = mb_substr($sql,$begin,$position-$begin);

			// Определить тип маркера.
			switch(mb_substr($sql,$position+1,1)){
				case '_': $marker = '?_'; break;
				case 'o': $marker = '?o'; break;
				case 'a': $marker = '?a'; break;
				case 'd': $marker = '?d'; break;
				case 'f': $marker = '?f'; break;
				case 't': $marker = '?t'; break;
				case 'l': $marker = '?l'; break;
				default: $marker = '?'; break;
			}

			if($marker=='?_'){
				$table_prefix_count++;
			}else{
				$marker_count++;
			}

			// Запомнить маркер.
			$sql_parts[] = $marker;

			// Определить начало следующего "куска" строки.
			(mb_strlen($marker)==2)?$begin = $position + 2:$begin = $position + 1;
			$position++;

			// после последнего маркера могут быть оставшиеся "куски" строки.
			if($find_markers==0){
				$sql_parts[] = mb_substr($sql,$begin,mb_strlen($sql)-$begin);
			}
		}

		if($marker_count==0 && $table_prefix_count==0) return $sql;

		$sql = '';

		if( count($arguments) == $marker_count ){

			$c = 0;
			$i = 0;

			foreach( $sql_parts as $str ){

				$i++;

				if( in_array( $str, $this->markers ) == true ){

					$c++;

					$var = $arguments[ $c - 1 ];

					if( $str == '?d' ){
						
						$var = uintval( $var );

						$sql_parts[ $i - 1 ] = ( $var < 0 ? '(' . $var . ')' : $var );

					}
					else if( $str == '?f' ){
						
						$var = floatval( $var ); 
						
						$sql_parts[ $i - 1 ] = ( $var < 0 ? '(' . $var . ')' : $var );

					}
					else if( $str == '?t' ){

						// TODO Просмотреть более точный формат MySQL по наименованию таблиц.
						(preg_match('/^[a-z0-9]+[a-z0-9_]*$/i',$var)==1)?$sql_parts[$i-1]= '`' . $var . '`':$sql_parts[$i-1]='';

					}
					else if( $str == '?' ){


						if( is_object( $var ) == true || is_array( $var ) == true ){

							$var = serialize( $var );

						}



						if( $this->mysqli == true ){

							$sql_parts[ $i - 1 ] = '"' . mysqli_real_escape_string($this->connection, $var) . '"';

						}else{

							$sql_parts[ $i - 1 ] = '"' . mysql_real_escape_string($var, $this->connection) . '"';

						}

					}
					else if( $str == '?o' ){ // original, вставить без изменений.

						$sql_parts[ $i - 1 ] = $var;

					}
					else if( $str == '?l' || $str == '?h' ){ // list or hash

						if( is_array($var) == true ){

							$parts = [];

							foreach( $var as $key => $val ){

								if( is_array( $val ) == true ){
									$val = serialize( $val );
								}
								else {
									$val= (string) $val;
								}

								if( $this->mysqli == true ){

									$parts[] = '`' . $key . '` = "' . mysqli_real_escape_string($this->connection, $val) . '"';

								}else{

									$parts[] = '`' . $key . '` = "' . mysql_real_escape_string($val, $this->connection) . '"';

								}

							}

							$sql_parts[ $i - 1 ] = implode( ', ', $parts );

						}

					}
					else if( $str == '?a' ){

						if( is_array($var) == true ){

							$parts = [];

							foreach( $var as $val ){

								if( is_array( $val ) == true ){

									$val = serialize( $val );

								}

								if( $this->mysqli == true ){

									$parts[] = '"' . mysqli_real_escape_string($this->connection, $val) . '"';

								}
								else{

									$parts[] = '"' . mysql_real_escape_string($val, $this->connection) . '"';

								}

							}

							$sql_parts[ $i - 1 ] = implode( ',', $parts );

						}

					}

				}
				else if( $str == '?_' ){

					$sql_parts[ $i - 1 ] = $this->tp;

				}

				$sql.= $sql_parts[$i-1];

			}

			return $sql;

		}
		else{

			return false; // кол-во аргументов не соответствует кол-во найденных маркеров.

		}


	}

	
	// Функция читает sql запросы из файла и возвращает массив с запросами. 
	function read_sql_file($sql_file){
		$sql = read_file($sql_file);
		$regexp = '((INSERT ((?:(?(?<!\'|\")(?!INSERT|CREATE)|.).|\r|\n)*))|(CREATE (.|\r|\n(?!INSERT|CREATE))*))';
		$num = preg_match_all('/'.$regexp.'/i',$sql,$arr);
		return $arr[0];
	}

	function truncate( $table, $confirmation = false ){
		if( $confirmation === true ){
			$this->q( 'TRUNCATE ?t', $table );
		}
	}



	/**
	 * Метод запускает начало транзакции.
	 * При этом выполняемые INSERT-запросы, всё равно будут менять id.
	 */
	public function start(){
		$this->start_transaction();
	}
	
	/**
	 * http://phpclub.ru/mysql/doc/innodb-transaction-model.html
	 */ 
	public function start_transaction( $level = dbm::SERIALIZABLE ){

		if( $this->transaction_started == true ){
			return;
		}

		$str_level = '';

		switch( $level ){
			case dbm::READ_COMMITTED:
				$str_level = 'READ COMMITTED';
				break;
			case dbm::READ_UNCOMMITTED:
				$str_level = 'READ UNCOMMITTED';
				break;
			case dbm::REPEATABLE_READ:
				$str_level = 'REPEATABLE READ';
				break;
			case dbm::SERIALIZABLE:
			default:
				$str_level = 'SERIALIZABLE';
				break;
		}

		$this->q('SET SESSION TRANSACTION ISOLATION LEVEL ' . $str_level);
		$this->q('START TRANSACTION');
		$this->transaction_started = true;
	}
	
	/**
	 * Синоним START TRANSACTION.
	 */
	public function begin(){
		$this->q('BEGIN');
	}	
	
	public function commit(){
		$this->q('COMMIT');
		$this->transaction_started = false;
	}
	
	public function rollback(){

		//$count = count( app::$db->queries ) - 1;

		$count = count( $this->queries ) - 1;

		//$sql = app::$db->queries[ $count ];

		//print_r($this->queries);
		//error_log('$count ' . $count);

		if( array_key_exists( $count, $this->queries ) == true ) {

			$sql = $this->queries[ $count ];

		}

		// TODO Сделать лог файл для rollback.
		//app::cons( 'ROLLBACK LAST QUERY: ' . $sql );

		$this->q('ROLLBACK');
		$this->transaction_started = false;
	}	


	public function prepare_limit( $page, $limit ){

		$sql = '';

		$limit = intval( $limit );
		$page = intval( $page );

		if( $limit > 0 ) {

			$offset = ( $page - 1 ) * $limit;

			$sql = 'LIMIT ' . $offset . ',' . $limit;

		}

		return $sql;

	}

	
	/**
	 * Метод возвращает строку вида 'WHERE ...'.
	 * 
	 * @return string
	 */
	public function prepare_where( $where = null ){
		$sql = '';
		$sql_where = [];
		
		if( $where == null ){
			return $sql;
		}
		
		if( is_string( $where ) == true && $where != '' ){
			
			$sql_where[] = $where;
			
		}
		else if( is_array( $where ) == true ){

			foreach( $where as $field_name => $condition ){

				if( is_array( $condition ) == true ){

					if( count( $condition ) == 1 ){
										
						/**
						 * $condition[0] - выражение
						 */
						$sql_where[] = $condition[0];
						
					}
					else if( count( $condition ) == 2 ){
						
						/**
						 * $condition[0] - условие объединения: AND, OR и т.д.
						 * $condition[1] - выражение
						 */
						$sql_where[] = $condition[0] . ' ' . $condition[1];
						
					}
					else if( count( $condition ) == 3 ){
						
						/**
						 * $condition[0] - название поля
						 * $condition[1] - оператор: =, <>, >, <, <=, >=, IN, NOT IN, LIKE, NOT LIKE и т.д.
						 * $condition[2] - значение поля
						 */
						$sql_where[] = $condition[0] . ' ' . $condition[1] . ' "' . $this->real_escape_string( $condition[2] ) . '"';
						
					}
					else if( count($condition) == 4 ){
						
						/**
						 * $condition[0] - условие объединения: AND, OR и т.д.
						 * $condition[1] - название поля
						 * $condition[2] - оператор: =, <>, >, <, <=, >=, IN, NOT IN, LIKE, NOT LIKE и т.д.
						 * $condition[3] - значение поля
						 */
						$sql_where[] = $condition[0] . ' ' . $condition[1] . ' ' . $condition[2] . ' "' . $this->real_escape_string( $condition[3] ) . '"';

					}
					
				}
				//else if( is_string( $condition ) == true && $condition != '' ){
				else {

					if( is_numeric( $field_name ) == false ){
						$sql_where[] = '`' . $field_name . '` = ' . $condition;
					}
					else {
						$sql_where[] = $condition;
					}

				}
				
			}
			
		}
		
		if( count($sql_where) > 0 ){
			$sql = 'WHERE ' . implode(' AND ', $sql_where);
		}

		return $sql;

	} 
	
	/**
	 * Метод возвращает строку вида 'ORDER ...'.
	 * 
	 * @return string
	 */
	public function prepare_order( $order = null ){
		$sql = '';
		$sql_order = [];
		
		if( is_string( $order ) == true && $order != '' ){
			
			$sql_order[] = $order;
			
		}else if( is_array( $order ) == true ){
			
			foreach( $order as $field ){
				
				if( is_array( $field ) == true ){
					
					if( count( $field ) == 1 ){
						
						$sql_order[] = $field[0];
						
					}else if( count( $field ) == 2 ){
						
						/**
						 * $field[0] - название поля.
						 * $field[1] - DESC или ASC.
						 */
						$sql_order[] = $field[0] . ' ' . $field[1];
						
					}
				
				}else if( is_string( $field ) == true && $field != '' ){
					
					$sql_order[] = $field;
					
				}
				
			}
			
		}

		if( count($sql_order) > 0 ){
			$sql = 'ORDER BY ' . implode(', ', $sql_order);		
		}
		
		return $sql;
	}


	public function get_max_id( $table_name = null, $field_name = 'id' ){
		$id = 0;

		$sql = 'SELECT MAX(?t) AS `max_id` FROM ?t';
		$row = $this->selrow( $sql, $field_name, $table_name );

		if( $row != null ){
			$id = $row['max_id'];
		}

		return $id;
	}


	/**
	 * Метод генерирует новый inner_id в пределах указанных рамок, через WHERE.
	 *
	 * Например нужно получить уникальный inner_id в пределах пользователя.
	 *
	 *
	 * $where = 'uid = 123'
	 *
	 * $inner_id = app::$db->get_inner_id('comments', $where);
	 *
	 * Например нужно получить уникальный inner_id для файла в пределах сообщения и пользователя.
	 *
	 * $where = 'uid = 123 AND message_id = 5'
	 *
	 *
	 * $inner_id = app::$db->get_inner_id('files', $where);
	 *
	 * @param null $table_name
	 * @param null $where В формате dbo->prepare_where
	 * @return int|null
	 */
	public function get_inner_id( $table_name = null, $where = null, $field_inner_id = 'inner_id' ){

		if( $table_name == null )
			return null;

		$inner_id = 1;

		$sql = 'SELECT IFNULL( MAX( ?t ) + 1, 1 ) AS new_id FROM ?t';
		$sql.= ' ' . $this->prepare_where( $where );


//		app::cons($sql);

		$row = $this->selrow(
			$sql,
			$field_inner_id,
			$table_name
		);

		if( $row != null ){
			$inner_id = $row['new_id'];
		}

		return $inner_id;

	}


	public function log( $sql, $time_start ){
	//	error_log( $sql );

		if( $this->log_off == false ){
			$time_end = microtime( true );
			$time = $time_end - $time_start;
			$time = $time < 0 ? round( ( $time_start - $time_end ), 5 ) : round( $time, 5 );
			// Избавляемся от E у float.
			$time = number_format( $time, 5, '.', '' );

			$this->queries[] = $sql . ' [время выполнения = ' . $time . ' сек.]';
		}
	}


	/**
	 * не подходит для случаев с left join.
	 *
	 * @param $table_name
	 * @param array $where
	 * @return int
	 */
	public function select_count( $table_name, $where = [] ){

		$sql = 'SELECT COUNT(*) AS `count` FROM ?t ' . $this->prepare_where( $where );

//		app::cons($sql);

//		error_log($sql);

		$row = $this->selrow( $sql, $table_name );

		$count = 0;

		if( $row != null ){
			$count = $row['count'];
		}

		return $count;

	}


	public function database_exists( $name ){


		$name = (string) $name;

		$sql = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?';

		$row = $this->select_row( $sql, $name );


		if( $row !== null ){

			if( mb_strtolower( $row['SCHEMA_NAME'] ) == mb_strtolower( $name ) ){

				return true;

			}
			else {

				return false;

			}

		}

		return false;



	}

	public function table_exists( $table_name ){

		$table_name = (string) $table_name;

		$sql = 'SHOW TABLES LIKE ?';

		$row = $this->select_row( $sql, $table_name );

		if( $row !== null ){

			return true;

		}

		return false;

	}

	public function field_exists( $table_name, $field_name, $database = null ){

		if( $database == null ){

			$database = app::$db->db;

		}

		$sql = 'SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?';
		$row = app::$db->select_row( $sql, $database, $table_name, $field_name );

		if( $row !== null ){

			return true;

		}
		else {

			return false;

		}


	}


	public function get_table_info( $table_name, $database = null ){

		if( $database == null ){

			$database = app::$db->db;

		}

		$sql = 'SELECT * FROM information_schema.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?';
		$table = app::$db->select_row( $sql, $database, $table_name );

		return $table;

	}


	public function get_table_fields( $table_name, $database = null ){

		if( $database == null ){

			$database = app::$db->db;

		}

		$sql = 'SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?';
		$table = app::$db->select( $sql, $database, $table_name );

		return $table;

	}

	public function get_field_info( $table_name, $field_name, $database = null ){

		if( $database == null ){

			$database = app::$db->db;

		}

		$sql = 'SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?';
		$row = app::$db->select_row( $sql, $database, $table_name, $field_name );

		return $row;

	}


	public function get_tables( $database_name = null ){

		if( $database_name == null ){

			$database_name = $this->db;

		}

		$sql = 'SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?';
		$records = $this->get_records( $sql, $database_name );

		$tables = [];

		foreach( $records as $record ){

			$tables[] = $record['TABLE_NAME'];

		}

		return $tables;

	}

}






?>