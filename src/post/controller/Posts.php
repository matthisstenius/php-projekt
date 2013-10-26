<?php

namespace post\controller;

require_once("src/post/model/PostHandeler.php");
require_once("src/post/view/Posts.php");

class Posts {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var post\view\Post
	 */
	private $postsView;

	/**
	 * @param post\view\Post   $postView
	 * @param post\model\PostHandeler $postHandeler
	 */
	public function __construct(\post\model\PostHandeler $postHandeler) {
		$this->postHandeler = $postHandeler;
		$this->postsView = new \post\view\Posts($this->postHandeler);
	}

	/**
	 * @param  int $projectID
	 * @return string HTML
	 */
	public function showPosts($projectID) {
		return $this->postsView->getHTML($projectID);
	}
}