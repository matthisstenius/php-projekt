<?php

namespace post\controller;

class Post {
	public function __construct() {
		$this->postView = new \post\view\Post();
	}

	public function showPosts() {
		return $this->postView->getHTML();
	}
}