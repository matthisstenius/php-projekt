<?php

namespace collaborator\controller;

require_once("src/collaborator/view/Collaborators.php");

class Collaborators {
	/**
	 * @var array of collaborator\model\Collaborator
	 */
	private $collaborators;

	/**	
	 * @var project\model\Project
	 */
	private $project;

	/**	
	 * @var collaborator\model\Collaborators
	 */
	private $collaboratorHandeler;

	/**
	 * @var array of user\model\User
	 */
	private $users;

	/**
	 * @var collaborator\view\Collaborators
	 */
	private $collaboratorsView;

	/**
	 * @param array                                	  $collaborators        array of collaborator\model\Collaborator
	 * @param project\model\Project                   $project
	 * @param collaborator\model\CollaboratorHandeler $collaboratorHandeler
	 * @param array                                	  $users                arrau of user\model\User
	 */
	public function __construct($collaborators, 
								\project\model\Project $project,
								\collaborator\model\CollaboratorHandeler $collaboratorHandeler,
								$users) {

		$this->collaborators = $collaborators;
		$this->project = $project;
		$this->collaboratorHandeler = $collaboratorHandeler;
		$this->users = $users;

		$this->collaboratorsView = new \collaborator\view\Collaborators($this->collaborators, 
																		$this->project, 
																		$this->collaboratorHandeler,
																		$this->users);
	}

	/**
	 * @return string HTML
	 */
	public function showCollaborators() {
		return $this->collaboratorsView->getCollaborators();
	}

	public function addCollaborator() {
		$this->collaboratorsView->addCollaborator();
	}
}