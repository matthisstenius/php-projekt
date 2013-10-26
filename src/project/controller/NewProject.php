<?php

namespace project\controller;

require_once("src/project/view/NewProject.php");

class NewProject {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler) {
		$this->projectHandeler = $projectHandeler;
		$this->newProjectView = new \project\view\NewProject($this->projectHandeler);
	}

	/**
	 * @return string HTML
	 */
	public function showNewProjectForm() {
		return $this->newProjectView->getNewProjectForm();
	}

	public function addProject() {
		$this->newProjectView->addProject();
	}
}