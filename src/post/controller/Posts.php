<?php

namespace post\controller;

require_once("src/post/model/Posts.php");
require_once("src/post/view/Posts.php");

class Posts {
	/**
	 * @var post\modelPosts
	 */
	private $postsModel;

	/**
	 * @var post\view\Post
	 */
	private $postView;

	/**
	 * @param post\view\Post   $postView
	 * @param post\model\Posts $postsModel
	 */
	public function __construct(\post\model\Posts $postsModel) {
		$this->postsModel = $postsModel;
		$this->postView = new \post\view\Posts($this->postsModel);
	}

	/**
	 * @return string HTML
	 */
	public function showPosts() {
		return $this->postView->getHTML();
	}
}