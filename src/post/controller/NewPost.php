<?php

namespace post\controller;

require_once("src/post/view/NewPost.php");

class NewPost {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var user\model\User
	 */
	private $user;

	/**
	 * @var post\view\NewPost
	 */
	private $newPostView;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, \user\model\User $user) {
		$this->postHandeler = $postHandeler;
		$this->user = $user;
		$this->newPostView = new \post\view\NewPost($this->postHandeler, $this->user);
	}

	/**
	 * @param int $projectID
	 * @param string $projectName
	 * @return string HTML
	 */
	public function showNewPostForm($projectID, $projectName) {
		return $this->newPostView->getNewPostForm($projectID, $projectName);
	}

	/**
	 * @param int $projectID
	 * @param string $projectName
	 */
	public function addPost($projectID, $projectName) {
		$this->newPostView->addPost($projectID, $projectName);
	}
}