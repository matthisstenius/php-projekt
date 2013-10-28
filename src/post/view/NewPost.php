<?php

namespace post\view;

require_once("src/post/model/NewPost.php");

class NewPost {
	private static $title = "title";
	private static $content = "content";
	private static $errorMessage = "post::view::errorMessage";

	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 */
	public function __construct(\post\model\PostHandeler $postHandeler) {
		$this->postHandeler = $postHandeler;
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return string HTML
	 */
	public function getNewPostForm($projectID, $projectName) {
		$fromAction = $this->navigationView->getNewPostSrc($projectID, $projectName);
		$html = "<h1>Add new post to $projectName</h1>";

		if (isset($_SESSION[self::$errorMessage])) {
			$html .= $this->userInputFaulty();
			unset($_SESSION[self::$errorMessage]);
		}

		$html .= "<form class='pure-form pure-form-stacked' action='$fromAction' method='POST'>
					<input type='text' class='input-wide' id='" . self::$title . "' 
					name='" . self::$title . "' placeholder='Title'>

					<textarea class='input-wide input-content' id='" . self::$content . "' 
					name='" . self::$content . "'></textarea>

					<button class='btn btn-add'>Save Post</button>
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
	 * @param int $projectID
	 * @param string $projectName
	 * @return void
	 */
	public function addPost($projectID, $projectName) {
		try {
			$post = new \post\model\NewPost($this->getPostTitle(), $this->getPostContent(), \Date('y-m-d'), $projectID, 3);
			$this->postHandeler->addPost($post);

			$this->navigationView->goToPost($post->getProjectID(), $projectName, $post->getPostID(), 
											$post->getCleanTitle());
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