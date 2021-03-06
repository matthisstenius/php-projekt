<?php

namespace post\view;

class NewPost {
	private static $title = "title";
	private static $content = "content";
	private static $userInputFaultyMessage = "post::view::userInputFaultyMessage";
	private static $savePostTitle = "post::view::savePostTitle";

	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var user\model\User
	 */
	private $user;
	
	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 * @param project\model\Project $project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, 
								\project\model\Project $project,
								\user\model\User $user) {

		$this->postHandeler = $postHandeler;
		$this->project = $project;
		$this->user = $user;

		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return string HTML
	 */
	public function getNewPostForm() {
		$cleanProjectName = \common\view\Filter::getCleanUrl($this->project->getName());

		$fromAction = $this->navigationView->getNewPostSrc($this->project->getProjectID(),
							 								$cleanProjectName);

		$backToProjectSrc = $this->navigationView->getProjectSrc($this->project->getProjectID(),
							 									$cleanProjectName);

		$html = "<h1 class='new-title'>Add new post to " . $this->project->getName() . "</h1>";

		if (isset($_SESSION[self::$userInputFaultyMessage])) {
			$html .= $_SESSION[self::$userInputFaultyMessage];
			unset($_SESSION[self::$userInputFaultyMessage]);
		}

		$postTitle = "";

		if (isset($_SESSION[self::$savePostTitle])) {
			$postTitle = $_SESSION[self::$savePostTitle];
			unset($_SESSION[self::$savePostTitle]);
		}

		$html .= "<form class='pure-form pure-form-stacked' action='$fromAction' method='POST'>
					<input type='text' class='input-wide' id='" . self::$title . "' 
					name='" . self::$title . "' placeholder='Title' value='$postTitle'>

					<textarea class='input-wide input-content' id='" . self::$content . "' 
					name='" . self::$content . "'></textarea>

					<button class='btn btn-add'>Save Post</button>
					<a href='$backToProjectSrc' class='btn btn-remove'>Cancel</a>
				</form>";

		return $html;
	}

	/**
	 * @return string Clean string
	 */
	private function getPostTitle() {
		if (isset($_POST[self::$title])) {
			return \common\view\Filter::clean($_POST[self::$title]);
		}

		return "";
	}

	/**
	 * @return string Clean string
	 */
	private function getPostContent() {
		if (isset($_POST[self::$content])) {
			return \common\view\Filter::clean($_POST[self::$content]);
		}

		return "";
	}

	/**
	 * @return void
	 */
	public function addPost() {
		try {
			$post = new \post\model\Post(0, $this->getPostTitle(), 
											$this->getPostContent(),
											$this->user->getUserID(),
											$this->user->getUsername(),
											\Date('y-m-d'),
											$this->project->getProjectID()
											);

			$this->postHandeler->addPost($post);

			$this->navigationView->goToPost($post->getProjectID(), 
											\common\view\Filter::getCleanUrl($this->project->getName()),
										 	$post->getPostID(), 
											\common\view\Filter::getCleanUrl($post->getTitle()));
		}

		catch (\Exception $e) {
			$this->userInputFaulty();
			$this->savePostTitle();
			$this->navigationView->gotoNewPost($this->project->getProjectID(),
												\common\view\Filter::getCleanUrl($this->project->getName()));
		}
	}

	private function savePostTitle() {
		$_SESSION[self::$savePostTitle] = $this->getPostTitle();
	}

	/**
	 * @return string HTML
	 */
	private function userInputFaulty() {
		$errorMessage = "";

		if ($this->getPostTitle() == "") {
			$errorMessage .= "<p>Enter a post name.</p>";
		}

		if (strlen($this->getPostTitle()) > 45) {
			$errorMessage .= "<p>Post title to long. Max 45 charachters allowed.</p>";
		}

		if (preg_match('/[^\wåäöÅÄÖ\s()?!]+/', $this->getPostTitle())) {
			$errorMessage .= "<p>Invalid charachters in post title. Only alphanumeric charachters and ()?! allowed.</p>";
		}

		if (strlen($this->getPostContent()) > 2000) {
			$errorMessage .= "<p>Post content to long. Max 2000 charachters allowed.</p>";
		}

		if ($this->getPostContent() == "") {
			$errorMessage .= "<p>Enter some content for your post.</p>";
		}

		$_SESSION[self::$userInputFaultyMessage] = $errorMessage;
	}
}