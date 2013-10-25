<?php

namespace project\view;

class Projects {
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

	public function getHTML() {
		$html = "<ul class='projects-list'>";

		foreach ($this->projectHandeler->getProjects() as $project) {
			$link = $this->navigationView->getProjectLink($project->getProjectID(), $project->getCleanName(), $project->getName());
			$html .= "<li>$link</li>";

		}

		$html .= "</ul>";

		return $html;
	}
}