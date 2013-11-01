<?php

namespace project\model;

/**
 * Inherits from Project. Used for creating new Projects with different params.
 */
class NewProject extends Project {
	/**
	 * @param string $name
	 * @param string $description
	 * @param date $created
	 * @param int $userID
	 * @throws Ecxeption If validation failes
	 */
	public function __construct($name, $description, $created, $userID, $private) {
		if (!is_string($name) || $name == "") {
			throw new \Exception("invalid name");
		}

		if (!is_string($description) || $description == "") {
			throw new \Exception("invalid description");
		}

		if (!is_string($created) || $created == "") {
			throw new \Exception("invalid created date");
		}

		if (!is_int($userID)) {
			throw new \Exception("invalid userID");
		}

		if (!is_bool($private)) {
			throw new \Exception("invalid private param");
		}

		$this->name        = $name;
		$this->description = $description;
		$this->created     = $created;
		$this->userID      = $userID;
		$this->private      = $private;
	}

	public function setProjectID($projectID) {
		$this->projectID = $projectID;
	}
}