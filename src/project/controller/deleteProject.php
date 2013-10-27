<?php

namespace project\controller;

class DeleteProject {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler) {
		$this->projectHandeler = $projectHandeler;
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @param  int $projectID
	 * @return void
	 */
	public function deleteProject($projectID) {
		$this->projectHandeler->deleteProject($projectID);
		$this->navigationView->gotoFrontPage();
	}
}