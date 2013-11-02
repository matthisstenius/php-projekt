<?php

namespace collaborator\controller;

require_once("src/collaborator/view/Collaborators.php");

class Collaborators {
	private $collaborators;

	private $project;

	private $collaboratorHandeler;

	public function __construct($collaborators, 
								\project\model\Project $project,
								\collaborator\model\CollaboratorHandeler $collaboratorHandeler) {

		$this->collaborators = $collaborators;
		$this->project = $project;
		$this->collaboratorHandeler = $collaboratorHandeler;

		$this->collaboratosView = new \collaborator\view\Collaborators($this->collaborators, $this->project, $this->collaboratorHandeler);
	}

	public function showCollaborators() {
		return $this->collaboratosView->getCollaborators();
	}
}