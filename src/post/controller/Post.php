<?php

namespace post\controller;

require_once('src/post/view/Post.php');

class Post {
	/**
	 * @var post\model
	 */
	private $postsModel;

	/**
	 * @param post\model\Posts $postsModel
	 */
	public function __construct(\post\model\Posts $postsModel) {
		$this->postsModel = $postsModel;
		$this->postView = new \post\view\Post($this->postsModel);
	}

	/**
	 * @param  int $id
	 * @return string HTMLzx
	 */
	public function showPost($id, $title) {
		return $this->postView->getPostHTML($id, $title);

	}
}