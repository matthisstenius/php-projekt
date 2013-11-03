<?php

namespace project\model;

class Project {
	/**
	 * @var int
	 */
	private $projectID;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var date
	 */
	private $created;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var int
	 */
	private $userID;

	/**
	 * @var boolean
	 */
	private $private;

	/**
	 * @param int $projectID
	 * @param string $name
	 * @param string $description
	 * @param date $created
	 * @param string $username
	 * @param int $userID
	 * @param boolean $private
	 * @throws Exception If validation failes
	 */
	public function __construct($projectID = null, $name, $description, $created, $username, $userID, $private) {
		if (!is_int($projectID)) {
			throw new \Exception("invalid projectID");
		}

		if (!is_string($name) || $name == "" || preg_match('/[^\wåäöÅÄÖ\s()?!]+/', $name) || strlen($name) > 45) {
			throw new \Exception("invalid name");
		}

		if (!is_string($description) || $description == "" || strlen($description) > 500) {
			throw new \Exception("invalid description");
		}

		if (!is_string($created) || $created == "") {
			throw new \Exception("invalid created date");
		}

		if (!is_string($username) || $username == "") {
			throw new \Exception("invalid username");
		}

		if (!is_int($projectID)) {
			throw new \Exception("invalid userID");
		}

		if (!is_bool($private)) {
			throw new \Exception("invalid private param");
		}

		$this->projectID  = $projectID;
		$this->name   = $name;
		$this->description = $description;
		$this->created   = $created;
		$this->username    = $username;
		$this->userID = $userID;
		$this->private = $private;
	}

	/**
	 * @return int
	 */
	public function getProjectID() {
		return $this->projectID;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return date
	 */
	public function getDateCreated() {
		return $this->created;
	}

	/**
	 * @return string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @return int
	 */
	public function getUserID() {
		return $this->userID;
	}

	/**
	 * @return boolean
	 */
	public function isPrivate() {
		return $this->private;
	}

	public function setProjectID($projectID) {
		$this->projectID = $projectID;
	}
}