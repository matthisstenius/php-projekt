<?php

namespace project\model;

require_once("src/common/model/DALBase.php");

class ProjectDAL extends \common\model\DALBase {
	/**
	 * @return array
	 */
	public function getProjects() {
		$result = array();

		$stm = self::getDBConnection()->prepare("SELECT idProject, name, description, created, User.username, idUser_User AS userID FROM Project
												 INNER JOIN User ON User.idUser = idUser_User");

		$stm->execute();

		while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}

		return $result;
	}

	/**
	 * @param  int $id
	 * @return array 
	 */
	public function getProject($id) {
		$stm = self::getDBConnection()->prepare("SELECT idProject, name, description, created, User.username, idUser_User AS userID FROM Project
												 INNER JOIN User ON User.idUser = idUser_User
												 WHERE idProject=:id");

		$stm->bindParam(':id', $id, \PDO::PARAM_INT);

		$stm->execute();

		$row = $stm->fetch(\PDO::FETCH_ASSOC);

		return $row;
	}

	/**
	 * @param  project\model\Project $project
	 * @return int ProjectID
	 */
	public function addProject(\project\model\Project $project) {
		try {
			$pdo = self::getDBConnection();

			$stm = $pdo->prepare("INSERT INTO Project (name, description, created, idUser_User)
												 VALUES(:name, :description, :created, :userID)");

			$name = $project->getName();
			$description = $project->getDescription();
			$created = $project->getDateCreated();
			$userID = $project->getUserID();

			$stm->bindParam(':name', $name);
			$stm->bindParam(':description', $description);
			$stm->bindParam(':created', $created);
			$stm->bindParam(':userID', $userID);

			$stm->execute();

			return +$pdo->lastInsertId();
		}

		catch (\Exception $e) {
			//var_dump($e->getMessage());
		}
	}

	/**
	 * @param  project\model\Project $project
	 * @return void
	 */
	public function editProject(\project\model\Project $project) {
		$pdo = self::getDBConnection();

		$stm = $pdo->prepare("UPDATE Project SET name = :name, description = :description
												 WHERE idProject = :projectID");

		$name = $project->getName();
		$description = $project->getDescription();
		$projectID = $project->getProjectID();

		$stm->bindParam(':name', $name, \PDO::PARAM_STR);
		$stm->bindParam(':description', $description, \PDO::PARAM_STR);
		$stm->bindParam(':projectID', $projectID, \PDO::PARAM_INT);

		$stm->execute();
	}

	/**
	 * @param  project\model\Project $project
	 * @return void
	 */
	public function deleteProject(\project\model\Project $project) {
		$stm = self::getDBConnection()->prepare('DELETE FROM Project WHERE idProject =  :id');

		$projectID = $project->getProjectID();

		$stm->bindParam(':id', $projectID, \PDO::PARAM_INT);

		$stm->execute();
	}
}