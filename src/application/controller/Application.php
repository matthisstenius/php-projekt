<?php

namespace application\controller;

require_once("src/common/view/Router.php");
require_once("src/post/model/PostHandeler.php");
require_once("src/post/controller/Post.php");
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
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	public function __construct() {
		$this->router = new \common\view\Router();
		$this->page = new \common\view\Page();
		$this->postHandeler = new \post\model\PostHandeler();
	}

	public function init() {
		$self = $this;
		
		$this->router->get('/', function() {
			$posts = new \post\controller\Posts($this->postHandeler);
			echo $this->page->getPage("Hello Blog!", $posts->showPosts());
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