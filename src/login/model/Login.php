<?php

namespace login\model;

require_once("src/user/model/NullUser.php");

class Login {
	private static $user = "login::model::login";

	/**
	 * @param array of Users
	 * @param LoginCredentials $loginCredentials
	 * @return boolean
	 * @throws Exception If username and/or password do not match
	 */
	public function isLoginOk($users, LoginCredentials $loginCredentials) {
		foreach ($users as $user) {
			$usernamesAreEqual = $loginCredentials->getUsername() == $user->getUsername();
			$passwordsAreEqual = crypt($loginCredentials->getPassword(), $user->getPassword()) == $user->getPassword();
			

			if ($usernamesAreEqual && $passwordsAreEqual) {
				$this->setUserLoggedIn($user);
				return $user;
			}
		}
		
		throw new \Exception("Wrong password and/or username");	
	}

	public function loginWithTokenOK($users, TokenCredentials $tokenCredentials) {
		foreach ($users as $user) {
			$tokensAreEqual = $tokenCredentials->getToken() == $user->getToken();

			if ($tokensAreEqual && time() < $user->getTokenExpireDate()) {
				$this->setUserLoggedIn($user);
				return $user;
			}
		}

		throw new \Exception("Failed login with token");
		
	}

	public function setUserLoggedIn(\user\model\User $user) {
		$_SESSION[self::$user] = $user;
	}

	public function unsetUserLoggedIn() {
		unset($_SESSION[self::$user]);
	}

	public function isUserLoggedIn() {
		return isset($_SESSION[self::$user]);
	}

	/**
	 * @param  user\model\User $otherUser
	 * @return boolean
	 */
	public function isSameUser(\user\model\User $otherUser) {
		if ($otherUser->getUserID() == $this->getLoggedInUser()->getUserID()) {
			return true;
		}

		return false;
	}

	/**
	 * @param  project\model\Project $project
	 * @return boolean
	 */
	public function isAdmin(\project\model\Project $project) {
		if ($project->getUserID() == $this->getLoggedInUser()->getUserID()) {
			return true;
		}

		return false;
	}

	/**
	 * @param  array              	 $collaborators array of collaborator\model\Collaborator
	 * @param  project\model\Project $project
	 * @return boolean
	 */
	public function isCollaborator($collaborators, \project\model\Project $project) {
		foreach ($collaborators as $collaborator) {
			if ($collaborator->getProjectID() == $project->getProjectID() &&
				$collaborator->getUserID() == $this->getLoggedInUser()->getUserID()) {
				return true;
			}
		}

		return false;
	}

	public function getLoggedInUser() {
		if ($this->isUserLoggedIn()) {
			return $_SESSION[self::$user];
		}

		return new \user\model\NullUser();
	}
}