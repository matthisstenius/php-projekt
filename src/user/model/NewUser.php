<?php

namespace user\model;

class NewUser extends User {
	
	/**
	 * @param sting $username
	 * @param string $password
	 * @todo  fix some hashing
	 */
	public function __construct($username, $password) {
		if (!is_string($username) || strlen($username) < 5) {
			throw new \Exception("Invalid username");
			
		}

		if (!is_string($password) || strlen($password) < 6) {
			throw new \Exception("Invalid password");
		}

		$this->username = $username;
		$this->password = crypt($password);
	}
}