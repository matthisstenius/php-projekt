<?php

namespace post\model;

class Post {
	/**
	 * @var int
	 */
	private $postID;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var date
	 */
	private $added;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $projectID;

	/**
	 * @var string
	 */
	private $userID;

	/**
	 * @param int $postID
	 * @param string $title
	 * @param string $content
	 * @param int $userID
	 * @param string $username
	 * @param date $added
	 * @param int $projectID
	 * @throws Exception If validation failes
	 */
	public function __construct($postID = null, $title, $content, $userID, $username, $added, $projectID) {
		if (!is_int($postID)) {
			throw new \Exception("invalid postID");
		}

		if (!is_string($title) || $title == "" || preg_match('/[^\wåäöÅÄÖ\s()?!]+/', $title)) {
			throw new \Exception("invalid title");
		}

		if (!is_string($content) || $content == "") {
			throw new \Exception("invalid content");
		}

		if (!is_string($added) || $added == "") {
			throw new \Exception("invalid date");
		}

		if (!is_string($username) || $username == "") {
			throw new \Exception("invalid user");
		}

		if (!is_int($projectID)) {
			throw new \Exception("invalid projectID");
		}

		if (!is_int($userID)) {
			throw new \Exception("invalid postID");
		}

		$this->postID    = $postID;
		$this->title     = $title;
		$this->content   = $content;
		$this->userID    = $userID;
		$this->username  = $username;
		$this->added     = $added;
		$this->projectID = $projectID;
		
	}

	/**
	 * @return int
	 */
	public function getPostID() {
		return $this->postID;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @return date
	 */
	public function getDateAdded() {
		return $this->added;
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
	public function getProjectID() {
		return $this->projectID;
	}

	/**
	 * @return int
	 */
	public function getUserID() {
		return $this->userID;
	}

	/**
	 * @param int $postID
	 */
	public function setPostID($postID) {
		$this->postID = $postID;
	}
}