<?php

namespace application\controller;

require_once("src/common/view/Router.php");
require_once("src/common/view/Navigation.php");
require_once("src/project/model/ProjectHandeler.php");
require_once("src/project/controller/Projects.php");
require_once("src/post/controller/Posts.php");

class Application {
	/**
	 * @var \common\view\Router
	 */
	private $router;

	/**
	 * @var \common\view\Page
	 */
	private $page;

	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	public function __construct() {
		$this->router = new \common\view\Router();
		$this->page = new \common\view\Page();
		$this->projectHandeler = new \project\model\ProjectHandeler();
	}

	public function init() {		
		$this->router->get('/', function() {
			$projects = new \project\controller\Projects($this->projectHandeler);
			echo $this->page->getPage("Hello Blog!", $projects->showProjects());
		});

		$this->router->get('/post/:id/:title', function($id, $title) {
			$post = new \post\controller\Post($this->postHandeler);
			echo $this->page->getPage("Post tile", $post->showPost(+$id, $title));
		});

		$this->router->notFound("/404", function() {
			echo  "404";
		});

		$this->router->match();
	}
}