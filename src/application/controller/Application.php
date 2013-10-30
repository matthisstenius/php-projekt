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
require_once("src/login/controller/Logout.php");
require_once("src/register/controller/Register.php");

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

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	public function __construct() {
		$this->router = new \common\view\Router();

		$this->projectHandeler = new \project\model\ProjectHandeler();
		$this->postHandeler = new \post\model\PostHandeler();
		$this->userHandeler = new \user\model\UserHandeler();
		$this->loginHandeler = new \login\model\Login();

		$this->user = $this->loginHandeler->getLoggedInUser();

		$this->projectsController = new \project\controller\Projects($this->projectHandeler, $this->user);

		$this->loginController = new \login\controller\Login($this->userHandeler, $this->loginHandeler);
		$this->page = new \common\view\Page($this->loginHandeler, $this->projectsController);

		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * Main routing for the application
	 * @return void 
	 */
	public function init() {
		$this->projectRoutes();
		$this->postRoutes();
		$this->loginRoutes();
		$this->registerRoutes();
		$this->otherRoutes();

		$this->router->match();
	}

	private function projectRoutes() {
		$this->router->get('/projects', function() {
			$this->isAuthorized();

			echo $this->page->getPage("Projects", $this->projectsController->showProjects());
		});

		/**
	 	* GET Project
	 	*/
		$this->router->get('/project/:projectID/:projectName', function($projectID, $projectName) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());

				if ($cleanProjectName != $projectName) {
					$this->navigationView->goToProject($project->getProjectID(), $cleanProjectName);
				}

				$projectController = new \project\controller\Project($project);

				echo $this->page->getPage("Project title", $projectController->showProject(+$projectID, $projectName));	
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
	 	* GET Add new project
	 	*/
		$this->router->get('/newProject', function() {
			$this->isAuthorized();
			$newProjectController = new \project\controller\NewProject($this->projectHandeler, $this->user);

			echo $this->page->getPage("Add New Project", $newProjectController->showNewProjectForm());
		});

		/**
	 	* POST Add new project
	 	*/
		$this->router->post('/newProject', function() {
			$this->isAuthorized();
			$newProjectController = new \project\controller\NewProject($this->projectHandeler, $this->user);

			$newProjectController->addProject();
		});


		/**
	 	* GET Edit project
	 	*/
		$this->router->get('/edit/project/:projectID/:projectName', function($projectID, $projectName) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());

				if ($cleanProjectName != $projectName) {
					$this->navigationView->goToEditProject($project->getProjectID(), $cleanProjectName);
				}

				$editProjectController = new \project\controller\EditProject($this->projectHandeler, $project);

				echo $this->page->getPage("Edit $projectName", $editProjectController->showEditProjectForm());	
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
	 	* PUT Edit project
	 	*/
		$this->router->put('/edit/project/:projectID/:projectName', function($projectID, $projectName) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$editProjectController = new \project\controller\EditProject($this->projectHandeler, $project);

				$editProjectController->saveProject();
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}

		});

		/**
	 	* DELETE remove project
	 	*/
		$this->router->delete('/remove/project/:projectID', function($projectID) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$deleteProjectController = new \project\controller\DeleteProject($this->projectHandeler, $project);
				$deleteProjectController->deleteProject();
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}

		});
	}

	private function postRoutes() {
		/**
	 	* GET Post in Project
	 	*/
		$this->router->get('/project/:projectID/:projectName/post/:postID/:title', function($projectID, $projectName, $postID, $postTitle) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getProject(+$projectID);
				$post = $this->postHandeler->getPost(+$postID);

				$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());
				$cleanPostTitle = \common\view\Filter::getCleanUrl($post->getTitle());

				if ($cleanProjectName != $projectName || $cleanPostTitle != $postTitle) {
					$this->navigationView->goToPost($project->getProjectID(), $cleanProjectName,
													$post->getPostID(), $cleanPostTitle);
				}

				$projectController = new \project\controller\Project($project);

				echo $this->page->getPage("Post tile", $projectController->showProjectPost($post));	
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
	 	* GET add new post in project
	 	*/
		$this->router->get('/project/:projectID/:projectName/newPost', function($projectID, $projectName) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());

				if ($cleanProjectName != $projectName) {
					$this->navigationView->gotoNewPost($project->getProjectID(), $cleanProjectName);
				}

				$newPostController = new \post\controller\NewPost($this->postHandeler, $project);

				echo $this->page->getPage("Add new post", $newPostController->showNewPostForm());
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
	 	* POST add new post in project
	 	*/
		$this->router->post('/project/:projectID/:projectName/newPost', function($projectID, $projectName) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$newPostController = new \post\controller\NewPost($this->postHandeler, $project);

				$newPostController->addPost();
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
	 	* GET edit post in project
	 	*/
		$this->router->get('/project/:projectID/:projectName/edit/post/:postID/:postName', function($projectID, $projectName,
																								$postID, $postTitle) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getProject(+$projectID);
				$post = $this->postHandeler->getPost(+$postID);

				$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());
				$cleanPostTitle = \common\view\Filter::getCleanUrl($post->getTitle());

				if ($cleanProjectName != $projectName || $cleanPostTitle != $postTitle) {
					$this->navigationView->gotoEditPost($project->getProjectID(), $cleanProjectName,
													$post->getPostID(), $cleanPostTitle);
				}

				$editPostController = new \post\controller\EditPost($this->postHandeler, $post, $project);
				echo $this->page->getPage("Edit post", $editPostController->showEditPostForm());
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
	 	* PUT edit post in project
	 	*/
		$this->router->put('/project/:projectID/:projectName/edit/post/:postID/:postName', function($projectID, $projectName,
																									$postID, $postName) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getproject(+$projectID);
				$post = $this->postHandeler->getPost(+$postID);

				$editPostController = new \post\controller\EditPost($this->postHandeler, $post, $project);
				$editPostController->editPost();
			}

			catch (\Exception $e) {
				var_dump($e->getMessage());
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
		 * DELET Post in project
		 */
		$this->router->delete('/project/:projectID/:projectName/remove/post/:postID', function($projectID, $projectName,
																								$postID) {
			$this->isAuthorized();

			try {
				$project = $this->projectHandeler->getProject(+$projectID);
				$post = $this->postHandeler->getPost(+$postID);

				$deletePostController = new \post\controller\DeletePost($this->postHandeler, $post, $project);

				$deletePostController->deletePost();
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});
	}

	private function loginRoutes() {
		/**
		 * GET login page
		 */
		$this->router->get('/login', function() {
			echo $this->page->getPage("Login", $this->loginController->showLoginForm());
		});

		/**
		 * POST login
		 */
		$this->router->post('/login', function() {
			$this->loginController->login();
		});

		/**
		 * GET logout
		 */
		$this->router->get('/logout', function() {
			$logoutController = new \login\controller\Logout($this->userHandeler, $this->loginHandeler);
			$logoutController->logout();
		});
	}

	private function registerRoutes() {
		/**
		 * GET register page
		 */
		$this->router->get('/register', function() {
			$regissterController = new \register\controller\Register($this->loginHandeler, $this->userHandeler);
			
			echo $this->page->getPage("Register", $regissterController->showRegisterForm());
		});

		/**
		 * POST register
		 */
		$this->router->post('/register', function() {
			$regissterController = new \register\controller\Register($this->loginHandeler, $this->userHandeler);
			
			$regissterController->register();
		});
	}

	public function otherRoutes() {
		/**
	 	* GET FrontPage
	 	*/
		$this->router->get('/', function() {
			$this->isAuthorized();
			echo $this->page->getPage("Hello Blog!", "<h1>Hello world</h1>");
		});

		/**
	 	* GET 404 page
	 	* @todo Fix propper 404 page
	 	*/
		$this->router->notFound("/404", function() {
			echo  $this->page->getPage("404", "<h1>404 page not found</h1>");
		});

		/**
	 	* GET 500 page
	 	* @todo Fix propper 404 page
	 	*/
		$this->router->get("/500", function() {
			echo  $this->page->getPage("500", "<h1>Error 500 something went terrebly wrong!</h1>");
		});
	}

	private function isAuthorized() {
		$this->loginController->loginWithToken();

		if (!$this->loginHandeler->isUserLoggedIn()) {
			$this->navigationView->gotoLoginPage();
		}
	}
}