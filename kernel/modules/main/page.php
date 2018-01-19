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
 * Страница.
 *
 */
class Page {

	/**
	 * Числовой идентификатор.
	 */
//	public $id = 0;


	protected $breadcrumbs_prepared = false;

	/**
	 * Текстовый идентификатор.
	 */
//	public $name = '';


	/**
	 * Массив свойств (из БД).
	 * TODO rename to inner_data
	 */
	protected $properties = [];

	public $head = [];


	/**
	 * Массив для любых транзитных данных.
	 * Например для передачи данных от страницы к блокам.
	 */
	public $data = null;


	protected $extra_fields = null;


	/**
	 * Хлебные крошки страницы.
	 */
	public $bread_crumbs = [];


	/**
	 * Состояние, будет ли content обёрнут в шаблон.
	 */
	public $interface_state = true;


	/**
	 * Признак выполненности.
	 * Используется, когда сущность должна выполнятся только раз.
	 */
	protected $executed = false;



	/**
	 * Массив для хранения строк с javascript.
	 *
	 * $javascript['default'] = [];
	 * $javascript['my_javascript'] = [];
	 * $javascript[ $key ] = [];
	 *
	 * @var array
	 */
	protected $javascript = [];


	/**
	 * @param int $id
	 * @param bool|true $init Пришлось ввести на время инит из-за возникающей рекурсии, из-за prepare_breadcrumbs.
	 */
	public function __construct( $id = 0, $init = true ){


		if( $id > 0 ){

			$this->load( $id, $init );

		}


	}


	public function __set( $name, $value ){

		if( array_key_exists( $name, $this->properties ) == true ){

			$this->properties[ $name ] = $value;

		//	print_R($this->properties);

			return true;

		}



		throw new exception('The property "' . $name . '" is not exists in page object.');

		//return false;

	}

	public function __get( $name ){

		if ( array_key_exists( $name, $this->properties ) == true )
			return $this->properties[ $name ];

		throw new exception('The property "' . $name . '" is not exists in page object.');

		/*
		$trace = debug_backtrace();

		$message = 'Undefined property via __get(): ' . $name;
		$message.= ' in ' . $trace[0]['file'];
		$message.= ' on line ' . $trace[0]['line'];

		trigger_error( $message, E_USER_NOTICE );
		*/

		//return null;

	}





	/**
	 * Метод формирует массив $this->bread_crumbs из цепочки страниц,
	 * связанных подчинённостью.
	 * @todo Добавить получение конфига приложения, к которому принадлежит страница.
	 * @return bool false - в случае не удачи.
	 */
	protected function prepare_bread_crumbs(){

		$pages = $this->get_parents(true);

		$this->bread_crumbs = [];

		foreach( $pages as $page ){

			if( $page->breadcrumb_text != '' ){
				$str = $page->breadcrumb_text;
			}
			else if( $page->synonym != '' ){
				$str = $page->synonym;
			}
			else {
				$str = $page->title;
			}


			$url = $page->get_url();

			$this->bread_crumbs[] = [
				$str,
				$url,
				'text' => $str,
				'href' => $url,
			];

		}


	}




	/**
	 * Возможно многократное использование.
	 * @todo НЕТ. Запретить многократное использование. Для этого сервисы.
	 * Заменить require_once на require для многократного использования.
	 */
	public function execute(){

		$page_file = app::$config['dirs']['pages'] . '/' . $this->properties['file'];

		if( is_file( $page_file ) == true ){

			// Начать буферизацию вывода.
			ob_start();

			// Исполнение кода php-страницы.
			require( $page_file );

			// Получаем содержимое буфера.
			$this->content = ob_get_contents();

			// Очистка буфера.
			ob_end_clean();

		//	$this->content = '<div style="border:red solid 1px;">' . $this->content . '</div>';

		}
		else{
			// Файл страницы не найден.
			throw new exception('The page file is not found. ' . $page_file);
		}

	}


	public function get_url( $with_host = true ){

		return app::prepare_url( array( 'page_id' => $this->id ), $with_host );

	}



	// TODO $weight
	public function add_javascript( $js = '', $key = 'default', $weight = null ){

		$this->javascript[ $key ][] = $js;

	}

	public function get_javascript( $key = 'default' ){

		$js = '';

		if( array_key_exists( $key, $this->javascript ) == true ){
			$js = implode( "\n", $this->javascript[ $key ] );
		}



		return $js;

	}

	public function add_to_head( $string ){

		if( $string != '' ){
			$this->head[] = (string) $string;
		}

	}

	public function get_head(){

		return implode( '', $this->head );

	}

	public function field( $name ){

		$value = null;
		$name = mb_strtolower( $name );

		if( $this->structure_id > 0 ){

			if( $this->extra_fields == null ){

				$table_name = 'structure_data' . $this->structure_id;

				$sql = 'SELECT * FROM ?t WHERE record_type = ?d AND record_id = ?d';
				$row = app::$db->selrow( $sql, $table_name, 1, $this->id );

				$sql = 'SELECT * FROM structure_field WHERE structure_id = ?d';
				$fields = app::$db->sel( $sql, $this->structure_id );


				if( $fields != null ){

					foreach( $fields as $field ){

						$field_name = mb_strtolower( $field['name'] );
						$this->extra_fields[ $field_name ] = $row[ 'field_' . $field['id'] ];

					}

				}

			}


			if( array_key_exists( $name, $this->extra_fields ) == true ){
				$value = $this->extra_fields[ $name ];
			}


		}

		return $value;


	}

	public function get_related_pages( $sort_direction = 'asc' ){

		if( $sort_direction != 'asc' && $sort_direction != 'desc' ){

			$sort_direction = 'asc';

		}

		$dir = mb_strtoupper( $sort_direction );


		$sql = 'SELECT * FROM related_pages rp LEFT JOIN pages p ON p.id = rp.related_page_id WHERE rp.page_id = ?d ' . app::$db->prepare_order( 'rp.sort ' . $dir );

		$records = app::$db->sel( $sql, $this->id );

		$list = [];

		if( is_array( $records ) == true ) {

			foreach ( $records as $page ) {

			//	$page['edit_url'] = url_add_params( $this->get_url(), ['id' => $page['id'], 'action' => 'edit'] );

				$page['url'] = app::prepare_url( [
					'page_id' => $page['id']
				] );

				//$page['html_breadcrumbs'] = module_pages::prepare_bc( $page );

				$page['synonym'] = htmlspecialchars( ( $page['title'] != '' ? $page['title'] : $page['name'] ), ENT_QUOTES | ENT_SUBSTITUTE );

				$list[] = $page;

			}

		}

		return $list;

	}

	public function get_prev_page(){


	}

	public function get_next_page(){



	}

	public function get_tags(){


		$cache_id = 'page|' . $this->id . '|tags';

		$tags = cache::get( $cache_id );

		if( $tags === false ){

			$tags = [];

			$sql = 'SELECT t.*, u.url FROM tag t LEFT JOIN tag_record tr ON tr.tag_id = t.id LEFT JOIN url u ON u.id = t.url_id WHERE tr.page_id = ?d ORDER BY t.name ASC';

			$records = app::$db->sel( $sql, $this->id );

			if( is_array( $records ) == true ){

				foreach( $records as $record ){

					$tags[] = $record;

				}

			}

			cache::set( $cache_id, $tags );

		}


		return $tags;

	}


	/**
	 * Функция возвращает "цепочку страниц", массив с кодами страниц,
	 * которые отсортированны в соответствии с подчинённостью.
	 * @param bool|false $include_self
	 * @param bool|false $return_only_id
	 * @return Page[]
	 * @throws exception
	 */
	public function get_parents( $include_self = false, $return_only_id = false ){

		if( $include_self == true ){
			$sql = 'SELECT id FROM pages WHERE root_id = ?d AND left_id <= ?d AND right_id >= ?d ORDER BY left_id ASC';
		}
		else {
			$sql = 'SELECT id FROM pages WHERE root_id = ?d AND left_id < ?d AND right_id > ?d ORDER BY left_id ASC';
		}

		$list = [];
		$id_list = [];

		$records = app::$db->select_cache( $sql, $this->root_id, $this->left_id, $this->right_id );

		if( is_array( $records ) == true ){

			foreach( $records as $record ){

				$id_list[] = $record['id'];

			}

			if( $return_only_id == true ){

				$list = $id_list;

			}
			else {

				foreach( $id_list as $id ){

					$page = new Page($id,false);
					$list[] = $page;

				}

			}

		}

		return $list;

	}


	public function get_children( $return_as_object = false ){

		$list = [];

		$sql = 'SELECT * FROM pages WHERE parent_id = ?d ORDER BY left_id ASC';
		$records = app::$db->get_records( $sql, $this->id );

		foreach( $records as $record ){

			if( $return_as_object == true ){

				$page = new Page( $record['id'], false );
				$page->set_data( $record );

				$list[] = $page;

			}
			else {

				$list[] = $record;

			}


		}

		return $list;

	}


	protected function load( $id = 0, $init = true ){

		$sql = 'SELECT * FROM pages WHERE id = ?d';
		$row = app::$db->select_row_cache( $sql, $id );

		if( $row != null ){

			$this->properties = $row;

			// расформировать
			if( $init == true ){

				// Примечание: Если этот вызов закомментировать, то внутри кода страницы,
				// крошки будут недоступны через $this->bread_crumbs или app::$page->bread_crumbs.
				$this->prepare_bread_crumbs();

				// Если не указан шаблон.
				if( $this->properties['template'] == '' )
					$this->interface_state = false;

				// Учёт показа страницы (HIT).
				if( $this->properties['counter_state'] == 1 ){
					app::$db->q('UPDATE ?_pages SET counter = counter + 1 WHERE id = ?d', $this->id);
				}

				if( $this->properties['url_id'] > 0 ){

					$this->properties['sef_url'] = app::$db->select_row_cache('SELECT * FROM ?_url WHERE id = ?d', $this->properties['url_id']);
					$this->properties['sef_url']['data'] = @unserialize($this->properties['sef_url']['data']);

					$this->properties['url'] = $this->properties['sef_url']['url'];

				}



			}

		}


	}

	public function set_data( $data = null ){

		$this->properties = $data;

	}

	public function get_data(){

		return $this->properties;

	}

	public function get_breadcrumbs(){

		if( $this->breadcrumbs_prepared == false ){

			$this->prepare_bread_crumbs();

			$this->breadcrumbs_prepared = true;

		}

		return $this->bread_crumbs;

	}

}



?>