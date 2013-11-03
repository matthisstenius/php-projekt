<?php

namespace comment\model;

class Comment {
	/**
	 * @var int
	 */
	private $comentID;

	/**
	 * @var string
	 */
	private $comment;

	/**
	 * @var int
	 */
	private $postID;

	/**
	 * @var date
	 */
	private $added;

	/**	
	 * @var int
	 */
	private $userID;

	/**
	 * @var string
	 */
	private $username;

	/**
	 * @param int $commentID
	 * @param string $comment
	 * @param int $postID
	 * @param date $added
	 * @param int $userID
	 * @param string $username
	 */
	public function __construct($commentID = null, $comment, $postID, $added, $userID, $username) {
		if (!is_int($commentID)) {
			throw new \Exception("Invalid commentID");
		}

		if (!is_string($comment) || $comment == "" || strlen($comment) > 500) {
			throw new \Exception("Invalid comment");
		}

		if (!is_int($postID)) {
			throw new \Exception("Invalid postID");
		}
		/**
		 * @todo check out date validation
		 */
		if (!is_string($added) || $added == "") {
			throw new \Exception("Invalid date");
		}

		if (!is_int($userID)) {
			throw new \Exception("Invalid userID");
		}

		if (!is_string($username) || $username == "") {
			throw new \Exception("Invalid comment");
		}


		$this->commentID = $commentID;
		$this->comment   = $comment;
		$this->postID    = $postID;
		$this->added     = $added;
		$this->userID    = $userID;
		$this->username    = $username;
	}

	/**
	 * @return int
	 */
	public function getCommentID() {
		return $this->commentID;
	}

	/**
	 * @return string
	 */
	public function getComment() {
		return $this->comment;
	}

	/**	
	 * @return int
	 */
	public function getPostID() {
		return $this->postID;
	}

	/**
	 * @return date
	 */
	public function getDateAdded() {
		return $this->added;
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
	public function getUsername() {
		return $this->username;
	}

	public function setCommentID($commentID) {
		$this->commentID = $commentID;
	}
}