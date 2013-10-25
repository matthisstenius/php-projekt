<?php

namespace project\view;

class Projects {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler) {
		$this->projectHandeler = $projectHandeler;
	}

	public function getHTML() {
		$html = "<ul class='projects-list'>";

		foreach ($this->projectHandeler->getProjects() as $project) {
			$html .= "<li><a href='project/" . $project->getProjectID() . "/" . $project->getCleanName() . "'>" 
					 . $project->getName() . "</a></li>";

		}

		$html .= "</ul>";

		return $html;
	}
}