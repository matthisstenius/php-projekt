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
	 * @param project\model\Project $project
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler, \project\model\Project $project) {
		$this->projectHandeler = $projectHandeler;
		$this->project = $project;

		$this->navigationView = new \common\view\Navigation();

		$this->editProjectView = new \project\view\EditProject($this->projectHandeler, $this->project,
																$this->navigationView);		
	}

	/**
	 * @param  string $projectName
	 * @return string HTML
	 */
	public function showEditProjectForm() {
		return $this->editProjectView->getEditProjectForm();
	}

	public function saveProject() {
		$this->editProjectView->saveProject();
	}
}