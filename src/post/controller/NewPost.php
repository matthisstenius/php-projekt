<?php

namespace post\controller;

require_once("src/post/view/NewPost.php");

class NewPost {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var post\view\NewPost
	 */
	private $newPostView;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 * @param project\model\Project $project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, \project\model\Project $project) {
		$this->postHandeler = $postHandeler;
		$this->project = $project;

		$this->newPostView = new \post\view\NewPost($this->postHandeler, $this->project);
	}

	/**
	 * @return string HTML
	 */
	public function showNewPostForm() {
		return $this->newPostView->getNewPostForm();
	}

	/**
	 * @return void
	 */
	public function addPost() {
		$this->newPostView->addPost();
	}
}