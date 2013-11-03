<?php

namespace project\view;

require_once("src/common/view/Filter.php");

class NewProject {
	private static $projectName = "projectName";
	private static $projectDescription = "projectDescription";
	private static $makePrivate = "private";
	private static $inputFaultyMessage = "project::view::inputFaultyMessage";
	private static $saveProjectName = "project::view::saveProjectName";

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

	/**
	 * @return string HTML
	 */
	public function getNewprojectForm() {
		$html = "<h1 class='new-title'>Add new project</h1>";

		if (isset($_SESSION[self::$inputFaultyMessage])) {
			$html .= $_SESSION[self::$inputFaultyMessage];
			unset($_SESSION[self::$inputFaultyMessage]);
		}

		$projectName = "";

		if (isset($_SESSION[self::$saveProjectName])) {
			$projectName = $_SESSION[self::$saveProjectName];
			unset($_SESSION[self::$saveProjectName]);
		}

		$backToProjects = $this->navigationView->getProjectsSrc();
		$addNewProjectSrc = $this->navigationView->getAddNewProjectSrc();

		$html .= "<form class='pure-form pure-form-stacked' action='$addNewProjectSrc' method='POST'>
					<input class='input-wide' id='". self::$projectName . "' type='text' 
					name='". self::$projectName . "' placeholder='Project name' value='$projectName'>

					<textarea class='input-wide input-content' 
					name='". self::$projectDescription . "' placeholder='Project description'></textarea>
					
					<label class='make-project-private' for='" . self::$makePrivate . "'>Make this project private</label>
					<input class='make-project-private' id='" . self::$makePrivate . "' 
					type='checkbox' name='" . self::$makePrivate . "'>
					<p>
					<button class='btn btn-add'>Create Project</button>
					<a href='$backToProjects' class='btn btn-remove'>Cancel</a>
					</p>
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
	 * @return boolean
	 */
	private function getIsPrivate() {
		if (isset($_POST[self::$makePrivate])) {
			return (bool) $_POST[self::$makePrivate];
		}

		return false;
	}

	/**
	 * @return void
	 */
	public function addProject() {
		try {
			$project = new \project\model\Project(0, $this->getProjectName(), 
													 $this->getProjectDescription(),
													 \Date('y-m-d'),
													 $this->user->getUsername(),
													 $this->user->getUserID(),
													 $this->getIsPrivate());

			$this->projectHandeler->addProject($project);

			$this->navigationView->goToProject($project->getProjectID(), \common\view\Filter::getCleanUrl($project->getName()), 
												$project->getName());
		}

		catch (\Exception $e) {
			$this->userInputFaulty();
			$this->saveProjectName();
			$this->navigationView->gotoNewProject();
		}
	}

	private function saveProjectName() {
		$_SESSION[self::$saveProjectName] = $this->getProjectName();
	}

	/**
	 * @return string HTML
	 */
	private function userInputFaulty() {
		$errorMessage = "";

		if ($this->getProjectName() == "") {
			$errorMessage .= "<p>Enter a project name</p>";
		}

		if (preg_match('/[^\wåäöÅÄÖ\s()?!]+/', $this->getProjectName())) {
			$errorMessage .= "<p>Invalid charachters in project name. Only alphanumeric charachters and ()?! allowed.</p>";
		}

		if ($this->getProjectDescription() == "") {
			$errorMessage .= "<p>Enter a description</p>";
		}

		$_SESSION[self::$inputFaultyMessage] = $errorMessage;
	}
}