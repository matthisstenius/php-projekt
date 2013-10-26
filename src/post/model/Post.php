<?php

namespace post\model;

class Post {
	/**
	 * @var int
	 */
	protected $postID;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $content;

	/**
	 * @var date
	 */
	protected $added;

	/**
	 * @var string
	 */
	protected $username;

	/**
	 * @var string
	 */
	protected $projectID;

	/**
	 * @var string
	 */
	protected $userID;

	/**
	 * @param int $postID
	 * @param string $title
	 * @param string $content
	 * @param date $added
	 * @param string $username
	 * @throws Exception If validation failes
	 */
	public function __construct($postID, $title, $content, $added, $username, $projectID, $userID) {
		if (!is_int($postID)) {
			throw new \Exception("invalid postID");
		}

		if (!is_string($title) || $title == "") {
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

		$this->postID  = $postID;
		$this->title   = $title;
		$this->content = $content;
		$this->added   = $added;
		$this->username    = $username;
		$this->projectID = $projectID;
		$this->userID = $userID;
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
	 * @return string
	 */
	public function getCleanTitle() {
		return $this->generateCleanTitle($this->title);
	}

	public function getExcerpt() {
		$content = $this->getContent();

		if (count($content > 140)) {
			return substr($content, -140);
		}

		else {
			return $this->getContent();
		}
	}
	/**
	 * Makes URI friendly title
	 * @param  string $title
	 * @return string
	 */
	private function generateCleanTitle($title) {
		$cleanTitle = preg_replace('/\s+/', ' ', $title);
		$cleanTitle = str_replace(' ', '-', $cleanTitle);
		$cleanTitle = strtolower($cleanTitle);

		return $cleanTitle;
	}
}