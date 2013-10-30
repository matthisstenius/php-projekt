<?php

namespace register\model;

class RegisterDAL extends \common\model\DALBase {
	/**
	 * @param  user\model\User $user
	 * @return int UserID
	 */
	public function registerUser(user\model\User $user) {
		try {
			$pdo = self::getDBConnection();

			$stm = $pdo->prepare("INSERT INTO User (username, password, token, tokenExpireDate)
												 VALUES(:username, :password, 'token', 0)");

			$username = $user->getUsername();
			$password = $user->getPassword();

			$stm->bindParam(':username', $username);
			$stm->bindParam(':password', $password);

			$stm->execute();

			return +$pdo->lastInsertId();
		}

		catch (\Exception $e) {
			//var_dump($e->getMessage());
		}
	}
}