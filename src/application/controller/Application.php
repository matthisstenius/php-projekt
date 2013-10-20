<?php

namespace application\controller;

require_once("src/common/view/Router.php");
require_once("src/post/view/Post.php");
require_once("src/post/controller/Post.php");

class Application {
	/**
	 * @var \common\view\Router
	 */
	private $router;

	/**
	 * @var \common\view\Page
	 * @todo  stinks.. Should be private
	 */
	public $page;

	public function __construct() {
		$this->router = new \common\view\Router();
		$this->page = new \common\view\Page();
	}

	public function init() {
		$self = $this;
		
		$this->router->get('/', function() use($self) {
			$posts = new \post\controller\Post();
			echo $self->page->getPage("Hello Blog!", $posts->showPosts());
		});

		$this->router->get('/contact/:name', function($name) use($self) {
			echo "Hello $name";
		});

		$this->router->notFound("/404", function() use($self) {
			echo  "404";
		});

		$this->router->match();
	}
}