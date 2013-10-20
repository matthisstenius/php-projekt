<?php

namespace post\model;

require_once("src/post/model/PostDAL.php");

class Posts {
	/**
	 * @var post\model\PostDAL
	 */
	private $postDAL;

	public function __construct() {
		$this->postDAL = new PostDAL();
	}

	/**
	 * @return array array of posts
	 */
	public function getPosts() {
		return $this->postDAL->getPosts();
	}

	/**
	 * @param  post\model\Post $post
	 * @return post\model\Post
	 */
	public function getPost(\post\model\Post $post) {
		return $this->postDAL->getPost($post->getPostID());
	}

	/**
	 * @param post\model\Post $post
	 * @return  void
	 */
	public function addPost(\post\model\Post $post) {
		$this->postDAL->addPost($post);
	}

	/**
	 * @param post\model\Post $post
	 * @return  void
	 */
	public function editPost(\post\model\Post $post) {
		$this->postDAL->editPost($post);
	}

	/**
	 * @param post\model\Post $post
	 * @return  void
	 */
	public function deletePost(\post\model\Post $post) {
		$this->postDAL->deletePost($post->getPostID());
	}
}