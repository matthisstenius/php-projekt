<?php

namespace post\controller;

require_once('src/post/view/Post.php');

class Post {
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
	private $postView;

	/**
	 * @param post\model\PostsHandeler $postHandeler
	 * @param project\model\Project $project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, \project\model\Project $project) {
		$this->postHandeler = $postHandeler;
		$this->project = $project;
		$this->postView = new \post\view\Post($this->postHandeler, $this->project);
	}

	/**
	 * @param  post\model\Post $post
	 * @return string HTML
	 */
	public function showPost(\post\model\Post $post) {
		return $this->postView->getPostHTML($post);

	}
}