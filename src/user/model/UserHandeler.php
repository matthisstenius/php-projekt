<?php

namespace user\model;

require_once("src/user/model/User.php");
require_once("src/user/model/UserDAL.php");

class UserHandeler {
	/**
	 * @var UserDAL
	 */
	private $userDAL;

	public function __construct() {
		$this->userDAL = new UserDAL();
	}

	/**
	 * @return array of Users
	 */
	public function getUsers() {
		$rows = $this->userDAL->getUsers();
		$users = array();

		foreach ($rows as $row) {
			try {
				$users[] = new User(+$row['userID'], $row['username'], $row['password'], $row['token'], +$row['tokenExpireDate']);
			}

			catch (\Exception $e) {
				throw $e;
			}
		}

		return $users;
	}
	/**
	 * @param  User   $user
	 * @return User
	 */
	public function getUser(User $user) {
		$row = $this->userDAL->getUser($user);

		try {
			return new User(+$row['userID'], $row['username'], $row['password'], $row['token'], +$row['tokenExpireDate']);
		}

		catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * @param User $user
	 */
	public function addUser(User $user) {
		$userID = $this->userDAL->addUser($user);
		$user->setUserID($userID);
	}

	/**
	 * @param  User   $user
	 * @return void
	 */
	public function editUser(User $user) {
		$this->userDAL->editUser($user);
	}

	/**
	 * @param  User   $user
	 * @return void
	 */
	public function deleteUser(User $user) {
		$this->userDAL->deleteUser($user);
	}

	/**
	 * @param  User   $user
	 * @return void
	 */
	public function saveTokenCredentials(User $user) {
		$this->userDAL->saveTokenCredentials($user);
	}
}