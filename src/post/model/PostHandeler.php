<?php

namespace post\model;

require_once("src/post/model/PostDAL.php");

class PostHandeler {
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
	public function getPosts($id) {
		$posts = array();

		foreach ($this->postDAL->getPosts($id) as $row) {
			$posts[] = new Post(+$row['idPost'], $row['title'], $row['content'], Date($row['added']), $row['username']);
		}

		return $posts;
	}

	/**
	 * @param  int $post
	 * @return post\model\Post
	 * @throws Exception If no post is found
	 */
	public function getPost($id) {
		if ($row = $this->postDAL->getPost($id)) {
			return new Post(+$row['idPost'], $row['title'], $row['content'], Date($row['added']), $row['username']);
		}
		
		throw new \Exception("No post found");
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