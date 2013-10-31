<?php

namespace project\controller;

require_once("src/project/view/Project.php");

class Project {
	/**
	 * @var project\model\Project
	 */
	private $project;

	private $post;

	private $user;
	/**
	 * @var project\view\Project
	 */
	private $projectView;

	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var post\controller\Posts
	 */
	private $postsController;

	/**
	 * @var post\controller\Post
	 */
	private $postController;

	/**
	 * @param project\model\Project $project
	 */
	public function __construct(\project\model\Project $project,
								\post\model\Post $post,
								\user\model\User $user) {

		$this->project = $project;
		$this->post = $post;
		$this->user = $user;

		$this->projectView = new \project\view\Project($this->project);

		$this->postHandeler = new \post\model\PostHandeler();
		$this->postsController = new \post\controller\Posts($this->postHandeler, $this->project);
		$this->postController = new \post\controller\Post($this->postHandeler, 
														  $this->project,
														  $this->post,
														  $this->user);
	}

	/**
	 * @return string HTML
	 */
	public function showProject() {
		return $this->projectView->getProjectHTML($this->postsController->showPosts());
	}

	public function showProjectPost() {
		return $this->postController->showPost();
	}
}