<?php

namespace application\view;

class FrontPage {
	/**
	 * @var array of project\model\Project
	 */
	private $projects;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param arrau $projects array of project\model\Project
	 */
	public function __construct($projects) {
		$this->projects = $projects;
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return string HTML
	 */
	public function getPublicProjects() {
		$html = "<div class='centered'>";

		$html .= "<h1>Recent Public Projects</h1>";

		$html .= "<div class='box recent-projects'>";
		$html .= "<ul>";
		foreach ($this->projects as $project) {
			$created = \common\view\Filter::formatDate($project->getDateCreated());
			$projectSrc = $this->navigationView->getProjectSrc($project->getProjectID(),
																\common\view\Filter::getCleanUrl($project->getName()));

			$html .= "<li>";
			$html .= "<a href='$projectSrc'>" . $project->getName() . "</a>";
			$html .= "<span clsss='created'>" . $created . "</span>";
			$html .= "</li>";
		}
		$html .= "</ul>";
		$html .= "</div>";
		$html .= "</div>";

		return $html;
	}
}