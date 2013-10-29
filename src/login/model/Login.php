<?php

namespace login\model;

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
			$passwordsAreEqual = $loginCredentials->getPassword() == $user->getPassword();

			if ($usernamesAreEqual && $passwordsAreEqual) {
				$this->setUserLoggedIn($user);
				return true;
			}
		}
		
		throw new \Exception("Wrong password and/or username");	
	}

	private function setUserLoggedIn(\user\model\User $user) {
		$_SESSION[self::$user] = $user;
	}

	public function isUserLoggedIn() {
		return isset($_SESSION[self::$user]);
	}

	public function getLoggedInUser() {
		return $_SESSION[self::$user];
	}
}