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
	 * @param int $postID
	 * @param string $title
	 * @param string $content
	 * @param date $added
	 * @param string $username
	 * @throws Exception If validation failes
	 */
	public function __construct($postID, $title, $content, $added, $username) {
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

		$this->postID  = $postID;
		$this->title   = $title;
		$this->content = $content;
		$this->added   = $added;
		$this->username    = $username;
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
	 * @return string
	 */
	public function getCleanTitle() {
		return $this->generateCleanTitle($this->title);
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