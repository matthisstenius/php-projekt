<?php

namespace project\model;

require_once("src/common/model/DALBase.php");

class ProjectDAL extends \common\model\DALBase {
	/**
	 * @param user\model\User $user
	 * @return array
	 */
	public function getProjects(\user\model\User $user) {
		$result = array();

		$stm = self::getDBConnection()->prepare("SELECT idProject, name, description, created, User.username, 
												idUser_User AS userID, private FROM Project
												INNER JOIN User ON User.idUser = idUser_User
												WHERE idUser_User = :userID");

		$userID = $user->getUserID();

		$stm->bindParam(':userID', $userID, \PDO::PARAM_INT);
		
		$stm->execute();

		while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}

		return $result;
	}

	/**
	 * @param int $limit
	 * @return array
	 */
	public function getPublicProjects($limit) {
		$result = array();

		$stm = self::getDBConnection()->prepare("SELECT idProject, name, description, created, User.username, 
												idUser_User AS userID, private FROM Project
												INNER JOIN User ON User.idUser = idUser_User
												WHERE private = 0
												ORDER BY idProject
												DESC LIMIT :amount");


		$stm->bindParam(':amount', $limit, \PDO::PARAM_INT);

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
		$stm = self::getDBConnection()->prepare("SELECT idProject, name, description, created, User.username, 
												 idUser_User AS userID, private FROM Project
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

			$stm = $pdo->prepare("INSERT INTO Project (name, description, created, idUser_User, private)
												 VALUES(:name, :description, :created, :userID, :private)");

			$name = $project->getName();
			$description = $project->getDescription();
			$created = $project->getDateCreated();
			$userID = $project->getUserID();
			$private = (int) $project->isPrivate();

			$stm->bindParam(':name', $name);
			$stm->bindParam(':description', $description);
			$stm->bindParam(':created', $created);
			$stm->bindParam(':userID', $userID);
			$stm->bindParam(':private', $private);

			$stm->execute();

			return +$pdo->lastInsertId();
		}

		catch (\Exception $e) {
			var_dump($e->getMessage());
		}
	}

	/**
	 * @param  project\model\Project $project
	 * @return void
	 */
	public function editProject(\project\model\Project $project) {
		$pdo = self::getDBConnection();

		$stm = $pdo->prepare("UPDATE Project SET name = :name, description = :description, private = :private
												 WHERE idProject = :projectID");

		$name = $project->getName();
		$description = $project->getDescription();
		$projectID = $project->getProjectID();
		$private = (int) $project->isPrivate();

		$stm->bindParam(':name', $name);
		$stm->bindParam(':description', $description);
		$stm->bindParam(':projectID', $projectID);
		$stm->bindParam(':private', $private);

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