<?php

namespace project\controller;

require_once("src/project/view/Project.php");

class Project {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @var project\view\Project
	 */
	private $projectView;

	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var post\controller\Post
	 */
	private $posts;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 */
	public function __construct(\project\model\projectHandeler $projectHandeler) {
		$this->projectHandeler = $projectHandeler;
		$this->projectView = new \project\view\Project($this->projectHandeler);
		$this->postHandeler = new \post\model\PostHandeler();
		$this->posts = new \post\controller\Posts($this->postHandeler);
		$this->post = new \post\controller\Post($this->postHandeler);
	}

	/**
	 * @return string HTML
	 */
	public function showProject($projectID, $name) {
		return $this->projectView->getProjectHTML($projectID, $name) . $this->posts->showPosts($projectID);
	}

	public function showProjectPost($id, $title) {
		return $this->post->showPost($id, $title);
	}
}