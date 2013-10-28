<?php

namespace post\view;

class EditPost {
	private static $title = "title";
	private static $content = "content";
	private static $errorMessage = "post::view::EditPost::errorMessage";

	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var post\model\Post
	 */
	private $post;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 * @param post\model\Post $post
	 * @param common\view\Navigation $navigationView
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, \post\model\Post $post,
								\common\view\Navigation $navigationView) {
		
		$this->postHandeler = $postHandeler;
		$this->post = $post;

		$this->navigationView = $navigationView;
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return string HTML
	 */
	public function getEditPostForm($projectID, $projectName, $postTitle) {
		$cleanTitle = \common\view\Filter::getCleanUrl($this->post->getTitle());

		if ($cleanTitle != $postTitle) {
			$this->navigationView->gotoEditPost($projectID, $projectName, $this->post->getPostID(),
											$cleanTitle);
		}
		$fromAction = $this->navigationView->getEditPostSrc($projectID, $projectName, $this->post->getPostID(),
															$cleanTitle);

		$backToPostSrc = $this->navigationView->getPostLink($projectID, $projectName, $this->post->getPostID(),
															$cleanTitle);

		$html = "<h1>Add new post to project</h1>";

		if (isset($_SESSION[self::$errorMessage])) {
			$html .= $this->userInputFaulty();
			unset($_SESSION[self::$errorMessage]);
		}

		$postTitle = $this->post->getTitle();
		$postContent = $this->post->getContent();

		$html .= "<form class='pure-form pure-form-stacked' action='$fromAction' method='POST'>
					<input type='hidden' name='_method' value='put'>
					<input type='text' class='input-wide' id='" . self::$title . "' 
					name='" . self::$title . "' value='$postTitle'>

					<textarea class='input-wide input-content' id='" . self::$content . "' 
					name='" . self::$content . "'>$postContent</textarea>

					<button class='btn btn-add'>Save Post</button>
					<a href='$backToPostSrc' class='btn btn-remove'>Cancel</a>
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
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return void
	 */
	public function editPost($projectID, $projectName) {
		try {
			$post = new \post\model\Post($this->post->getPostID(), $this->getPostTitle(), $this->getPostContent(),
										 $this->post->getDateAdded(), $this->post->getUsername(),
										 $this->post->getProjectID(), $this->post->getUserID());
			
			$this->postHandeler->editPost($post);

			$this->navigationView->goToPost($post->getProjectID(), $projectName, $post->getPostID(), 
											\common\view\Filter::getCleanUrl($post->getTitle()));
		}

		catch (\Exception $e) {
			$this->setErrorMessageSession();
			$this->navigationView->gotoNewPost($projectID, $projectName);
		}
	}

	private function setErrorMessageSession() {
		$_SESSION[self::$errorMessage] = true;
	}

	/**
	 * @return string HTML
	 */
	private function userInputFaulty() {
		$errorMessage = "";

		if ($this->getPostTitle() == "") {
			$errorMessage .= "<p>Enter a post name</p>";
		}

		if ($this->getPostContent() == "") {
			$errorMessage .= "<p>Enter some content for your post</p>";
		}

		return $errorMessage;
	}
}