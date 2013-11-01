<?php

namespace user\model;

class SimpleUser extends User {
	
	/**
	 * @param sting $username
	 * @param string $password
	 * @todo  fix some hashing
	 */
	public function __construct($userID, $username) {
		if (!is_int($userID)) {
			throw new \Exception("Invalid userID");
			
		}

		if (!is_string($username) || strlen($username) < 5) {
			throw new \Exception("Invalid username");
		}

		$this->userID = $userID;
		$this->username = $username;
	}
}