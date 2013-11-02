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
	 * @param project\model\Project $project
	 * @return array array of posts
	 */
	public function getPosts(\project\model\Project $project) {
		$posts = array();

		foreach ($this->postDAL->getPosts($project) as $row) {
			try {
				$posts[] = new Post(+$row['idPost'], $row['title'], $row['content'], +$row['userID'], $row['username'], Date($row['added']),
									+$row['projectID']);
			}

			catch (\Exception $e) {

			}
		}

		return $posts;
	}

	/**
	 * @param  int $postID
	 * @return post\model\Post
	 * @throws Exception If no post is found
	 */
	public function getPost($postID) {
		$row = $this->postDAL->getPost($postID);

		try {
			return new Post(+$row['idPost'], $row['title'], $row['content'], +$row['userID'], $row['username'], Date($row['added']),
							+$row['projectID']);
		}

		catch (\Exception $e) {

		}
	}

	/**
	 * @param post\model\Post $post
	 * @return  void
	 */
	public function addPost(\post\model\Post $post) {
		$postID = $this->postDAL->addPost($post);
		$post->setPostID($postID);
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
		$this->postDAL->deletePost($post);
	}
}