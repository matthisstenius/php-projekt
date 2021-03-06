<?php

namespace project\view;

require_once("src/common/view/Filter.php");

class EditProject {
	private static $projectName = "projectName";
	private static $projectDescription = "projectDescription";
	private static $makePrivate = "private";
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
	public function __construct(\project\model\ProjectHandeler $projectHandeler, 
								\project\model\Project $project) {

		$this->projectHandeler = $projectHandeler;
		$this->project = $project;
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return string HTML
	 */
	public function getEditProjectForm() {
		$cleanUrl = \common\view\Filter::getCleanUrl($this->project->getName());

		$html = "<h1 class='new-title'>Edit " . $this->project->getName() . "</h1>";

		if (isset($_SESSION[self::$errorMessage])) {
			$html .= $_SESSION[self::$errorMessage];
			unset($_SESSION[self::$errorMessage]);
		}

		$editProjectSrc = $this->navigationView->getEditProjectSrc($this->project->getProjectID(),
																	$cleanUrl);

		$backToProjectSrc = $this->navigationView->getProjectSrc($this->project->getProjectID(), 
																 $cleanUrl);
		
		$html .= "<form class='pure-form pure-form-stacked' action='$editProjectSrc' method='POST'>
					<input type='hidden' name='_method' value='put'>
					<input class='input-wide' id='". self::$projectName . "' type='text' 
					name='". self::$projectName . "' value='" . $this->project->getName() . "'>

					<textarea class='input-wide input-content' 
					name='". self::$projectDescription . "'>" . $this->project->getDescription() . "</textarea>
					
					<label class='make-project-private' for='" . self::$makePrivate . "'>Make this project private</label>";

					if ($this->project->isPrivate()) {
						$html .= "<input class='make-project-private' id='" . self::$makePrivate . "' 
								type='checkbox' checked name='" . self::$makePrivate . "'>";
					}
					
					else {
						$html .= "<input class='make-project-private' id='" . self::$makePrivate . "' 
								type='checkbox' name='" . self::$makePrivate . "'>";
					}

					$html .= "<p><button class='btn btn-add'>Save Project</button>
					<a href='$backToProjectSrc' class='btn btn-remove'>Cancel</a></p>
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
	public function saveProject() {
		try {
			$newProject = new \project\model\Project($this->project->getProjectID(), $this->getProjectName(), 
															$this->getProjectDescription(),
														 	$this->project->getDateCreated(),
														 	$this->project->getUsername(), 
														 	$this->project->getUserID(),
														 	$this->getIsPrivate());
			
			$this->projectHandeler->editProject($newProject);

			$this->navigationView->goToProject($newProject->getProjectID(), 
												\common\view\Filter::getCleanUrl($newProject->getName()), 
												$newProject->getName());
		}

		catch (\Exception $e) {
			$this->userInputFaulty();
			$this->navigationView->goToEditProject($this->project->getProjectID(), $this->project->getName());
		}
	}

	private function userInputFaulty() {
		$errorMessage = "";

		if ($this->getProjectName() == "") {
			$errorMessage .= "<p>Enter a Project name</p>";
		}

		if (strlen($this->getProjectName()) > 45) {
			$errorMessage .= "<p>Project name is to long. Max 45 charachters allowed.</p>";
		}

		if (preg_match('/[^\wåäöÅÄÖ]+/', $this->getProjectName())) {
			$errorMessage .= "<p>Invalid charachters in project name. Only alphanumeric charachters allowed.</p>";
		}
		
		if ($this->getProjectDescription() == "") {
			$errorMessage .= "<p>Enter a valid description</p>";
		}

		if (strlen($this->getProjectDescription()) > 500) {
			$errorMessage .= "<p>Project decoration is to long. Max 500 charachters allowed.</p>";
		}

		$_SESSION[self::$errorMessage] = $errorMessage;
	}
}