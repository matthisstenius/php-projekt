<?php

namespace project\controller;

require_once("src/project/model/ProjectHandeler.php");
require_once("src/project/view/Projects.php");

class Projects {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @var user\model\User
	 */
	private $user;
	
	/**
	 * @var project\view\Projects
	 */
	private $projectsView;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 * @param user\model\User $user
	 */
	public function __construct(\project\model\projectHandeler $projectHandeler, \user\model\User $user) {
		$this->projectHandeler = $projectHandeler;
		$this->user = $user;

		$this->projectsView = new \project\view\Projects($this->projectHandeler, $this->user);
	}

	/**
	 * @return string HTML
	 */
	public function showProjectsList() {
		return $this->projectsView->getProjectsList();
	}

	/**
	 * @return string HTML
	 */
	public function showProjects() {
		return $this->projectsView->getprojects();
	}
}