<?php

namespace project\view;

require_once("src/project/model/NewProject.php");
require_once("src/common/view/Filter.php");

class NewProject {
	private static $projectName = "projectName";
	private static $projectDescription = "projectDescription";
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

	public function getNewprojectForm() {
		return "<form action='/php-projekt/newProject' method='POST'>
					<label for='". self::$projectName . "'>Project Name</label>
					<input id='". self::$projectName . "' type='text' name='". self::$projectName . "'>

					<label for='". self::$projectDescription . "'>Project Description</label>
					<input id='". self::$projectDescription . "' type='text' name='". self::$projectDescription . "'>

					<input type='submit' value='Create Project'>
				</form>";
	}

	private function getProjectName() {
		if (isset($_POST[self::$projectName])) {
			return \common\view\Filter::clean($_POST[self::$projectName]);
		}
	}

	private function getProjectDescription() {
		if (isset($_POST[self::$projectDescription])) {
			return \common\view\Filter::clean($_POST[self::$projectDescription]);
		}
	}

	public function addProject() {
		try {
			$project = new \project\model\NewProject($this->getProjectName(), $this->getProjectDescription(), \Date('y-m-d'), 3);
			$this->projectHandeler->addProject($project);
		}

		catch (\Exception $e) {
			$this->userInputFaulty();
		}
	}

	private function userInputFaulty() {
		if ($this->getName() == "") {
			$this->message = 
		}
	}
}