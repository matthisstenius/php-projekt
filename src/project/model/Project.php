<?php

namespace project\model;

class Project {
	/**
	 * @var int
	 */
	protected $projectID;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var date
	 */
	protected $created;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * @var int
	 */
	protected $userID;

	/**
	 * @param int $projectID
	 * @param string $name
	 * @param string $description
	 * @param date $created
	 * @param string $username
	 * @param int $userID
	 * @throws Exception If validation failes
	 */
	public function __construct($projectID, $name, $description, $created, $username, $userID) {
		if (!is_int($projectID)) {
			throw new \Exception("invalid projectID");
		}

		if (!is_string($name) || $name == "") {
			throw new \Exception("invalid name");
		}

		if (!is_string($description) || $description == "") {
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

		$this->projectID  = $projectID;
		$this->name   = $name;
		$this->description = $description;
		$this->created   = $created;
		$this->username    = $username;
		$this->userID = $userID;
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
	 * @return string
	 */
	public function getCleanName() {
		return $this->generateCleanTitle($this->name);
	}

	/**
	 * Makes URI friendly title
	 * @param  string $title
	 * @return string
	 * @todo  fix duplication! Same as in Post move this to common view
	 */
	private function generateCleanTitle($title) {
		$cleanTitle = preg_replace('/\s+/', ' ', $title);
		$cleanTitle = str_replace(' ', '-', $cleanTitle);
		$cleanTitle = strtolower($cleanTitle);

		return $cleanTitle;
	}
}