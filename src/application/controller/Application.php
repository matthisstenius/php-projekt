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

	public function __construct() {
		$this->router = new \common\view\Router();
		$this->page = new \common\view\Page();

		$this->projectHandeler = new \project\model\ProjectHandeler();
		$this->postHandeler = new \post\model\PostHandeler();

		$this->projectsController = new \project\controller\Projects($this->projectHandeler);
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
			echo $this->page->getPage("Hello Blog!", 
										$this->projectsController->showProjects());
		});

		/**
	 	* GET Project
	 	*/
		$this->router->get('/project/:projectID/:projectName', function($projectID, $projectName) {
			$projectController = new \project\controller\Project($this->projectHandeler);

			echo $this->page->getPage("Project title", 
										$this->projectsController->showProjects(), 
										$projectController->showProject(+$projectID, $projectName));
		});

		/**
	 	* GET Post in Project
	 	*/
		$this->router->get('/project/:projectID/:projectName/post/:postID/:title', function($projectID, $projectName, $postID, $title) {
			$projectController = new \project\controller\Project($this->projectHandeler);

			echo $this->page->getPage("Post tile", 
										$this->projectsController->showProjects(), 
										$projectController->showProjectPost(+$projectID, $projectName, +$postID, $title));
		});

		/**
	 	* GET Add new project
	 	*/
		$this->router->get('/newProject', function() {
			$newProjectController = new \project\controller\NewProject($this->projectHandeler);

			echo $this->page->getPage("Add New Project", 
										$this->projectsController->showProjects(),
										$newProjectController->showNewProjectForm());
		});

		/**
	 	* POST Add new project
	 	*/
		$this->router->post('/newProject', function() {
			$newProjectController = new \project\controller\NewProject($this->projectHandeler);

			$newProjectController->addProject();
		});


		/**
	 	* GET Edit project
	 	*/
		$this->router->get('/edit/project/:projectID/:projectName', function($projectID, $projectName) {
			$editProjectController = new \project\controller\EditProject($this->projectHandeler, $projectID);

			echo $this->page->getPage("Edit $projectName",
										$this->projectsController->showProjects(),
										$editProjectController->showEditProjectForm($projectName));
		});

		/**
	 	* PUT Edit project
	 	*/
		$this->router->put('/edit/project/:projectID/:projectName', function($projectID, $projectName) {
			$editProjectController = new \project\controller\EditProject($this->projectHandeler, $projectID);

			$editProjectController->saveProject(+$projectID, $projectName);
		});

		/**
	 	* DELETE remove project
	 	*/
		$this->router->delete('/remove/project/:projectID', function($projectID) {
			$deleteProjectController = new \project\controller\DeleteProject($this->projectHandeler, $projectID);
			$deleteProjectController->deleteProject();
		});

		/**
	 	* GET add new post in project
	 	*/
		$this->router->get('/project/:projectID/:projectName/newPost', function($projectID, $projectName) {
			$newPostController = new \post\controller\NewPost($this->postHandeler);

			echo $this->page->getPage("Add new post", 
										$this->projectsController->showProjects(),
										$newPostController->showNewPostForm($projectID, $projectName));
		});

		/**
	 	* POST add new post in project
	 	*/
		$this->router->post('/project/:projectID/:projectName/newPost', function($projectID, $projectName) {
			$newPostController = new \post\controller\NewPost($this->postHandeler);

			$newPostController->addPost(+$projectID, $projectName);
		});

		/**
	 	* GET edit post in project
	 	*/
		$this->router->get('/project/:projectID/:projectName/edit/post/:postID/:postName', function($projectID, $projectName,
																								$postID, $postName) {
			$editPostController = new \post\controller\EditPost($this->postHandeler, $postID);
			echo $this->page->getPage("Edit post", 
										$this->projectsController->showProjects(),
										$editPostController->showEditPostForm($projectID, $projectName));
		});

		/**
	 	* PUT edit post in project
	 	*/
		$this->router->put('/project/:projectID/:projectName/edit/post/:postID/:postName', function($projectID, $projectName,
																									$postID, $postName) {
			$editPostController = new \post\controller\EditPost($this->postHandeler, $postID);
			$editPostController->editPost($projectID, $projectName);
		});

		/**
	 	* GET 404 page
	 	* @todo Fix propper 404 page
	 	*/
		$this->router->notFound("/404", function() {
			echo  $this->page->getPage("404", $this->projects->showProjects(), "<h1>404 page not found</h1>");
		});

		$this->router->match();
	}
}