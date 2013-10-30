<?php

namespace project\controller;

require_once("src/project/view/Project.php");

class Project {
	/**
	 * @var project\model\Project
	 */
	private $project;

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
	public function __construct(\project\model\Project $project) {
		$this->project = $project;
		$this->projectView = new \project\view\Project($this->project);

		$this->postHandeler = new \post\model\PostHandeler();
		$this->postsController = new \post\controller\Posts($this->postHandeler, $this->project);
		$this->postController = new \post\controller\Post($this->postHandeler, $this->project);
	}

	/**
	 * @return string HTML
	 */
	public function showProject() {
		return $this->projectView->getProjectHTML($this->postsController->showPosts());
	}

	public function showProjectPost(\post\model\Post $post) {
		return $this->postController->showPost($post);
	}
}