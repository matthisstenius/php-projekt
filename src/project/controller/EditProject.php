<?php

namespace project\controller;

require_once("src/project/view/EditProject.php");

class EditProject {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @var project\view\EditProject
	 */
	private $editProjectView;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler) {
		$this->projectHandeler = $projectHandeler;
		$this->editProjectView = new \project\view\EditProject($this->projectHandeler);
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return string HTML
	 */
	public function showEditProjectForm($projectID, $projectName) {
		return $this->editProjectView->getEditProjectForm($projectID, $projectName);
	}

	public function saveProject($projectID, $projectName) {
		$this->editProjectView->saveProject($projectID, $projectName);
	}
}