<?php

namespace application\controller;

require_once("src/common/view/Router.php");
require_once("src/common/view/Navigation.php");
require_once("src/project/model/ProjectHandeler.php");
require_once("src/project/controller/Projects.php");
require_once("src/project/controller/Project.php");
require_once("src/project/controller/NewProject.php");
require_once("src/project/controller/EditProject.php");
require_once("src/project/controller/DeleteProject.php");
require_once("src/post/controller/Posts.php");
require_once("src/post/controller/Post.php");
require_once("src/post/controller/NewPost.php");
require_once("src/post/controller/EditPost.php");

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
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

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

	/**
	 * @var project\controller\EditProject
	 */
	private $editProjectController; 

	/**
	 * @var project\controller\DeleteProject
	 */
	private $deleteProjectController;

	/**
	 * @var post\controller\NewPost
	 */
	private $newPostController;

	public function __construct() {
		$this->router = new \common\view\Router();
		$this->page = new \common\view\Page();

		$this->projectHandeler = new \project\model\ProjectHandeler();
		$this->postHandeler = new \post\model\PostHandeler();

		$this->projectsController = new \project\controller\Projects($this->projectHandeler);
		$this->projectController = new \project\controller\Project($this->projectHandeler);
		$this->newProjectController = new \project\controller\NewProject($this->projectHandeler);
		$this->editProjectController = new \project\controller\EditProject($this->projectHandeler);
		$this->deleteProjectController = new \project\controller\DeleteProject($this->projectHandeler);

		$this->newPostController = new \post\controller\NewPost($this->postHandeler);
	}

	public function init() {		
		$this->router->get('/', function() {
			echo $this->page->getPage("Hello Blog!", 
										$this->projectsController->showProjects());
		});

		$this->router->get('/project/:projectID/:projectName', function($projectID, $projectName) {
			echo $this->page->getPage("Project title", 
										$this->projectsController->showProjects(), 
										$this->projectController->showProject(+$projectID, $projectName));
		});

		$this->router->get('/project/:projectID/:projectName/post/:postID/:title', function($projectID, $projectName, $postID, $title) {
			echo $this->page->getPage("Post tile", 
										$this->projectsController->showProjects(), 
										$this->projectController->showProjectPost(+$projectID, $projectName, +$postID, $title));
		});

		$this->router->get('/newProject', function() {
			echo $this->page->getPage("Add New Project", 
										$this->projectsController->showProjects(),
										$this->newProjectController->showNewProjectForm());
		});

		$this->router->post('/newProject', function() {
			$this->newProjectController->addProject();
		});

		$this->router->get('/edit/project/:projectID/:projectName', function($projectID, $projectName) {
			echo $this->page->getPage("Edit $projectName",
										$this->projectsController->showProjects(),
										$this->editProjectController->showEditProjectForm(+$projectID, $projectName));
		});

		$this->router->put('/edit/project/:projectID/:projectName', function($projectID, $projectName) {
			$this->editProjectController->saveProject(+$projectID, $projectName);
		});

		$this->router->delete('/remove/project/:projectID', function($projectID) {
			$this->deleteProjectController->deleteProject(+$projectID);
		});

		$this->router->get('/project/:projectID/:projectName/newPost', function($projectID, $projectName) {
			echo $this->page->getPage("Add new post", 
										$this->projectsController->showProjects(),
										$this->newPostController->showNewPostForm($projectID, $projectName));
		});

		$this->router->post('/project/:projectID/:projectName/newPost', function($projectID, $projectName) {
			$this->newPostController->addPost(+$projectID, $projectName);
		});

		$this->router->get('/project/:projectID/:projectName/edit/post/:postID/:postName', function($projectID, $projectName,
																								$postID, $postName) {
			$editPostController = new \post\controller\EditPost($this->postHandeler, $postID);
			echo $this->page->getPage("Edit post", 
										$this->projectsController->showProjects(),
										$editPostController->showEditPostForm($projectID, $projectName));
		});

		$this->router->put('/project/:projectID/:projectName/edit/post/:postID/:postName', function($projectID, $projectName,
																									$postID, $postName) {
			$editPostController = new \post\controller\EditPost($this->postHandeler, $postID);
			$editPostController->editPost($projectID, $projectName);
		});

		$this->router->notFound("/404", function() {
			echo  "404";
		});

		$this->router->match();
	}
}