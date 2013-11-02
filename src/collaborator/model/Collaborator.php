<?php

namespace collaborator\model;

class Collaborator {
	/**
	 * @var int
	 */
	protected $collaboratorID;

	/**
	 * @var int
	 */
	private $userID;

	/**
	 * @var int
	 */
	private $projectID;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @param int $collaboratorID
	 * @param int $userID
	 * @param int $projectID
	 * @param string $username
	 * @throws Exception If validation failes
	 */
	public function __construct($collaboratorID = null, $userID, $projectID, $username) {
		if (!is_int($collaboratorID)) {
			throw new \Exception("Invalid collaboratorID");
			
		}

		if (!is_int($userID)) {
			throw new \Exception("Invalid userID");
			
		}

		if (!is_int($projectID)) {
			throw new \Exception("Invalid invalidID");
			
		}

		if (!is_string($username) || $username == "") {
			throw new \Exception("Invalid username");
			
		}

		$this->collaboratorID = $collaboratorID;
		$this->userID = $userID;
		$this->projectID = $projectID;
		$this->username = $username;
	}

	/**
	 * @return int
	 */
	public function getCollaboratorID() {
		return $this->collaboratorID;
	}

	/**
	 * @return int
	 */
	public function getUserID() {
		return $this->userID;
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
	public function getUsername() {
		return $this->username;
	}

	public function setCollaboratorID($collaboratorID) {
		$this->collaboratorID = $collaboratorID;
	}
}