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
 * Класс для работы с вложенными наборами.
 *
 *
 * NS - Nested Sets
 */
class NS {

	public $table = 'ns';

	public $root = array(
		'id' => 1,
		'left_id' => 1,
		'right_id' => 2,
		'parent_id' => 0,
		'level' => 0
	);

/*
	protected $config = [
		// При создании нового узла.
		'oncreatenode' => null
	];
*/
	protected $initialized = false;


	function __construct( $params = [] ){



//		set_params( $this->config, $params );

	}

	protected function check_init(){
		if( $this->initialized == false ){
			throw new Exception('Nested sets object not initialized.');
		}
	}

	public function init( $table = null ){

		if( $table == null ){
			throw new exception('You must specify the table name.');
		}

		$this->table = $table;

		//if( $this->check_root() == false ){
		//	$this->create_root_node();
		//}

		// TODO Проверять существование таблицы.

		$this->initialized = true;

	}

	/**
	 * Метод проверяет существование root-записи (главной, первой).
	 *
	 * @return boolean
	 * 		true Запись существует.
	 * 		false Запись не существует.
	 */

	protected function check_root(&$root = null){

		$sql = 'SELECT * FROM ?t WHERE id = ?d';

		$root = app::$db->selrow( $sql, $this->table, $this->root['id'] );

		return !is_null( $root );

	}


	protected function create_root_node(){

		$sql = 'INSERT INTO ?t SET ?l';

		app::$db->ins( $sql, $this->table, $this->root );

	}

	/**
	 * @param string $name Название создаваемой таблицы для nested sets.
	 */
	public function create_table( $name = 'ns' ){

		$sql = 'CREATE TABLE IF NOT EXISTS `' . $name . '` (';
		$sql.= '`id` int(10) unsigned NOT NULL AUTO_INCREMENT,';
		$sql.= '`root_id` int(10) unsigned NOT NULL DEFAULT "0",';
		$sql.= '`left_id` int(10) unsigned NOT NULL DEFAULT "0",';
		$sql.= '`right_id` int(10) unsigned NOT NULL DEFAULT "0",';
		$sql.= '`parent_id` int(10) unsigned NOT NULL DEFAULT "0",';
		$sql.= '`level` int(10) unsigned NOT NULL DEFAULT "0",';
		$sql.= '`name` varchar(100) NOT NULL,';
		$sql.= 'PRIMARY KEY (`id`),';
		$sql.= 'KEY `root_id` (`root_id`),';
		$sql.= 'KEY `left_id` (`left_id`),';
		$sql.= 'KEY `right_id` (`right_id`),';
		$sql.= 'KEY `parent_id` (`parent_id`),';
		$sql.= 'KEY `level` (`level`),';
		$sql.= 'KEY `name` (`name`)';
		$sql.= ') ENGINE=InnoDB DEFAULT CHARSET=utf8;';

		app::$db->q( $sql );

		//	$this->create_root_node();

	}





	/**
	 * @param integer $node_id Код перемещаемого узла.
	 *
	 * @param integer $parent_id Код узла родителя. Если 0, но задан $adjacent_id, parent_id берётся от adjacent_node.
	 *
	 * @param integer $adjacent_id 	Код соседнего узла, до или после которого будет создан новый узел.
	 * 								Если соседний узел не указан, то новый узел добавляется в конце родительского узла.
	 * 								При указании $adjacent_id, $parent_id указывать необязательно.
	 *
	 * @param string $position 	Вариант добавления нового узла, перед или после $adjacent_id.
	 *
	 *              after
	 *              before
	 *              last
	 *              first
	 *
	 * @return boolean 	Исход операции.
	 * 					true Узел (ветка) успешно перемещён.
	 *
	 * TODO Перемещение узла или ветки с parent_id = 0 в пределах parent_id = 0.
	 * При это нужно менять root_id?! Нет root_id менять нельзя, так как соответствует id - верхней записи. Нужно
	 * разрулить эту ситуацию. Может быть стоит добавить поле для root'ов root_order.
	 *
	 *
	 * Не работает first и before, так как root_id не уменьшается для parent_id = 0
	 */
	public function move_node( $node_id, $parent_id = null, $position = 'last', $adjacent_id = null, $transaction = true ){

		if( $transaction == true ){
			app::$db->start();
		}

		try {


			if( in_array( $position, ['after','before','last','first'] ) == false ){
				$position = 'last';
			}

			$node_id = intval( $node_id );
			//$parent_id = intval( $parent_id );
			$adjacent_id = intval( $adjacent_id );

			$parent = [
				'id' => 0,
				'left_id' => 0,
				'right_id' => 1,
				'parent_id' => 0,
				'level' => -1
			];

			$adjacent_node = null;
			$node = null;

//			$root = null;

			$root_id = null;



			//
			// BEGIN Перемещаемый узел.
			//

			$sql = 'SELECT * FROM ?t WHERE id = ?d';

			$node = app::$db->selrow( $sql, $this->table, $node_id );

			if( $node == null ){

				throw new exception('The node (ID: ' . $node_id . ') not found.');

			}

			//print_r($node);
			//exit;

			//
			// END Перемещаемый узел.
			//


			//
			// BEGIN Получить узел для ориентированной вставки.
			//


			if( $adjacent_id > 0 ){

				// Закомментировал, так как parent_id может быть не установлен.
				//$sql = 'SELECT * FROM ?t WHERE id = ?d AND parent_id = ?d';
				//$adjacent_node = app::$db->selrow( $sql, $this->table, $adjacent_id, $parent_id );


				$sql = 'SELECT * FROM ?t WHERE id = ?d';
				$adjacent_node = app::$db->selrow( $sql, $this->table, $adjacent_id );

				//print_r($adjacent_node);

				if( $adjacent_node == null ){

					throw new exception('The adjacent node (ID: ' . $adjacent_id . ') not found.');

				}


				if( is_null( $parent_id ) == true && $adjacent_node['parent_id'] > 0 ){
					$parent_id = $adjacent_node['parent_id'];
				}


			}


			if( ( $position == 'after' || $position == 'before' ) && $adjacent_node == null ){

				throw new exception('The adjacent node (ID: ' . $adjacent_id . ') not found.');

			}


			if( $adjacent_id == 0 && is_null( $parent_id ) == true && $position != 'last' && $position != 'first' ){

				return false;

			}


			if( $adjacent_id == 0 && is_null( $parent_id ) == true && $node['parent_id'] > 0 && ( $position == 'last' || $position == 'first' ) ){

				$parent_id = $node['parent_id'];

			}




			// !!! Этот блок ДОЛЖЕН быть под node и adjacent_node.
			// BEGIN Получить родителя.
			//


			$parent_id = intval( $parent_id );

			if( $parent_id > 0 ){

				$sql = 'SELECT * FROM ?t WHERE id = ?d';

				$parent = app::$db->selrow( $sql, $this->table, $parent_id );

				if( $parent == null ){

					throw new exception('The parent node (ID: ' . $parent_id . ') not found.');

				}

				$root_id = $parent['root_id'];

			}




			if( $parent_id == 0 ){

				$root_id = app::$db->get_max_id( $this->table, 'root_id' );
				$root_id++;

			}

			//	print_r($parent);


			//
			// END Получить родителя.
			//





			//
			// END Получить узел для ориентированной вставки.
			//








/*
			echo 'СМЕЖНЫЙ УЗЕЛ<BR>';
			print_r($adjacent_node);
			echo '<BR>УЗЕЛ<br>';
			print_r($node);
			echo '<BR>РОДИТЕЛЬСКИЙ УЗЕЛ<br>';
			print_r($parent);
			echo '<br>ROOT ID: ' . $root_id . '<br>';
			echo 'PARENT ID: ' . $parent_id;
			*/



			//
			// BEGIN Проверка на замыкание.
			//

			if( $parent['left_id'] >= $node['left_id'] && $parent['right_id'] <= $node['right_id'] && $parent['root_id'] == $node['root_id'] ){

				// Попытка замкнуть узел на самого себя.
//				error_log( 'Trying to close node to itself.' );

				$trace = debug_backtrace();
				$warning_message = 'Trying to close node to itself.';
				$warning_message.= ' In ' . $trace[0]['file'];
				$warning_message.= ' on line ' . $trace[0]['line'];

				trigger_error( $warning_message, E_USER_WARNING );

				if( $transaction == true ){
					app::$db->rollback();
				}

				return false;

			}

			//
			// END Проверка на замыкание.
			//




			//
			// BEGIN Ориентир.
			//

			if( $position == 'before' ){

				$pos_id = $adjacent_node['left_id'];

			}
			else if( $position == 'after' ){

				$pos_id = $adjacent_node['right_id'];

			}
			else if( $position == 'last' ){

				$pos_id = $parent['right_id'];

			}
			else if( $position == 'first' ){

				$pos_id = $parent['left_id'];

			}



			//
			// END Ориентир.
			//


			//
			// BEGIN Вычисления.
			//

			$diff = $node['right_id'] - $node['left_id'] + 1;

			// Кол-во перемещаемых узлов.
			//$node_count = $diff / 2;

			// Перемещение влево (вверх).
			// $base - только для перемещаемого узла/ветки.
			if( $pos_id < $node['right_id'] ){

				if( $position == 'last' || $position == 'before' ){

					$base = $node['left_id'] - $pos_id;

				}
				else if( $position == 'first' || $position == 'after' ){

					$base = $node['left_id'] - $pos_id - 1;

				}

			// Перемещение вправо (вниз).
			}
			else if( $pos_id >= $node['right_id'] ){

				if( $position == 'last' || $position == 'before' ){

					$base = $pos_id - $node['left_id'];

				}
				else if( $position == 'first' || $position == 'after' ){

					$base = $pos_id - $node['left_id'] + 1;

				}

			}


			//
			// BEGIN Вычисление смещения уровня.
			//

			$diff_level = $parent['level'] - $node['level'] + 1;

			//
			// END Вычисление смещения уровня.
			//


			//
			// END Вычисления.
			//



			//
			// BEGIN Коды перемещаемых узлов.
			//

			$id_list = [];

			$sql = 'SELECT id FROM ?t WHERE left_id >= ?d AND right_id <= ?d AND root_id = ?d';

			$records = app::$db->sel( $sql, $this->table, $node['left_id'], $node['right_id'], $node['root_id'] );

			if( is_array( $records ) == true ){

				foreach( $records as $record ){
					$id_list[ $record['id'] ] = $record['id'];
				}

			}

		//	print_r($id_list);
			//exit;
			//app::cons($id_list);

			//
			// END Коды перемещаемых узлов.
			//





			//
			// BEGIN Изменить узлы между node и parent.
			//

			if( $node['root_id'] != $root_id ){


				//
				// BEGIN Корректировка корня-источника.
				//




				//
				// END Корректировка корня-источника.
				//


/*
				// Перемещение влево (вверх).
				if( $pos_id < $node['right_id'] ){


					//
					// BEGIN Изменение left_id.
					//

					if( $position == 'before' ){

						$sql = 'UPDATE ?t SET left_id = left_id + ?d WHERE left_id >= ?d AND left_id < ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET left_id = left_id + ?d WHERE left_id > ?d AND left_id < ?d AND root_id = ?d';

					}

					app::$db->q(
						$sql,
						$this->table,
						$diff,
						// WHERE
						$pos_id,
						$node['left_id'],
						$node['root_id']
					);

					//
					// END Изменение left_id.
					//


					//
					// BEGIN Изменение right_id.
					//

					if( $position == 'after' ){

						$sql = 'UPDATE ?t SET right_id = right_id + ?d WHERE right_id > ?d AND right_id < ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET right_id = right_id + ?d WHERE right_id >= ?d AND right_id < ?d AND root_id = ?d';

					}

					app::$db->q(
						$sql,
						$this->table,
						$diff,
						$pos_id,
						$node['left_id'],
						$node['root_id']
					);

					//
					// END Изменение right_id.
					//




				}
				// Перемещение вправо (вниз).
				else if( $pos_id > $node['right_id'] ){



					//
					// BEGIN Изменение left_id.
					//

					if( $position == 'before' ){

						$sql = 'UPDATE ?t SET left_id = left_id - ?d WHERE left_id > ?d AND left_id < ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET left_id = left_id - ?d WHERE left_id > ?d AND left_id <= ?d AND root_id = ?d';

					}



					app::$db->q(
						$sql,
						$this->table,
						$diff,
						// WHERE
						$node['right_id'],
						$pos_id,
						$node['root_id']
					);

					//
					// END Изменение left_id.
					//



					//
					// BEGIN Изменение right_id.
					//

					if( $position == 'after' ){

						$sql = 'UPDATE ?t SET right_id = right_id - ?d WHERE right_id <= ?d AND right_id > ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET right_id = right_id - ?d WHERE right_id < ?d AND right_id > ?d AND root_id = ?d';

					}

					app::$db->q(
						$sql,
						$this->table,
						$diff,
						$pos_id,
						$node['right_id'],
						$node['root_id']
					);

					//
					// END Изменение right_id.
					//


				}

*/

			}
			else {

				// Перемещение влево (вверх).
				if( $pos_id < $node['right_id'] ){


					//
					// BEGIN Изменение left_id.
					//

					if( $position == 'before' ){

						$sql = 'UPDATE ?t SET left_id = left_id + ?d WHERE left_id >= ?d AND left_id < ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET left_id = left_id + ?d WHERE left_id > ?d AND left_id < ?d AND root_id = ?d';

					}

					app::$db->q(
						$sql,
						$this->table,
						$diff,
						// WHERE
						$pos_id,
						$node['left_id'],
						$node['root_id']
					);

					//
					// END Изменение left_id.
					//


					//
					// BEGIN Изменение right_id.
					//

					if( $position == 'after' ){

						$sql = 'UPDATE ?t SET right_id = right_id + ?d WHERE right_id > ?d AND right_id < ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET right_id = right_id + ?d WHERE right_id >= ?d AND right_id < ?d AND root_id = ?d';

					}

					app::$db->q(
						$sql,
						$this->table,
						$diff,
						$pos_id,
						$node['left_id'],
						$node['root_id']
					);

					//
					// END Изменение right_id.
					//




				}
				// Перемещение вправо (вниз).
				else if( $pos_id > $node['right_id'] ){



					//
					// BEGIN Изменение left_id.
					//

					if( $position == 'before' ){

						$sql = 'UPDATE ?t SET left_id = left_id - ?d WHERE left_id > ?d AND left_id < ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET left_id = left_id - ?d WHERE left_id > ?d AND left_id <= ?d AND root_id = ?d';

					}



					app::$db->q(
						$sql,
						$this->table,
						$diff,
						// WHERE
						$node['right_id'],
						$pos_id,
						$node['root_id']
					);

					//
					// END Изменение left_id.
					//



					//
					// BEGIN Изменение right_id.
					//

					if( $position == 'after' ){

						$sql = 'UPDATE ?t SET right_id = right_id - ?d WHERE right_id <= ?d AND right_id > ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET right_id = right_id - ?d WHERE right_id < ?d AND right_id > ?d AND root_id = ?d';

					}

					app::$db->q(
						$sql,
						$this->table,
						$diff,
						$pos_id,
						$node['right_id'],
						$node['root_id']
					);

					//
					// END Изменение right_id.
					//


				}

			}

			//
			// END Изменить узлы между node и parent.
			//


			//
			// BEGIN Внести изменения в перемещаемый узел.
			//




			$data = [];

			// Если изменился родитель.
			if( $node['parent_id'] != $parent['id'] ){

				$data['parent_id'] = $parent['id'];

			}


			//app::cons($data);





			// Изменился root_id.
			// Закомментировано, так как обрабатывается в перемещаемой ветке.

			/*
			if( $node['root_id'] != $root_id ){

				$data['root_id'] = $root_id;

			}
			*/

			if( count( $data ) > 0 ){

				$sql = 'UPDATE ?t SET ?l WHERE id = ?d';

				app::$db->q( $sql, $this->table, $data, $node['id'] );

			}



			//
			// END Внести изменения в перемещаемый узел.
			//




			//
			// BEGIN Перемещаемая ветка.
			//

			if( count($id_list) > 0 ){

				if( $node['root_id'] != $root_id ){

				//	echo '<Br>POS: ' . $pos_id . '<br>';

					//app::cons('POS: ' . $pos_id );


					//
					// BEGIN Корректировка корня-приёмника.
					//

					//if( $parent_id > 0 ){

						$sql = 'UPDATE ?t SET left_id = left_id + ?d WHERE root_id = ?d AND left_id >= ?d';
						app::$db->q( $sql, $this->table, $diff, $root_id, $pos_id );

						if( $position == 'after' ){

							$sql = 'UPDATE ?t SET right_id = right_id + ?d WHERE root_id = ?d AND right_id > ?d';
							app::$db->q( $sql, $this->table, $diff, $root_id, $pos_id );

						}
						else{

							$sql = 'UPDATE ?t SET right_id = right_id + ?d WHERE root_id = ?d AND right_id >= ?d';
							app::$db->q( $sql, $this->table, $diff, $root_id, $pos_id );

						}




//					app::cons($node);
					//app::cons($root_id);


					//}

					//
					// END Корректировка корня-приёмника.
					//



					//
					// BEGIN Корректировка перемещаемых узлов.
					//

					if( $parent_id == 0 && $node['parent_id'] == $parent_id ){

						$sql = 'UPDATE ?t SET root_id = ?d WHERE id IN (?a)';
						app::$db->q( $sql, $this->table, $root_id, $id_list );

					}
					else {

//						app::cons($base . ',' . $pos_id);

						//app::cons($node);

						// Перемещение влево (вверх).
						if( $pos_id < $node['right_id'] ){

							$sql = 'UPDATE ?t SET level = level + ?d, left_id = left_id - ?d, right_id = right_id - ?d, root_id = ?d WHERE id IN (?a)';

							app::$db->q( $sql, $this->table, $diff_level, $base, $base, $root_id, $id_list );

						}
						// Перемещение вправо (вниз).
						else if( $pos_id >= $node['right_id'] ){

					//		echo 'ZZZ';

							$sql = 'UPDATE ?t SET level = level + ?d, left_id = left_id + ?d, right_id = right_id + ?d, root_id = ?d WHERE id IN (?a)';
							//app::$db->q( $sql, $this->table, $diff_level, ( $base - $diff ), ( $base - $diff ), $root_id, $id_list );
							app::$db->q( $sql, $this->table, $diff_level, $base, $base, $root_id, $id_list );


						}
						else {

							$sql = 'UPDATE ?t SET root_id = ?d WHERE id IN (?a)';
							app::$db->q( $sql, $this->table, $root_id, $id_list );



						}
					}



					//
					// END Корректировка перемещаемых узлов.
					//



					/*

					if( $parent_id == 0 && $node['parent_id'] == $parent_id ){

						$sql = 'UPDATE ?t SET root_id = ?d WHERE id IN (?a)';
						app::$db->q( $sql, $this->table, $root_id, $id_list );


					}
					else {



						//
						// BEGIN Корректировка корня-приёмника.
						//

						$sql = 'UPDATE ?t SET left_id = left_id + ?d WHERE root_id = ?d AND left_id >= ?d';
						app::$db->q( $sql, $this->table, $diff, $root_id, $pos_id );

						if( $position == 'after' ){

							$sql = 'UPDATE ?t SET right_id = right_id + ?d WHERE root_id = ?d AND right_id > ?d';
							app::$db->q( $sql, $this->table, $diff, $root_id, $pos_id );

						}
						else {

							$sql = 'UPDATE ?t SET right_id = right_id + ?d WHERE root_id = ?d AND right_id >= ?d';
							app::$db->q( $sql, $this->table, $diff, $root_id, $pos_id );

						}



						//
						// END Корректировка корня-приёмника.
						//


						//
						// BEGIN Корректировка перемещаемых узлов.
						//





						// Перемещение влево (вверх).
						if( $pos_id < $node['right_id'] ){
							$sql = 'UPDATE ?t SET level = level + ?d, left_id = left_id - ?d, right_id = right_id - ?d, root_id = ?d WHERE id IN (?a)';
							app::$db->q( $sql, $this->table, $diff_level, $base, $base, $root_id, $id_list );
						}
						else if( $pos_id > $node['right_id'] ){

							echo 'POS:' . $pos_id . '<br>';
							echo 'DIFF:' . $diff . '<br>';
							echo 'BASE:' . $base . '<br>';

							$sql = 'UPDATE ?t SET level = level + ?d, left_id = left_id + ?d, right_id = right_id + ?d, root_id = ?d WHERE id IN (?a)';
							app::$db->q( $sql, $this->table, $diff_level, $base, $base, $root_id, $id_list );


						}
						else {
							$sql = 'UPDATE ?t SET left_id = left_id + ?d, right_id = right_id + ?d, root_id = ?d WHERE id IN (?a)';
							app::$db->q( $sql, $this->table, $diff, $diff, $root_id, $id_list );
						}





						//
						// END Корректировка перемещаемых узлов.
						//




					}



					*/



					//
					// BEGIN Корректировка корня-источника.
					//

					if( $node['parent_id'] > 0 ){
						//app::cons('THERE');

						$sql = 'UPDATE ?t SET left_id = left_id - ?d WHERE root_id = ?d AND left_id > ?d';
						app::$db->q( $sql, $this->table, $diff, $node[ 'root_id' ], $node[ 'right_id' ] );
						//app::cons(app::$db->prepare_sql( $sql, $this->table, $diff, $node[ 'root_id' ], $node[ 'right_id' ] ));


						$sql = 'UPDATE ?t SET right_id = right_id - ?d WHERE root_id = ?d AND right_id > ?d';

						//app::cons(app::$db->prepare_sql( $sql, $this->table, $diff, $node[ 'root_id' ], $node[ 'right_id' ] ));

						//app::cons("END");
						app::$db->q( $sql, $this->table, $diff, $node[ 'root_id' ], $node[ 'right_id' ] );







					}

					//
					// END Корректировка корня-источника.
					//



				}
				else {

					// Перемещение влево (вверх).
					if( $pos_id < $node['right_id'] ){

						$sql = 'UPDATE ?t SET level = level + ?d, left_id = left_id - ?d, right_id = right_id - ?d WHERE id IN (?a)';

						app::$db->q( $sql, $this->table, $diff_level, $base, $base, $id_list );

					}
					// Перемещение вправо (вниз).
					else if( $pos_id > $node['right_id'] ){

						$sql = 'UPDATE ?t SET level = level + ?d, left_id = left_id + ?d, right_id = right_id + ?d WHERE id IN (?a)';

						app::$db->q( $sql, $this->table, $diff_level, ( $base - $diff ), ( $base - $diff ), $id_list );

					}

				}

			}

			//
			// END Перемещаемая ветка.
			//




		//	print_r(app::$db->queries);
		//	exit;

			if( $transaction == true ){
				app::$db->commit();
			}

			return true;

		}
		catch( exception $e ){

			if( $transaction == true ){
				app::$db->rollback();
			}

			return false;

		}

//		echo app::$db->affected_rows();




	}


	/**
	 * @param integer $parent_id Код узла родителя.
	 *
	 * @param integer $adjacent_id 	Код соседнего узла, до или после которого будет создан новый узел.
	 * 								Если соседний узел не указан, то новый узел добавляется в конце родительского узла.
	 * 								При указании $adjacent_id, $parent_id указывать необязательно.
	 *
	 *
	 * @param string $position 	Вариант добавления нового узла, перед или после $adjacent_id.
	 * 							first
	 * 							before
	 * 							after
	 * 							last
	 *
	 * @param array $extra_data Дополнительные данные для записи в таблицу.
	 *      $extra_data[ KEY ] = VALUE
	 *
	 * @return integer Код нового узла или false в случае ошибки.
	 */
	public function create_node( $parent_id = null, $position = 'after', $adjacent_id = null, $extra_data = [], $transaction = true, $db = null ){

		if( is_array( $extra_data ) == false ){
			$extra_data = [];
		}

		if( $db == null ){

			$db = app::$db;

		}


		$this->check_init();

		if( $transaction == true ){

			$db->start();

		}

		try {

			$parent_id = intval( $parent_id );
			$adjacent_id = intval( $adjacent_id );

			$root_id = null;

			$parent = [
				'left_id' => 0,
				'right_id' => 1,
				'parent_id' => 0,
				'level' => -1
			];


			$adjacent_node = null;

			//
			// BEGIN Получить родителя.
			//

			if( $parent_id > 0 ){

				$sql = 'SELECT * FROM ?t WHERE id = ?d';

				$parent = $db->selrow( $sql, $this->table, $parent_id );

				if( $parent == null ){

					throw new exception('The parent node (ID: ' . $parent_id . ') not found.');

				}

				$root_id = $parent['root_id'];

			}


			//
			// END Получить родителя.
			//

			//
			// BEGIN Получить узел для ориентированной вставки.
			//

			if( $adjacent_id > 0 ){

				$sql = 'SELECT * FROM ?t WHERE id = ?d AND parent_id = ?d';

				$adjacent_node = $db->selrow( $sql, $this->table, $adjacent_id, $parent_id );

				if( $adjacent_node == null ){

					throw new exception('The adjacent node (ID: ' . $adjacent_id . ') not found.');

				}

			}


			if( $adjacent_id > 0 && ( $position == 'after' || $position == 'before' ) && $adjacent_node == null ){

				throw new exception('The adjacent node (ID: ' . $adjacent_id . ') not found.');

			}


			//
			// END Получить узел для ориентированной вставки.
			//





			if( $position == 'before' || $position == 'first'){

				if( $adjacent_node != null ){

					$left_id = $adjacent_node['left_id'];
					$right_id = $parent['right_id'];

				}
				else{

					$left_id = $parent['left_id'];
					$right_id = $parent['right_id'];

				}

				if( $parent_id > 0 ){

					//
					// BEGIN Обновить нижестоящие узлы.
					//

					if( $adjacent_node != null ){

						$sql = 'UPDATE ?t SET left_id = left_id + 2, right_id = right_id + 2 WHERE left_id >= ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET left_id = left_id + 2, right_id = right_id + 2 WHERE left_id > ?d AND root_id = ?d';

					}

					$db->q( $sql, $this->table, $left_id, $root_id );

					//
					// END Обновить нижестоящие узлы.
					//


					//
					// BEGIN Обновление родительской ветки.
					//

					$sql = 'UPDATE ?t SET right_id = right_id + 2 WHERE right_id >= ?d AND left_id < ?d AND root_id = ?d';

					$db->q(
						$sql,
						$this->table,
						$right_id,
						$right_id,
						$root_id
					);

					//
					// END Обновление родительской ветки.
					//

				}


				//
				// BEGIN Вставка нового узла.
				//

				if( $adjacent_node != null ){

					$sql = 'INSERT INTO ?t SET';
					$sql.= ' level = ?d + 1,';
					$sql.= ' left_id = ?d,';
					$sql.= ' right_id = ?d + 1,';
					$sql.= ' parent_id = ?d';

				}
				else{

					$sql = 'INSERT INTO ?t SET';
					$sql.= ' level = ?d + 1,';
					$sql.= ' left_id = ?d + 1,';
					$sql.= ' right_id = ?d + 2,';
					$sql.= ' parent_id = ?d';

				}

				if( $root_id > 0 ){
					$sql.= ', root_id = ?d';
					$node_id = $db->ins( $sql, $this->table, $parent['level'], $left_id, $left_id, $parent['id'], $root_id );
				}
				else {
					$node_id = $db->ins( $sql, $this->table, $parent['level'], $left_id, $left_id, $parent['id'] );
					$sql = 'UPDATE ?t SET root_id = ?d WHERE id = ?d';
					$db->q( $sql, $this->table, $node_id, $node_id );
				}

				//
				// END Вставка нового узла.
				//

			}
			else if( $position == 'after' || $position == 'last' ){

				if( $adjacent_node != null ){

					$right_id = $adjacent_node['right_id'];

				}
				else{

					$right_id = $parent['right_id'];

				}


				if( $parent_id > 0 ){

					//
					// BEGIN Обновить нижестоящие (идущие справа родителя, после right_id) узлы.
					//

					if( $adjacent_node != null ){

						$sql = 'UPDATE ?t SET left_id = left_id + 2, right_id = right_id + 2 WHERE left_id > ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET left_id = left_id + 2, right_id = right_id + 2 WHERE left_id > ?d AND root_id = ?d';

					}

					$db->q( $sql, $this->table, $right_id, $root_id );


					//
					// END Обновить нижестоящие (идущие справа родителя, после right_id) узлы.
					//


					//
					// BEGIN Обновление родительской ветки.
					//

					if( $adjacent_node != null ){

						$sql = 'UPDATE ?t SET right_id = right_id + 2 WHERE right_id > ?d AND left_id < ?d AND root_id = ?d';

					}
					else{

						$sql = 'UPDATE ?t SET right_id = right_id + 2 WHERE right_id >= ?d AND left_id < ?d AND root_id = ?d';

					}

					$db->q(
						$sql,
						$this->table,
						$right_id,
						$right_id,
						$root_id
					);


					//
					// END Обновление родительской ветки.
					//

				}

				//
				// BEGIN Вставка нового узла.
				//

				if( $adjacent_node != null ){

					$sql = 'INSERT INTO ?t SET';
					$sql.= ' level = ?d + 1,';
					$sql.= ' left_id = ?d + 1,';
					$sql.= ' right_id = ?d + 2,';
					$sql.= ' parent_id = ?d';

				}
				else{

					$sql = 'INSERT INTO ?t SET';
					$sql.= ' level = ?d + 1,';
					$sql.= ' left_id = ?d,';
					$sql.= ' right_id = ?d + 1,';
					$sql.= ' parent_id = ?d';

				}


				if( $root_id > 0 ){
					$sql.= ', root_id = ?d';

					if( count( $extra_data ) > 0 ){
						$sql.= ', ?l';
						$node_id = $db->ins( $sql, $this->table, $parent['level'], $right_id, $right_id, $parent['id'], $root_id, $extra_data );
					}
					else {
						$node_id = $db->ins( $sql, $this->table, $parent['level'], $right_id, $right_id, $parent['id'], $root_id );
					}

				}
				else {
					if( count( $extra_data ) > 0 ){
						$sql.= ', ?l';
						$node_id = $db->ins( $sql, $this->table, $parent['level'], $right_id, $right_id, $parent['id'], $extra_data );
					}
					else {
						$node_id = $db->ins( $sql, $this->table, $parent['level'], $right_id, $right_id, $parent['id'] );
					}

					//
					// BEGIN Присвоить root_id.
					//


					$root_id = $db->get_max_id( $this->table, 'root_id' );
					$root_id++;

					$sql = 'UPDATE ?t SET root_id = ?d WHERE id = ?d';
					// $db->q( $sql, $this->table, $node_id, $node_id );
					$db->q( $sql, $this->table, $root_id, $node_id );

					//
					// END Присвоить root_id.
					//

				}




				//
				// END Вставка нового узла.
				//

			}


			//print_r($db->queries);
			//exit;
			if( $transaction == true ){
				$db->commit();
			}

			return $node_id;

		}
		catch( Exception $e ){


			if( $transaction == true ){
				$db->rollback();
			}

			return false;

		}

	}


	/**
	 * Удаляет записи по SQL-условию.
	 * Возвращает список удалённых узлов (коды) или пустой массив.
	 *
	 * @param $where
	 * @return bool
	 */
	public function delete_by_where( $where = null, $transaction = true ){

		$nodes = [];
		$deleted_nodes = [];

		$sql_where = app::$db->prepare_where( $where );

		if( $sql_where == '' ){
			return $deleted_nodes;
		}


		$sql = 'SELECT id FROM ?t ' . $sql_where;
		$records = app::$db->sel( $sql, $this->table );

		if( is_array( $records ) == true ){
			foreach( $records as $record ){
				$nodes[] = $record['id'];
			}
		}

		foreach( $nodes as $node_id ){
			$result = $this->delete_node( $node_id, $transaction );
			if( $result == true ){
				$deleted_nodes[] = $node_id;
			}
		}

		return $deleted_nodes;

	}


	public function delete_node( $id, $transaction = true ){

		if( $transaction == true ){
			app::$db->start();
		}

		try {

			$sql = 'SELECT * FROM ?t WHERE id = ?d';

			$node = app::$db->selrow( $sql, $this->table, $id );


			if( $node == null ){
				throw new exception('The node (ID: ' . $id . ') not found.');
			}



			//
			// BEGIN Удаление узла с подчинёнными записями.
			//

			$sql = 'DELETE FROM ?t WHERE left_id >= ?d AND right_id <= ?d AND root_id = ?d';

			app::$db->q( $sql, $this->table, $node['left_id'], $node['right_id'], $node['root_id'] );

			//
			// END Удаление узла с подчинёнными записями.
			//



			//
			// BEGIN Обновление родительской ветки.
			//

			$sql = 'UPDATE ?t SET right_id = right_id - (?d - ?d + 1) WHERE right_id > ?d AND left_id < ?d AND root_id = ?d';

			app::$db->q( $sql, $this->table, $node['right_id'], $node['left_id'], $node['right_id'], $node['left_id'], $node['root_id'] );

			//
			// END Обновление родительской ветки.
			//



			//
			// BEGIN Обновление последующих узлов
			//

			$sql = 'UPDATE ?t SET left_id = left_id - ( ?d - ?d + 1 ), right_id = right_id - (?d - ?d + 1) WHERE left_id > ?d AND root_id = ?d';
			app::$db->q( $sql, $this->table, $node['right_id'], $node['left_id'], $node['right_id'], $node['left_id'], $node['right_id'], $node['root_id'] );

			//
			// END Обновление последующих узлов
			//

			if( $transaction == true ){
				app::$db->commit();
			}

			return true;

		}
		catch( exception $e ){

			if( $transaction == true ){
				app::$db->rollback();
			}

			return false;

		}

	}


	/**
	 * Для отладки.
	 */
	public function test_view(){



		$records = app::$db->sel('SELECT * FROM ?t ORDER BY root_id ASC, left_id ASC', $this->table);


		$html = '';
//
	//	echo count($records);
	//	exit;

		foreach( $records as $record ){

			$html.= str_repeat('. ', $record['level']) . $record['id'] . ' <span style="color: #888888; font-size: 10px;">[' . $record['left_id'] . ',' . $record['right_id'] . ',parent_id: ' . $record['parent_id'] . ',root_id: ' . $record['root_id'] . ']</span><br />';

		}

		echo '<p>' . $html . '</p>';

	}



	protected function repair_helper( $records, $parent_id, $level, $root_id, $left_id ){

		global $ns_list;

		$tree = [];

		if( is_array( $records ) ){

			foreach( $records as $record ){

				if( $record['parent_id'] == $parent_id ){

					$record['root_id'] = ( $level == 0 ? $record['id'] : $root_id );
					$record['level'] = $level;

					$record['left_id'] = $left_id;

					$record['records'] = $this->repair_helper( $records, $record['id'], $level + 1, $record['root_id'], $left_id + 1 );

					if( count( $record['records'] ) > 0 ){
						$tmp = $record['records'];
						$tmp = array_pop( $tmp );
						$right_id = $tmp['right_id'] + 1;
					}
					else {
						$right_id = $left_id + 1;
					}

					$left_id = $right_id + 1;

					$record['right_id'] = $right_id;

					$tree[] = $record;

					$ns_list[] = $record;

				}

			}

		}

		return $tree;

	}



	/**
	 * Восстанавливает left_id, right_id, root_id, level по parent_id.
	 */
	public function repair( $table_name ){

		// TODO Переделать.
		global $ns_list;

		$sql = 'SELECT id, parent_id FROM ?t';

		$records = app::$db->sel( $sql, $table_name );

		$tree = $this->repair_helper( $records, 0, 0, 0, 1 );





//		$list = repair_ns( $table_name );

		if( is_array( $ns_list ) == true ){

			foreach( $ns_list as $item ){

				$sql = 'UPDATE ?t SET level = ?d, right_id = ?d, left_id = ?d, root_id = ?d WHERE id = ?d';
				app::$db->q( $sql, $table_name, $item['level'], $item['right_id'], $item['left_id'], $item['root_id'], $item['id'] );

			}

		}

	}

}

?>