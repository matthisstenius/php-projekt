<?php

namespace collaborator\model;

class Collaborator {
	private $collaboratorID;

	private $userID;

	private $projectID;
	private $username;

	public function __construct($collaboratorID = null, $userID, $projectID, $username) {
		$this->collaboratorID = $collaboratorID;
		$this->userID = $userID;
		$this->projectID = $projectID;
		$this->username = $username;
	}

	public function getCollaboratorID() {
		return $this->collaboratorID;
	}

	public function getUserID() {
		return $this->userID;
	}

	public function getProjectID() {
		return $this->projectID;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setCollaboratorID($collaboratorID) {
		$this->collaboratorID = $collaboratorID;
	}
}