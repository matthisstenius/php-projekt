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
	 * @param int $postID
	 * @param string $title
	 * @param string $content
	 * @param date $added
	 * @throws Exception If validation failes
	 */
	public function __construct($postID, $title, $content, $added) {
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

		$this->postID = $postID;
		$this->title = $title;
		$this->content = $content;
		$this->added = $added;
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
}