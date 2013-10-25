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
	 * @param int $projectID
	 * @param string $name
	 * @param string $description
	 * @param date $created
	 * @param string $username
	 * @throws Exception If validation failes
	 */
	public function __construct($projectID, $name, $description, $created, $username) {
		if (!is_int($projectID)) {
			throw new \Exception("invalid postID");
		}

		if (!is_string($name) || $name == "") {
			throw new \Exception("invalid title");
		}

		if (!is_string($description) || $description == "") {
			throw new \Exception("invalid content");
		}

		if (!is_string($created) || $created == "") {
			throw new \Exception("invalid date");
		}

		if (!is_string($username) || $username == "") {
			throw new \Exception("invalid user");
		}

		$this->projectID  = $projectID;
		$this->name   = $name;
		$this->description = $description;
		$this->created   = $created;
		$this->username    = $username;
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
	 * @return string
	 */
	public function getCleanName() {
		return $this->generateCleanTitle($this->name);
	}

	/**
	 * Makes URI friendly title
	 * @param  string $title
	 * @return string
	 * @todo  fix duplication! Same as in Post
	 */
	private function generateCleanTitle($title) {
		$cleanTitle = preg_replace('/\s+/', ' ', $title);
		$cleanTitle = str_replace(' ', '-', $cleanTitle);
		$cleanTitle = strtolower($cleanTitle);

		return $cleanTitle;
	}
}