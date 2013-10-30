<?php

namespace post\controller;

require_once("src/post/model/PostHandeler.php");
require_once("src/post/view/Posts.php");

class Posts {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var post\view\Post
	 */
	private $postsView;

	/**
	 * @param post\model\PostHandeler   $postHandeler
	 * @param project\model\Project 	$project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, \project\model\Project $project) {
		$this->postHandeler = $postHandeler;
		$this->project = $project;
		$this->postsView = new \post\view\Posts($this->postHandeler, $this->project);
	}

	/**
	 * @return string HTML
	 */
	public function showPosts() {
		return $this->postsView->getHTML();
	}
}