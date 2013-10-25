<?php

namespace post\controller;

require_once('src/post/view/Post.php');

class Post {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @param post\model\PostsHandeler $postHandeler
	 */
	public function __construct(\post\model\PostHandeler $postHandeler) {
		$this->postHandeler = $postHandeler;
		$this->postView = new \post\view\Post($this->postHandeler);
	}

	/**
	 * @param  int $id
	 * @return string HTMLzx
	 */
	public function showPost($projectID, $id, $title) {
		return $this->postView->getPostHTML($projectID, $id, $title);

	}
}