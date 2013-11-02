<?php

namespace project\controller;

require_once("src/project/view/Project.php");

class Project {
	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var array of post\model\Post
	 */
	private $posts;

	/**
	 * @var user\model\User
	 */
	private $user;

	/**
	 * @var project\view\Project
	 */
	private $projectView;

	/**
	 * @param project\model\Project $project
	 * @param array              	$posts   array of post\model\Post
	 * @param usermodelUser       	$user
	 */
	public function __construct(\project\model\Project $project,
								$posts,
								\user\model\User $user,
								$collaborators) {

		$this->project = $project;
		$this->posts = $posts;
		$this->user = $user;
		$this->collaborators = $collaborators;

		$this->projectView = new \project\view\Project($this->project, $this->posts, $this->collaborators);
	}

	/**
	 * @return string HTML
	 */
	public function showProject() {
		return $this->projectView->getProjectHTML();
	}
}