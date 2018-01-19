<?

class MainController extends Controller {

	protected $actions = [
		'second_page'
	];


	public function second_page(){

		app::load_module('form','kernel');

		require_once( app::$config['dirs']['includes'] . '/form1.php' );

		$vars = [];

		$form = new Form1();

		$vars['form1_html'] = $form->get_html();
//		echo $vars['form1_html'];exit;

		$html = app::$tpl->fetch( '2.phtml', $vars );

		$vars = [];

		$vars['h1'] = 'Вторая страница';
		$vars['title'] = 'Вторая страница на фреймворке';
		$vars['content'] = $html;
		$vars['template'] = 'page.phtml';

		$vars['breadcrumbs'] = [];

		$vars['breadcrumbs'][] = [
			'text' => 'Главная страница',
			'href' => '/',
		];

		$vars['breadcrumbs'][] = [
			'text' => 'Вторая страница',
			'href' => '/my-second-page/',
		];


		$this->view( 'default.php', $vars );

	}


	// Действие по умолчанию. В $actions - не указывается.
	public function main(){

		$vars = [];

		$html = app::$tpl->fetch( '1.phtml', $vars );

		$vars = [];

		$vars['h1'] = 'Первая страница';
		$vars['title'] = 'Сайт на фреймворке';
		$vars['content'] = $html;
		$vars['template'] = 'page.phtml';

		$this->view( 'default.php', $vars );

	}


	public function init(){

	}

}

?>