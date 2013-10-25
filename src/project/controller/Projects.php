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
	 * @var project\view\projects
	 */
	private $projectView;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 */
	public function __construct(\project\model\projectHandeler $projectHandeler) {
		$this->projectHandeler = $projectHandeler;
		$this->projectsView = new \project\view\Projects($this->projectHandeler);
	}

	/**
	 * @return string HTML
	 */
	public function showProjects() {
		return $this->projectsView->getHTML();
	}
}