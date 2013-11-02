<?php

namespace collaborator\model;

class CollaboratorDAL extends \common\model\DALBase {
	
	/**
	 * @return array of Collaboratorrows
	 */
	public function getCollaborators(\project\model\Project $project) {
		$db = self::getDBConnection();

		$stm = $db->prepare("SELECT idCollaborator, userID, projectID, User.username as username
							 FROM Collaborator
							 INNER JOIN User ON User.idUser = userID
							 WHERE projectID = :projectID");

		$projectID = $project->getProjectID();
		$stm->bindParam(':projectID', $projectID);

		$stm->execute();

		$result = array();

		while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}

		return $result;
	}

	/**
	 * @param  User $user
	 * @return int UserID
	 */
	public function addCollaborator(Collaborator $collaborator) {

		$pdo = self::getDBConnection();

		$stm = $pdo->prepare("INSERT INTO Collaborator (userID, projectID)
							  VALUES(:userID, :projectID)");

		$userID = $collaborator->getUserID();
		$projectID = $collaborator->getProjectID();

		$stm->bindParam(':userID', $userID);
		$stm->bindParam(':projectID', $projectID);

		$stm->execute();

		return +$pdo->lastInsertId();
	}

	/**
	 * @param  User $user
	 * @return void
	 */
	public function deleteCollaborator(Collaborator $vollaborator) {
		$stm = self::getDBConnection()->prepare('DELETE FROM Collaborator WHERE idCollaborator =  :collaboratorID');

		$collaboratorID = $collaborator->getCollaboratorID();

		$stm->bindParam(':idCollaborator', $collaboratorID);

		$stm->execute();
	}
}