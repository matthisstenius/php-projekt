<?php

namespace project\view;

require_once("src/project/model/NewProject.php");
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
	 * @param int $projectID
	 * @param string $projectName
	 * @return string HTML
	 */
	public function getEditProjectForm($projectID, $projectName) {
		try {
			$project = $this->projectHandeler->getProject($projectID);

			if ($project->getCleanName() != $projectName) {
				$this->navigationView->goToEditProject($project->getProjectID(), $project->getCleanName());
			}

			$html = "<h1>Edit " . $project->getName() . "</h1>";

			if (isset($_SESSION[self::$errorMessage])) {
				$html .= $this->userInputFaulty();
				unset($_SESSION[self::$errorMessage]);
			}

			$editProjectSrc = $this->navigationView->getEditProjectSrc($projectID, $projectName);
			
			$html .= "<form class='pure-form pure-form-stacked' action='$editProjectSrc' method='POST'>
						<input type='hidden' name='_method' value='put'>
						<input class='input-wide' id='". self::$projectName . "' type='text' 
						name='". self::$projectName . "' value='" . $project->getName() . "'>

						<textarea class='input-wide input-content' 
						name='". self::$projectDescription . "'>" . $project->getDescription() . "</textarea>

						<button class='btn btn-add'>Save Project</button>
					</form>";
		}

		catch (\Exception $e) {
			$html = "<p>Project could not be found</p>";
		}

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
	 * @todo  look into refactoring this
	 */
	public function saveProject($projectID, $projectName) {
		try {
			$project = $this->projectHandeler->getProject($projectID);

			$newProject = new \project\model\Project($project->getProjectID(), $this->getProjectName(), 
															$this->getProjectDescription(),
														 	$project->getDateCreated(), "Matthis", $project->getUserID());
			
			$this->projectHandeler->editProject($newProject);

			$this->navigationView->goToProject($newProject->getProjectID(), $newProject->getCleanName(), 
											$newProject->getName());
		}

		catch (\Exception $e) {
			$this->setErrorMessageSession();
			$this->navigationView->goToEditProject($projectID, $projectName);
		}
	}

	private function setErrorMessageSession() {
		$_SESSION[self::$errorMessage] = true;
	}

	/**
	 * @return string HTML
	 */
	private function userInputFaulty() {
		$errorMessage = "<p>Oppps... Project could not be saved. Please try again later.</p>";

		return $errorMessage;
	}
}