<?php

namespace project\controller;

class DeleteProject {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

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
	}

	/**
	 * @return void
	 */
	public function deleteProject() {
		$this->projectHandeler->deleteProject($this->project);
		$this->navigationView->gotoProjects();
	}
}