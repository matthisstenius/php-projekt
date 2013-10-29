<?php

namespace login\model;

class LoginCredentials {
	/**
	 * @var String
	 */
	private $username;

	/**
	 * @var String
	 */
	private $password;

	/**
	 * @param String $username
	 * @param String $password
	 */
	public function __construct($username, $password) {
		if (!is_string($username) || $username == "") {
			throw new \Exception("Invalid username");
		}

		if (!is_string($password) || $password == "") {
			throw new \Exception("Invalid password");
		}

		$this->username = $username;
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}

}