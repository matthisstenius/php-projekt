<?php

namespace collaborator\model;

require_once("src/collaborator/model/Collaborator.php");
require_once("src/collaborator/model/CollaboratorDAL.php");

class CollaboratorHandeler {
	/**
	 * @var CollaboratorDAL
	 */
	private $collaboratorDAL;

	public function __construct() {
		$this->collaboratorDAL = new CollaboratorDAL();
	}

	/**
	 * @param project\model\Project $project
	 * @return array of Collaborator
	 */
	public function getCollaborators(\project\model\Project $project) {
		$rows = $this->collaboratorDAL->getCollaborators($project);
		$collaborators = array();

		foreach ($rows as $row) {
			try {
				$collaborators[] = new Collaborator(+$row['idCollaborator'], +$row['userID'], +$row['projectID'], $row['username']);
			}

			catch (\Exception $e) {
				throw $e;
			}
		}

		return $collaborators;
	}

	/**
	 * @param Collaborator $collaborator
	 */
	public function addCollaborator(Collaborator $collaborator) {
		$collaboratorID = $this->collaboratorDAL->addCollaborator($collaborator);
		$collaborator->setCollaboratorID($collaboratorID);
	}

	/**
	 * @param  Collaborator   $collaborator
	 * @return void
	 */
	public function deleteCollaborator(Collaborator $collaborator) {
		$this->collaboratorDAL->deleteCollaborator($collaborator);
	}
}