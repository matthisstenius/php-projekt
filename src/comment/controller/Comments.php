<?php

namespace comment\controller;

require_once("src/comment/view/Comments.php");

class Comments {
	private $post;

	private $commentHandeler;

	public function __construct(\post\model\Post $post) {
		$this->post = $post;
		$this->commentHandeler = new \comment\model\CommentHandeler();
		$this->commentView = new \comment\view\Comments($this->post, $this->commentHandeler);
	}

	public function showComments() {
		return $this->commentView->getComments();
	}
}