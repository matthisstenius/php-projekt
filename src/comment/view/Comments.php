<?php

namespace comment\view;

class Comments {
	private $post;

	private $postHandeler;

	public function __construct(\post\model\Post $post, \comment\model\CommentHandeler $commentHandeler) {
		$this->post = $post;
		$this->commentHandeler = $commentHandeler;
	}

	public function getComments() {
		$html = "";
		foreach ($this->commentHandeler->getComments($this->post) as $comment) {
			$html .= "<p>" . $comment->getComment() . "</p>";
			$html .= "<p>" . $comment->getDateAdded() . "</p>";
			$html .= "<p>" . $comment->getUsername() . "</p>";
		}
		
		return $html;
	}
}