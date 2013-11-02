<?php

namespace application\controller;

require_once("src/common/view/Router.php");
require_once("src/common/view/Navigation.php");
require_once("src/project/model/ProjectHandeler.php");
require_once("src/post/model/PostHandeler.php");
require_once("src/comment/model/CommentHandeler.php");
require_once("src/collaborator/model/CollaboratorHandeler.php");
require_once("src/project/controller/Projects.php");
require_once("src/project/controller/Project.php");
require_once("src/project/controller/NewProject.php");
require_once("src/project/controller/EditProject.php");
require_once("src/project/controller/DeleteProject.php");
require_once("src/post/controller/Post.php");
require_once("src/post/controller/NewPost.php");
require_once("src/post/controller/EditPost.php");
require_once("src/post/controller/DeletePost.php");
require_once("src/login/controller/Login.php");
require_once("src/user/model/UserHandeler.php");
require_once("src/user/model/SimpleUser.php");
require_once("src/login/model/Login.php");
require_once("src/login/controller/Logout.php");
require_once("src/register/controller/Register.php");
require_once("src/user/controller/UserProfile.php");
require_once("src/user/controller/DeleteUser.php");
require_once("src/comment/controller/NewComment.php");
require_once("src/comment/controller/EditComment.php");
require_once("src/comment/controller/DeleteComment.php");
require_once("src/collaborator/controller/Collaborators.php");
require_once("src/collaborator/controller/DeleteCollaborator.php");
require_once("src/collaborator/model/SimpleCollaborator.php");

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
		$this->commentHandeler = new \comment\model\CommentHandeler();
		$this->loginHandeler = new \login\model\Login();
		$this->collaboratorHandeler = new \collaborator\model\CollaboratorHandeler();

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
		$this->commentRoutes();
		$this->collaboratorRoutes();
		$this->loginRoutes();
		$this->registerRoutes();
		$this->userRoutes();
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
			try {
				$project = $this->projectHandeler->getProject(+$projectID);
				$collaborators = $this->collaboratorHandeler->getCollaborators($project);

				if ($project->isPrivate() && !$project->isCollaborator($collaborators)) {	
					$this->isAuthorized(new \user\model\SimpleUser($project->getUserID(), $project->getUsername()));
				}

				$posts = $this->postHandeler->getPosts($project);

				$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());

				if ($cleanProjectName != $projectName) {
					$this->navigationView->goToProject($project->getProjectID(), $cleanProjectName);
				}

				$projectController = new \project\controller\Project($project, $posts, $this->user, $collaborators);

				echo $this->page->getPage("Project title", $projectController->showProject());	
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
	 	* GET Add new project
	 	*/
		$this->router->get('/new/project', function() {
			$this->isAuthorized();
			$newProjectController = new \project\controller\NewProject($this->projectHandeler, $this->user);

			echo $this->page->getPage("Add New Project", $newProjectController->showNewProjectForm());
		});

		/**
	 	* POST Add new project
	 	*/
		$this->router->post('/new/project', function() {
			$this->isAuthorized();
			$newProjectController = new \project\controller\NewProject($this->projectHandeler, $this->user);

			$newProjectController->addProject();
		});


		/**
	 	* GET Edit project
	 	*/
		$this->router->get('/edit/project/:projectID/:projectName', function($projectID, $projectName) {
			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$this->isAuthorized(new \user\model\SimpleUser($project->getUserID(), $project->getUsername()));

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
			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$this->isAuthorized(new \user\model\SimpleUser($project->getUserID(), $project->getUsername()));

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
			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$this->isAuthorized(new \user\model\SimpleUser($project->getUserID(), $project->getUsername()));

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
			try {
				$project = $this->projectHandeler->getProject(+$projectID);
				$collaborators = $this->collaboratorHandeler->getCollaborators($project);

				if ($project->isPrivate() && !$project->isCollaborator($collaborators)) {
					$this->isAuthorized(new \user\model\SimpleUser($project->getUserID(), $project->getUsername()));
				}

				$post = $this->postHandeler->getPost(+$postID);
				$comments = $this->commentHandeler->getComments($post);

				$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());
				$cleanPostTitle = \common\view\Filter::getCleanUrl($post->getTitle());

				if ($cleanProjectName != $projectName || $cleanPostTitle != $postTitle) {
					$this->navigationView->goToPost($project->getProjectID(), $cleanProjectName,
													$post->getPostID(), $cleanPostTitle);
				}

				$postController = new \post\controller\Post($project,
															$post,
															$this->user,
															$comments);


				echo $this->page->getPage("Post tile", $postController->showPost());	
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
	 	* GET add new post in project
	 	*/
		$this->router->get('/project/:projectID/:projectName/new/post', function($projectID, $projectName) {
			try {
				$project = $this->projectHandeler->getProject(+$projectID);
				$collaborators = $this->collaboratorHandeler->getCollaborators($project);

				if (!$project->isCollaborator($collaborators)) {
					$this->isAuthorized(new \user\model\SimpleUser($project->getUserID(), $project->getUsername()));
				}

				$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());

				if ($cleanProjectName != $projectName) {
					$this->navigationView->gotoNewPost($project->getProjectID(), $cleanProjectName);
				}

				$newPostController = new \post\controller\NewPost($this->postHandeler, $project, $this->user);

				echo $this->page->getPage("Add new post", $newPostController->showNewPostForm());
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});

		/**
	 	* POST add new post in project
	 	*/
		$this->router->post('/project/:projectID/:projectName/new/post', function($projectID, $projectName) {
			try {
				$project = $this->projectHandeler->getProject(+$projectID);
				$collaborators = $this->collaboratorHandeler->getCollaborators($project);

				if (!$project->isCollaborator($collaborators)) {
					$this->isAuthorized(new \user\model\SimpleUser($project->getUserID(), $project->getUsername()));
				}

				$newPostController = new \post\controller\NewPost($this->postHandeler, $project, $this->user);

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
			try {
				$project = $this->projectHandeler->getProject(+$projectID);
				$post = $this->postHandeler->getPost(+$postID);

				$this->isAuthorized(new \user\model\SimpleUser($post->getUserID(), $post->getUsername()));

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

			try {
				$project = $this->projectHandeler->getproject(+$projectID);
				$post = $this->postHandeler->getPost(+$postID);

				$this->isAuthorized(new \user\model\SimpleUser($post->getUserID(), $post->getUsername()));

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
			try {
				$project = $this->projectHandeler->getProject(+$projectID);
				$post = $this->postHandeler->getPost(+$postID);

				$this->isAuthorized(new \user\model\SimpleUser($post->getUserID(), $post->getUsername()));

				$deletePostController = new \post\controller\DeletePost($this->postHandeler, $post, $project);

				$deletePostController->deletePost();
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
			
		});
	}

	private function commentRoutes() {
		$this->router->post('/project/:projectID/:projectName/post/:postID/:postName/comment', function($projectID, 
																										$projectName,
																										$postID,
																										$postName) {
			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$this->isAuthorized();

				$post = $this->postHandeler->getPost(+$postID);

				$newCommentController = new \comment\controller\NewComment($post, $project, $this->user);

				$newCommentController->addComment();
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}
		});

		$this->router->get("project/:projectID/:projectName/post/:postID/:postName/edit/comment/:commentID", 
							function($projectID, $projectName, $postID, $postName, $commentID) {

			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$post = $this->postHandeler->getPost(+$postID);
				$comments = $this->commentHandeler->getComments($post);
				$comment = $this->commentHandeler->getComment(+$commentID);

				$this->isAuthorized(new \user\model\SimpleUser($comment->getUserID(), $comment->getUsername()));

				$postController = new \post\controller\Post($project,
															$post,
															$this->user,
															$comments);

				echo $this->page->getPage("Edit comment", $postController->showPostWithEditComment($comment));
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}

		});

		$this->router->put("project/:projectID/:projectName/post/:postID/:postName/edit/comment/:commentID", 
							function($projectID, $projectName, $postID, $postName, $commentID) {

			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$post = $this->postHandeler->getPost(+$postID);
				$comment = $this->commentHandeler->getComment(+$commentID);

				$this->isAuthorized(new \user\model\SimpleUser($comment->getUserID(), $comment->getUsername()));

				$editCommentController = new \comment\controller\EditComment($post, $project, $this->user);

				$editCommentController->editComment($comment);
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}

		});

		$this->router->delete("project/:projectID/:projectName/post/:postID/:postName/comment/:commentID", 
							function($projectID, $projectName, $postID, $postName, $commentID) {

			try {
				$project = $this->projectHandeler->getProject(+$projectID);

				$post = $this->postHandeler->getPost(+$postID);
				$comment = $this->commentHandeler->getComment(+$commentID);

				$this->isAuthorized(new \user\model\SimpleUser($comment->getUserID(), $comment->getUsername()));

				$deleteCommentController = new \comment\controller\DeleteComment($comment, 
																				 $this->commentHandeler,
																				 $project,
																				 $post);

				$deleteCommentController->deleteComment();
			}

			catch (\Exception $e) {
				$this->navigationView->gotoErrorPage();
			}

		});

	}

	private function collaboratorRoutes() {
		$this->router->get('/project/:projectID/:projectName/collaborators', function($projectID, $projectName) {
			try {
				$project = $this->projectHandeler->getproject(+$projectID);
				$users = $this->userHandeler->getUsers();
				$collaborators = $this->collaboratorHandeler->getCollaborators($project);

				$collaboratorsController = new \collaborator\controller\Collaborators($collaborators,
																						$project,
																						$this->collaboratorHandeler,
																						$users);

				echo $this->page->getPage("collaborators", $collaboratorsController->showCollaborators());
			}

			catch (\Exception $e) {
				var_dump($e->getMessage());
			}
		});

		$this->router->post('/project/:projectID/:projectName/collaborators', function($projectID, $projectName) {
			try {
				$project = $this->projectHandeler->getproject(+$projectID);
				$users = $this->userHandeler->getUsers();
				$collaborators = $this->collaboratorHandeler->getCollaborators($project);

				$collaboratorsController = new \collaborator\controller\Collaborators($collaborators,
																						$project,
																						$this->collaboratorHandeler,
																						$users);
				$collaboratorsController->addCollaborator();
			}

			catch (\Exception $e) {
				var_dump($e->getMessage());
			}
		});

		$this->router->delete('/project/:projectID/:projectName/remove/collaborator/:collaboratorID', function($projectID,
																												$projectName,
																												$collaboratorID) {

			$project = $this->projectHandeler->getProject(+$projectID);
			$collaborator = new \collaborator\model\SimpleCollaborator(+$collaboratorID);

			$deleteCollaboratorController = new \collaborator\controller\DeleteCollaborator($collaborator,
																							$this->collaboratorHandeler,
																							$project);
			$deleteCollaboratorController->DeleteCollaborator();
		});
	}

	private function userRoutes() {
		$this->router->get('/user/:userID/:username', function($userID, $username) {
			$this->isAuthorized();

			$userprofileController = new \user\controller\UserProfile($this->user);
			echo $this->page->getPage("$username 's profile", $userprofileController->showUserProfile());
		});

		$this->router->delete('/remove/user/:userID/:username', function($userID, $username) {
			$deleteUserContoller = new \user\controller\DeleteUser($this->user, $this->loginHandeler);
			$deleteUserContoller->deleteUser();
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

	/**
	 * @param  user\model\User  $user
	 * @return void
	 */
	private function isAuthorized(\user\model\User $user = null) {
		$this->loginController->loginWithToken();

		if ($user != null) {
			if (!$this->loginHandeler->isSameUser($user)) {
				$this->navigationView->gotoProjects();
				exit;
			}	
		}
		

		if (!$this->loginHandeler->isUserLoggedIn()) {
			$this->navigationView->gotoLoginPage();
			exit;
		}
	}
}