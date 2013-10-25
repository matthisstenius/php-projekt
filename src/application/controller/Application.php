<?php

namespace application\controller;

require_once("src/common/view/Router.php");
require_once("src/common/view/Navigation.php");
require_once("src/project/model/ProjectHandeler.php");
require_once("src/project/controller/Projects.php");
require_once("src/project/controller/Project.php");
require_once("src/post/controller/Posts.php");
require_once("src/post/controller/Post.php");

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

	/**
	 * @var array of project\model\Project
	 */
	private $projectsController; 

	public function __construct() {
		$this->router = new \common\view\Router();
		$this->page = new \common\view\Page();
		$this->projectHandeler = new \project\model\ProjectHandeler();
		$this->projectsController = new \project\controller\Projects($this->projectHandeler);
		$this->projectController = new \project\controller\Project($this->projectHandeler);
	}

	public function init() {		
		$this->router->get('/', function() {
			echo $this->page->getPage("Hello Blog!", 
										$this->projectsController->showProjects());
		});

		$this->router->get('/project/:id/:name', function($id, $name) {
			echo $this->page->getPage("Project title", 
										$this->projectsController->showProjects(), 
										$this->projectController->showProject(+$id, $name));
		});

		$this->router->get('/project/:projectID/post/:postID/:title', function($projectID, $postID, $title) {
			echo $this->page->getPage("Post tile", 
										$this->projectsController->showProjects(), 
										$this->projectController->showProjectPost(+$projectID, +$postID, $title));
		});

		$this->router->notFound("/404", function() {
			echo  "404";
		});

		$this->router->match();
	}
}