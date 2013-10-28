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
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 * @param int $projectID
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler, $projectID) {
		$this->projectHandeler = $projectHandeler;
		$this->navigationView = new \common\view\Navigation();

		try {
			$this->project = $this->projectHandeler->getProject($projectID);
			$this->editProjectView = new \project\view\EditProject($this->projectHandeler, $this->project,
																	$this->navigationView);
		}

		catch (\Exception $e) {
			$this->navigationView->gotoErrorPage();
		}
		
	}

	/**
	 * @param  string $projectName
	 * @return string HTML
	 */
	public function showEditProjectForm($projectName) {
		return $this->editProjectView->getEditProjectForm($projectName);
	}

	public function saveProject($projectID, $projectName) {
		$this->editProjectView->saveProject($projectID, $projectName);
	}
}