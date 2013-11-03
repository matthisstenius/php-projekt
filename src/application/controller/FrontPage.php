<?php

namespace application\controller;

require_once("src/application/view/FrontPage.php");

class FrontPage {
	/**
	 * @var array of project\model\Project
	 */
	private $projects;

	/**
	 * @var application\view\FrontPage
	 */
	private $frontPageView;

	/**
	 * @param array $projects array of project\model\Project
	 */
	public function __construct($projects) {
		$this->projects = $projects;

		$this->frontPageView = new \application\view\FrontPage($this->projects);
	}

	/**
	 * @return string HTML
	 */
	public function showPublicProjects() {
		return $this->frontPageView->getPublicProjects();
	}
}