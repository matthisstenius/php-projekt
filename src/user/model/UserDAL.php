<?php

namespace user\model;

class UserDAL extends \common\model\DALBase {
	/**
	 * @return array of Usersrows
	 */
	public function getUsers() {
		$db = self::getDBConnection();

		$stm = $db->prepare("SELECT idUser AS userID, username, password, token, tokenExpireDate
							 FROM User");

		$stm->execute();

		$result = array();

		while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}

		return $result;
	}

	/**
	 * @param  User   $user
	 * @return array
	 */
	public function getUser(User $user) {
		$db = self::getDBConnection();

		$stm = $db->prepare("SELECT idUser AS userID, username, password, token, tokenExpireDate
							 FROM User WHERE idUser = :userID");

		$userID = $user->getUserID();

		$stm->bindParam(':userID', $userID, \PDO::PARAM_INT);

		$stm->execute();

		return $stm->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * @param  User $user
	 * @return int UserID
	 */
	public function addUser(User $user) {
		try {
			$pdo = self::getDBConnection();

			$stm = $pdo->prepare("INSERT INTO User (username, password, token)
												 VALUES(:username, :password, :token)");

			$username = $user->getUsername();
			$password = $user->getPassword();
			$token = $user->getToken();

			$stm->bindParam(':username', $username);
			$stm->bindParam(':password', $password);
			$stm->bindParam(':token', $token);

			$stm->execute();

			return +$pdo->lastInsertId();
		}

		catch (\Exception $e) {
			//var_dump($e->getMessage());
		}
	}

	/**
	 * @param  User $user
	 * @return void
	 */
	public function editUser(User $user) {
		$pdo = self::getDBConnection();

		$stm = $pdo->prepare("UPDATE User SET username = :username, password = :password, token = :token
							  WHERE idProject = :userID");

		$username = $user->getUsername();
		$password = $user->getPassword();
		$token = $user->getToken();

		$stm->bindParam(':username', $username, \PDO::PARAM_STR);
		$stm->bindParam(':password', $password, \PDO::PARAM_STR);
		$stm->bindParam(':token', $token, \PDO::PARAM_STR);

		$stm->execute();
	}

	/**
	 * @param  User $user
	 * @return void
	 */
	public function deleteUser(User $user) {
		$stm = self::getDBConnection()->prepare('DELETE FROM User WHERE idUser =  :userID');

		$userID = $user->getUserID();

		$stm->bindParam(':userID', $userID, \PDO::PARAM_INT);

		$stm->execute();
	}

	/**
	 * @param  User   $user 
	 */
	public function saveTokenCredentials(User $user) {
		$pdo = self::getDBConnection();

		$stm = $pdo->prepare("UPDATE User SET token = :token, tokenExpireDate = :tokenExpireDate
							 WHERE idUser = :userID");

		$token = $user->getToken();
		$tokenExpireDate = $user->getTokenExpireDate();
		$userID = $user->getUserID();

		$stm->bindParam(':token', $token, \PDO::PARAM_STR);
		$stm->bindParam(':tokenExpireDate', $tokenExpireDate, \PDO::PARAM_INT);
		$stm->bindParam(':userID', $userID, \PDO::PARAM_INT);

		$stm->execute();
	}
}