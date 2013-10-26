<?php

namespace post\model;

/**
 * Extends Post. Used when adding new Posts
 */
class NewPost extends Post {

	/**
	 * @param string $title
	 * @param string $content
	 * @param date $added
	 * @param int $projectID
	 * @param int $userID
	 * @throws Exception If validation fails
	 */
	public function __construct($title, $content, $added, $projectID, $userID) {
		if (!is_string($title) || $title == "") {
			throw new \Exception("invalid title");
		}

		if (!is_string($content) || $content == "") {
			throw new \Exception("invalid content");
		}

		if (!is_string($added) || $added == "") {
			throw new \Exception("invalid date");
		}

		if (!is_int($projectID)) {
			throw new \Exception("invalid projectID");
		}

		if (!is_int($userID)) {
			throw new \Exception("invalid projectID");
		}

		$this->title     = $title;
		$this->content   = $content;
		$this->added     = $added;
		$this->projectID = $projectID;
		$this->userID    = $userID;
	}

	/**
	 * @param int $postID
	 */
	public function setPostID($postID) {
		$this->postID = $postID;
	}
}