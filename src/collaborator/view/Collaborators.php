<?php

namespace collaborator\view;

class Collaborators {
	private static $collaborator = "collaborator";
	private static $errorMessage = "collaborator::view::Collaborators::errorMessage";

	/**
	 * @var array of collaborator\model\Collaborator
	 */
	private $collaborators;

	/**
	 * @var collaborator\model\CollaboratorHandeler
	 */
	private $collaboratorHandeler;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var array of user\model\User
	 */
	
	private $users;
	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param array                                	  $collaborators        array of collaborator\model\Collaborator
	 * @param project\model\Project                   $project
	 * @param collaborator\model\CollaboratorHandeler $collaboratorHandeler
	 * @param array                                	  $users                array of user\model\User
	 */
	public function __construct($collaborators, 
								\project\model\Project $project,
								\collaborator\model\CollaboratorHandeler $collaboratorHandeler,
								$users) {

		$this->collaborators = $collaborators;
		$this->project = $project;
		$this->collaboratorHandeler = $collaboratorHandeler;
		$this->users = $users;

		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return string HTML
	 */
	public function getCollaborators() {
		$html = "<div class='centered'>";
		$html .= "<h1>Collaborators</h1>";
		$html .= "<div class='box pad'>";
		$html .= $this->getNewCollaboratorForm();

		if (isset($_SESSION[self::$errorMessage])) {
			$html .= $_SESSION[self::$errorMessage];
			unset($_SESSION[self::$errorMessage]);
		}

		foreach ($this->collaborators as $collaborator) {
			$removeCollaboratorSrc = $this->navigationView->getRemoveCollaboratorSrc($this->project->getProjectID(),
																					\common\view\Filter::getCleanUrl($this->project->getName()),
																					$collaborator->getCollaboratorID());
			$html .= "<p>" . $collaborator->getUsername() . "</p>";

			$html .= "<form action='$removeCollaboratorSrc' method='POST'>
						<input type='hidden' name='_method' value='delete'>
						<button class='btn btn-remove'><span class='icon-remove'></span>Remove Collaborators</button>
					</form>";
		}

		$html .= "</div>";
		$html .= "</div>";
		return $html;
	}

	/**
	 * @return string HTML
	 */
	private function getNewCollaboratorForm() {
		$collaboratorsSrc = $this->navigationView->getCollaboratorsSrc($this->project->getProjectID(),
																		\common\view\Filter::getCleanUrl($this->project->getName()));

		$html = "<form class='pure-form' action='$collaboratorsSrc' method='POST'>
					<input typr='text' name='" . self::$collaborator . "'>
					<button class='btn btn-add'>Add Collaborator</button>
				</form>";

		return $html;
	}

	/**
	 * @return user\model\User
	 */
	private function getCollaborator() {
		if (isset($_POST[self::$collaborator])) {
			$collaborator = \common\view\Filter::clean($_POST[self::$collaborator]);

			foreach ($this->users as $user) {
				if ($user->getUsername() == $collaborator) {
					return $user;
				}

				return new \user\model\NullUser();
			}
		}
	}

	public function addCollaborator() {
		$collaborator = $this->getCollaborator();

		try {
			$newCollaborator = new \collaborator\model\Collaborator(0, $collaborator->getUserID(),
																	$this->project->getProjectID(),
																	$collaborator->getUsername());

			$this->collaboratorHandeler->addCollaborator($newCollaborator);

			$this->navigationView->gotoCollaborators($this->project->getProjectID(),
													\common\view\Filter::getCleanUrl($this->project->getName()));
		}

		catch (\Exception $e) {
			$this->userInputFaulty();
			$this->navigationView->gotoCollaborators($this->project->getProjectID(),
													\common\view\Filter::getCleanUrl($this->project->getName()));
		}
	}

	private function userInputFaulty() {
		$errorMessage = $_SESSION[self::$errorMessage] = "<p>User not found</p>";
	}
}