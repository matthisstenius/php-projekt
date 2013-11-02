<?php

namespace collaborator\view;

class Collaborators {
	private $collaborators;

	private $collaboratorHandeler;

	private $project;

	public function __construct($collaborators, 
								\project\model\Project $project,
								\collaborator\model\CollaboratorHandeler $collaboratorHandeler) {

		$this->collaborators = $collaborators;
		$this->project = $project;
		$this->collaboratorHandeler = $collaboratorHandeler;
	}

	public function getCollaborators() {
		$html = "<h1>Collaborators</h1>";

		foreach ($this->collaborators as $collaborator) {
			$html .= "<p>" . $collaborator->getUsername() . "</p>";
		}

		return $html;
	}
}