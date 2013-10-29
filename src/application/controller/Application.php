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
require_once("src/post/controller/DeletePost.php");
require_once("src/login/controller/Login.php");
require_once("src/user/model/UserHandeler.php");
require_once("src/login/model/Login.php");

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
	 * @var user\model\UserHandeler
	 */
	private $userHandeler;

	/**
	 * @var project\controller\Projects
	 */
	private $projectsController;

	public function __construct() {
		$this->router = new \common\view\Router();

		$this->projectHandeler = new \project\model\ProjectHandeler();
		$this->postHandeler = new \post\model\PostHandeler();
		$this->userHandeler = new \user\model\UserHandeler();
		$this->loginHandeler = new \login\model\Login();
		$this->projectsController = new \project\controller\Projects($this->projectHandeler);

		$this->page = new \common\view\Page($this->loginHandeler, $this->projectsController);
	}

	/**
	 * Main routing for the application
	 * @return void 
	 */
	public function init() {
		
		/**
	 	* GET FrontPage
	 	*/
		$this->router->get('/', function() {
			//$this->isAuthorized();
			echo $this->page->getPage("Hello Blog!");
		});

		/**
	 	* GET Project
	 	*/
		$this->router->get('/project/:projectID/:projectName', function($projectID, $projectName) {
			$this->isAuthorized();
			$projectController = new \project\controller\Project($this->projectHandeler);

			echo $this->page->getPage("Project title", $projectController->showProject(+$projectID, $projectName));
		});

		/**
	 	* GET Post in Project
	 	*/
		$this->router->get('/project/:projectID/:projectName/post/:postID/:title', function($projectID, $projectName, $postID, $title) {
			$this->isAuthorized();
			$projectController = new \project\controller\Project($this->projectHandeler);

			echo $this->page->getPage("Post tile", $projectController->showProjectPost(+$projectID, $projectName, +$postID, $title));
		});

		/**
	 	* GET Add new project
	 	*/
		$this->router->get('/newProject', function() {
			$this->isAuthorized();
			$newProjectController = new \project\controller\NewProject($this->projectHandeler);

			echo $this->page->getPage("Add New Project", $newProjectController->showNewProjectForm());
		});

		/**
	 	* POST Add new project
	 	*/
		$this->router->post('/newProject', function() {
			$this->isAuthorized();
			$newProjectController = new \project\controller\NewProject($this->projectHandeler);

			$newProjectController->addProject();
		});


		/**
	 	* GET Edit project
	 	*/
		$this->router->get('/edit/project/:projectID/:projectName', function($projectID, $projectName) {
			$this->isAuthorized();
			$editProjectController = new \project\controller\EditProject($this->projectHandeler, $projectID);

			echo $this->page->getPage("Edit $projectName", $editProjectController->showEditProjectForm($projectName));
		});

		/**
	 	* PUT Edit project
	 	*/
		$this->router->put('/edit/project/:projectID/:projectName', function($projectID, $projectName) {
			$this->isAuthorized();
			$editProjectController = new \project\controller\EditProject($this->projectHandeler, $projectID);

			$editProjectController->saveProject(+$projectID, $projectName);
		});

		/**
	 	* DELETE remove project
	 	*/
		$this->router->delete('/remove/project/:projectID', function($projectID) {
			$this->isAuthorized();
			$deleteProjectController = new \project\controller\DeleteProject($this->projectHandeler, $projectID);
			$deleteProjectController->deleteProject();
		});

		/**
	 	* GET add new post in project
	 	*/
		$this->router->get('/project/:projectID/:projectName/newPost', function($projectID, $projectName) {
			$this->isAuthorized();
			$newPostController = new \post\controller\NewPost($this->postHandeler);

			echo $this->page->getPage("Add new post", $newPostController->showNewPostForm(+$projectID, $projectName));
		});

		/**
	 	* POST add new post in project
	 	*/
		$this->router->post('/project/:projectID/:projectName/newPost', function($projectID, $projectName) {
			$this->isAuthorized();
			$newPostController = new \post\controller\NewPost($this->postHandeler);

			$newPostController->addPost(+$projectID, $projectName);
		});

		/**
	 	* GET edit post in project
	 	*/
		$this->router->get('/project/:projectID/:projectName/edit/post/:postID/:postName', function($projectID, $projectName,
																								$postID, $postName) {
			$this->isAuthorized();
			$editPostController = new \post\controller\EditPost($this->postHandeler, $postID);
			echo $this->page->getPage("Edit post", $editPostController->showEditPostForm($projectID, $projectName, $postName));
		});

		/**
	 	* PUT edit post in project
	 	*/
		$this->router->put('/project/:projectID/:projectName/edit/post/:postID/:postName', function($projectID, $projectName,
																									$postID, $postName) {
			$this->isAuthorized();
			$editPostController = new \post\controller\EditPost($this->postHandeler, $postID);
			$editPostController->editPost($projectID, $projectName);
		});

		$this->router->delete('/project/:projectID/:projectName/remove/post/:postID', function($projectID, $projectName,
																								$postID) {
			$this->isAuthorized();
			$deletePostController = new \post\controller\DeletePost($this->postHandeler, $postID);

			$deletePostController->deletePost(+$projectID, $projectName);
		});

		$this->router->get('/login', function() {
			$loginController = new \login\controller\Login($this->userHandeler, $this->loginHandeler);

			echo $this->page->getPage("Login", $loginController->showLoginForm());
		});

		$this->router->post('/login', function() {
			$loginController = new \login\controller\Login($this->userHandeler, $this->loginHandeler);

			$loginController->login();
		});

		/**
	 	* GET 404 page
	 	* @todo Fix propper 404 page
	 	*/
		$this->router->notFound("/404", function() {
			echo  $this->page->getPage("404", "<h1>404 page not found</h1>");
		});

		$this->router->match();
	}

	public function isAuthorized() {
		if (!$this->loginHandeler->isUserLoggedIn()) {
				$navigationView = new \common\view\Navigation();
				$navigationView->gotoLoginPage();
		}
	}
}