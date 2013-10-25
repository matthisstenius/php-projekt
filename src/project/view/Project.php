<?php

namespace project\view;

class Project {
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
	 * @param  int $id
	 * @return string HTML
	 */
	public function getProjectHTML($id, $title) {
		try {
			$project = $this->projectHandeler->getProject($id);

			if ($project->getCleanName() != $title) {
				$this->navigationView->goToProject($id, $project->getCleanName());
			}

			$html = "<h1 class='title'>" . $project->getName() . "</h1>";
			$html .= "<p>" . $project->getUsername() . "</p>";
			$html .= "<p>" . $project->getDescription() . "</p>";
			$html .= "<span class='date'>" . $project->getDateCreated() . "</span>";
		}

		catch (\Exception $e) {
			$html = "No project found!";
		}

		return $html;
	}
}