<?php

namespace project\controller;

require_once("src/project/view/NewProject.php");

class NewProject {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @var user\model\User
	 */
	private $user;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 * @param user\model\User $user
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler, \user\model\User $user) {
		$this->projectHandeler = $projectHandeler;
		$this->user = $user;
		$this->newProjectView = new \project\view\NewProject($this->projectHandeler, $this->user);
	}

	/**
	 * @return string HTML
	 */
	public function showNewProjectForm() {
		return $this->newProjectView->getNewProjectForm();
	}

	public function addProject() {
		$newProject = $this->newProjectView->addProject();
	}
}