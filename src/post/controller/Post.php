<?php

namespace post\controller;

require_once("src/post/model/Posts.php");

class Post {
	/**
	 * @var post\modelPosts
	 */
	private $posts;

	/**
	 * @var post\view\Post
	 */
	private $postView;

	public function __construct() {
		$this->posts = new \post\model\Posts();
		$this->postView = new \post\view\Post($this->posts);
	}

	/**
	 * @return string HTML
	 */
	public function showPosts() {
		return $this->postView->getHTML();
	}
}