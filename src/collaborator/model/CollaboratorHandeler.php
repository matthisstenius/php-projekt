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
	 * @return array of Users
	 */
	public function getCollaborators(\project\model\Project $project) {
		$rows = $this->collaboratorDAL->getCollaborators($project);
		$collaborators = array();

		foreach ($rows as $row) {
			$collaborators[] = new Collaborator(+$row['idCollaborator'], +$row['userID'], +$row['projectID'], $row['username']);
		}

		return $collaborators;
	}

	/**
	 * @param User $user
	 */
	public function addCollaborator(Collaborator $collaborator) {
		$collaboratorID = $this->collaboratorDAL->addCollaborator($collaborator);
		$collaborator->setCollaboratorID($collaboratorID);
	}

	/**
	 * @param  User   $user
	 * @return void
	 */
	public function deleteUser(Collaborator $collaborator) {
		$this->collaboratorDAL->deleteCollaborator($collaborator);
	}
}