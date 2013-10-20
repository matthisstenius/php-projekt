<?php

namespace application\controller;

require_once("src/common/view/Router.php");
require_once("src/post/model/Posts.php");
require_once("src/post/controller/Post.php");
require_once("src/post/controller/Posts.php");

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

	/**
	 * @var post\model
	 */
	public $postsModel;

	public function __construct() {
		$this->router = new \common\view\Router();
		$this->page = new \common\view\Page();
		$this->postsModel = new \post\model\Posts();
	}

	public function init() {
		$self = $this;
		
		$this->router->get('/', function() use($self) {
			$posts = new \post\controller\Posts($self->postsModel);
			echo $self->page->getPage("Hello Blog!", $posts->showPosts());
		});

		$this->router->get('/post/:id/:title', function($id, $title) use($self) {
			$post = new \post\controller\Post($self->postsModel);
			echo $self->page->getPage("Post tile", $post->showPost(+$id));
		});

		$this->router->notFound("/404", function() use($self) {
			echo  "404";
		});

		$this->router->match();
	}
}