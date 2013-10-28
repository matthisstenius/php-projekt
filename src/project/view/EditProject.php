<?php

namespace project\view;

require_once("src/common/view/Filter.php");

class EditProject {
	private static $projectName = "projectName";
	private static $projectDescription = "projectDescription";
	private static $errorMessage = "project::view::edit::errorMessage";
	
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 * @param project\model\Project $project
	 * @param common\view\Navigation $navigationView
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler, \project\model\Project $project,
								\common\view\Navigation $navigationView) {

		$this->projectHandeler = $projectHandeler;
		$this->project = $project;
		$this->navigationView = $navigationView;
	}

	/**
	 * @param string $projectName
	 * @return string HTML
	 */
	public function getEditProjectForm($projectName) {
		$cleanUrl = \common\view\Filter::getCleanUrl($this->project->getName());

		if ($cleanUrl != $projectName) {
			$this->navigationView->goToEditProject($this->project->getProjectID(), $cleanUrl);
		}

		$html = "<h1>Edit " . $this->project->getName() . "</h1>";

		if (isset($_SESSION[self::$errorMessage])) {
			$html .= $this->userInputFaulty();
			unset($_SESSION[self::$errorMessage]);
		}

		$editProjectSrc = $this->navigationView->getEditProjectSrc($this->project->getProjectID(),
																	$cleanUrl);

		$backToProjectSrc = $this->navigationView->getProjectSrc($this->project->getProjectID(), 
																 $projectName);
		
		$html .= "<form class='pure-form pure-form-stacked' action='$editProjectSrc' method='POST'>
					<input type='hidden' name='_method' value='put'>
					<input class='input-wide' id='". self::$projectName . "' type='text' 
					name='". self::$projectName . "' value='" . $this->project->getName() . "'>

					<textarea class='input-wide input-content' 
					name='". self::$projectDescription . "'>" . $this->project->getDescription() . "</textarea>

					<button class='btn btn-add'>Save Project</button>
					<a href='$backToProjectSrc' class='btn btn-remove'>Cancel</a>
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
	 * @return void
	 */
	public function saveProject() {
		try {
			$newProject = new \project\model\Project($this->project->getProjectID(), $this->getProjectName(), 
															$this->getProjectDescription(),
														 	$this->project->getDateCreated(), "Matthis", 
														 	$this->project->getUserID());
			
			$this->projectHandeler->editProject($newProject);

			$this->navigationView->goToProject($newProject->getProjectID(), 
												\common\view\Filter::getCleanUrl($newProject->getName()), 
												$newProject->getName());
		}

		catch (\Exception $e) {
			$this->setErrorMessageSession();
			$this->navigationView->goToEditProject($this->project->getProjectID(), $this->project->getName());
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