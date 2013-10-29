<?php

namespace user\model;

class User {
	/**
	 * @var int
	 */
	private $userID;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var int
	 */
	private $tokenExpireDate;

	/**
	 * @param int $userID
	 * @param string $username
	 * @param string $password
	 * @param string $token
	 * @param int $tokenExpireDate
	 */
	public function __construct($userID, $username, $password, $token, $tokenExpireDate) {
		if (!is_int($userID)) {
			throw new \Exception("Invalid userID");
		}

		if (!is_string($username) || $username == "") {
			throw new \Exception("Invalid username");
			
		}

		if (!is_string($password) || $password == "") {
			throw new \Exception("Invalid password");
		}

		if (!is_string($token) || $token == "") {
			throw new \Exception("Invalid token");
		}

		if (!is_int($tokenExpireDate)) {
			throw new \Exception("Invalid tokenExpireDate");
		}

		$this->userID   = $userID;
		$this->username = $username;
		$this->password = $password;
		$this->token    = $token;
		$this->tokenExpireDate = $tokenExpireDate;
	}

	/**
	 * @return int
	 */
	public function getUserID() {
		return $this->userID;
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

	/**
	 * @return string
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * @return int
	 */
	public function getTokenExpireDate() {
		return $this->tokenExpireDate;
	}

	/**
	 * @param int $tokenExpireDate
	 */
	public function setTokenExpireDate($tokenExpireDate) {
		$this->tokenExpireDate = $tokenExpireDate;
	}
}
