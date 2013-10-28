<?php

namespace project\view;

require_once("src/project/model/NewProject.php");
require_once("src/common/view/Filter.php");

class NewProject {
	private static $projectName = "projectName";
	private static $projectDescription = "projectDescription";
	private static $errorMessage = "project::view::errorMessage";
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
	 * @return string HTML
	 */
	public function getNewprojectForm() {
		$html = "<h1>Add new project</h1>";

		if (isset($_SESSION[self::$errorMessage])) {
			$html .= $this->userInputFaulty();
			unset($_SESSION[self::$errorMessage]);
		}

		$backToFrontPage = $this->navigationView->getHomeSrc();

		$html .= "<form class='pure-form pure-form-stacked' action='/php-projekt/newProject' method='POST'>
					<input class='input-wide' id='". self::$projectName . "' type='text' 
					name='". self::$projectName . "' placeholder='Project name'>

					<textarea class='input-wide input-content' 
					name='". self::$projectDescription . "' placeholder='Project description'></textarea>

					<button class='btn btn-add'>Create Project</button>
					<a href='$backToFrontPage' class='btn btn-remove'>Cancel</a>
				</form>";

		return $html;
	}

	/**
	 * @return string Clean string
	 */
	private function getProjectName() {
		if (isset($_POST[self::$projectName])) {
			return \common\view\Filter::clean($_POST[self::$projectName]);
		}

		return "";
	}

	/**
	 * @return string Clean string
	 */
	private function getProjectDescription() {
		if (isset($_POST[self::$projectDescription])) {
			return \common\view\Filter::clean($_POST[self::$projectDescription]);
		}

		return "";
	}

	/**
	 * @return porject\model\NewProject
	 */
	public function addProject() {
		try {
			$project = new \project\model\NewProject($this->getProjectName(), $this->getProjectDescription(), \Date('y-m-d'), 3);
			$this->projectHandeler->addProject($project);
			$this->navigationView->goToProject($project->getProjectID(), $project->getCleanName(), 
												$project->getName());
		}

		catch (\Exception $e) {
			$this->setErrorMessageSession();
			$this->navigationView->gotoNewProject();
		}
	}

	private function setErrorMessageSession() {
		$_SESSION[self::$errorMessage] = true;
	}

	/**
	 * @return string HTML
	 */
	private function userInputFaulty() {
		$errorMessage = "";

		if ($this->getProjectName() == "") {
			$errorMessage .= "<p>Enter a Project name</p>";
		}

		if ($this->getProjectDescription() == "") {
			$errorMessage .= "<p>Enter a valid description</p>";
		}

		return $errorMessage;
	}
}