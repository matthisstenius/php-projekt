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
	 * @param int $projectID
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler, $projectID) {
		$this->projectHandeler = $projectHandeler;
		$this->navigationView = new \common\view\Navigation();

		try {
			$this->project = $this->projectHandeler->getProject($projectID);
		}

		catch (\Exception $e) {
			$this->navigationView->gotoErrorPage();
		}
	}

	/**
	 * @param  int $projectID
	 * @return void
	 */
	public function deleteProject() {
		$this->projectHandeler->deleteProject($this->project);
		$this->navigationView->gotoFrontPage();
	}
}