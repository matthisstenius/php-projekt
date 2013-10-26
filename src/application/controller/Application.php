<?php

namespace application\controller;

require_once("src/common/view/Router.php");
require_once("src/common/view/Navigation.php");
require_once("src/project/model/ProjectHandeler.php");
require_once("src/project/controller/Projects.php");
require_once("src/project/controller/Project.php");
require_once("src/project/controller/NewProject.php");
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
	 * @var project\controller\Projects
	 */
	private $projectsController;

	/**
	 * @var project\controller\Project
	 */
	private $projectController;

	/**
	 * @var project\controller\NewProject
	 */
	private $newProjectController; 

	public function __construct() {
		$this->router = new \common\view\Router();
		$this->page = new \common\view\Page();
		$this->projectHandeler = new \project\model\ProjectHandeler();

		$this->projectsController = new \project\controller\Projects($this->projectHandeler);
		$this->projectController = new \project\controller\Project($this->projectHandeler);
		$this->newProjectController = new \project\controller\NewProject($this->projectHandeler);
	}

	public function init() {		
		$this->router->get('/', function() {
			echo $this->page->getPage("Hello Blog!", 
										$this->projectsController->showProjects());
		});

		$this->router->get('/project/:projectID/:name', function($projectID, $name) {
			echo $this->page->getPage("Project title", 
										$this->projectsController->showProjects(), 
										$this->projectController->showProject(+$projectID, $name));
		});

		$this->router->get('/project/:projectID/post/:postID/:title', function($projectID, $postID, $title) {
			echo $this->page->getPage("Post tile", 
										$this->projectsController->showProjects(), 
										$this->projectController->showProjectPost(+$projectID, +$postID, $title));
		});

		$this->router->get('/newProject', function() {
			echo $this->page->getPage("Add New Project", 
										$this->projectsController->showProjects(),
										$this->newProjectController->showNewProjectForm());
		});

		$this->router->post('/newProject', function() {
			$this->newProjectController->addProject();
		});

		$this->router->notFound("/404", function() {
			echo  "404";
		});

		$this->router->match();
	}
}