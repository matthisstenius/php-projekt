<?php

namespace post\controller;

require_once("src/post/view/EditPost.php");

class EditPost {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var post\model\Post
	 */
	private $post;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 * @param post\model\Post         $post
	 * @param project\model\Project   $project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, \post\model\Post $post,
								\project\model\Project $project) {

		$this->postHandeler = $postHandeler;
		$this->post = $post;
		$this->project = $project;

		$this->navigationView = new \common\view\Navigation();

		$this->editPostView = new \post\view\EditPost($this->postHandeler, 
														$this->post,
														$this->navigationView,
														$this->project);
	}

	public function showEditPostForm() {
		return $this->editPostView->getEditPostForm();
	}

	public function editPost() {
		$this->editPostView->editPost();
	}
}