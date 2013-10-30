<?php

namespace project\view;

class Projects {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @var user\model\User
	 */
	private $user;
	
	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 * @param user\model\User $user
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler, \user\model\User $user) {
		$this->projectHandeler = $projectHandeler;
		$this->user = $user;
		$this->navigationView = new \common\view\Navigation();
	}

	public function getHTML() {
		$html = "<ul class='projects-list'>";

		foreach ($this->projectHandeler->getProjects($this->user) as $project) {
			$cleanName = \common\view\Filter::getCleanUrl($project->getName());
			$link = $this->navigationView->getProjectSrc($project->getProjectID(), $cleanName);
			$html .= "<li><a href='$link'>" . $project->getName() . "</a></li>";

		}

		$html .= "</ul>";

		return $html;
	}
}