<?php

namespace project\model;

/**
 * Inherits from Project. Used for creating new Projects with different params.
 */
class NewProject extends Project {
	/**
	 * @var string $name
	 */
	private $name;

	/**
	 * @var string $description
	 */
	private $description;

	/**
	 * @var date $created
	 */
	private $created;

	/**
	 * @var int $userID
	 */
	private $userID;

	/**
	 * @param string $name
	 * @param string $description
	 * @param date $created
	 * @param int $userID
	 * @throws Ecxeption If validation failes
	 */
	public function __construct($name, $description, $created, $userID) {
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

		$this->name        = $name;
		$this->description = $description;
		$this->created     = $created;
		$this->userID      = $userID;
	}

	public function getName() {
		return $this->name;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getDateCreated() {
		return $this->created;
	}

	public function getUserID() {
		return $this->userID;
	}
}