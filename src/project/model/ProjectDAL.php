<?php

namespace project\model;

require_once("src/common/model/DALBase.php");

class ProjectDAL extends \common\model\DALBase {
	/**
	 * @return array
	 */
	public function getProjects() {
		$result = array();

		$stm = self::getDBConnection()->prepare("SELECT idProject, name, description, created, User.username FROM Project
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
		$stm = self::getDBConnection()->prepare("SELECT idProject, name, description, created, User.username FROM Project
												 INNER JOIN User ON User.idUser = idUser_User
												 WHERE idProject=:id");

		$stm->bindParam(':id', $id, \PDO::PARAM_INT);

		$stm->execute();

		$row = $stm->fetch(\PDO::FETCH_ASSOC);

		return $row;
	}

	/**
	 * @param  project\model\Project $project
	 * @return void
	 */
	public function addProject(\project\model\Project $project) {
		$stm = self::getDBConnection()->prepare("INSERT INTO Project name, description, created, idUser_User
												 VALUES(:name, :description, :created, :userID)");

		$stm->bindParam(':name', $project->getName(), \PDO::PARAM_STRING);
		$stm->bindParam(':description', $project->getDescription(), \PDO::PARAM_STRING);
		$stm->bindParam(':created', $project->getDateCreated(), \PDO::PARAM_DATE);
		$stm->bindParam(':userID', $project->getUserID(), \PDO::PARAM_INT);

		$stm->execute();
	}

	/**
	 * @param  project\model\Project $project
	 * @return void
	 */
	public function editProject(\project\model\Project $project) {
		$stm = self::getDBConnection()->prepare("UPDATE Project SET name = :name, description = :description 
												 WHERE idPost = :id");

		$stm->bindParam(':name', $project->getName(), \PDO::PARAM_STRING);
		$stm->bindParam(':content', $projekt->getDescription(), \PDO::PARAM_STRING);

		$stm->execute();
	}

	/**
	 * @param  int $id
	 * @return void
	 */
	public function deleteProject($id) {
		$stm = self::getDBConnection()->prepare('DELETE Project WHERE idProject =  :id');

		$stm->bindParam(':id', $id, \PDO::PARAM_INT);

		$stm->execute();
	}
}