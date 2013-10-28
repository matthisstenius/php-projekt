<?php

namespace post\model;

require_once("src/common/model/DALBase.php");
require_once("src/post/model/Post.php");

class PostDAL extends \common\model\DALBase {
	/**
	 * @return array
	 */
	public function getPosts($projectID) {
		$result = array();

		$stm = self::getDBConnection()->prepare("SELECT idPost, title, content, added, User.username, User_idUser
												 AS userID, projectID_Project AS projectID FROM Post
												 INNER JOIN User ON User.idUser = User_idUser
												 WHERE projectID_Project=:projectID");

		$stm->bindParam(':projectID', $projectID, \PDO::PARAM_INT);
		$stm->execute();

		while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}

		return $result;
	}

	/**
	 * @param  int $id
	 * @return array 
	 */
	public function getPost($postID) {
		$stm = self::getDBConnection()->prepare("SELECT idPost, title, content, added, User.username, User_idUser
												 AS userID, projectID_Project AS projectID FROM Post
												 INNER JOIN User ON User.idUser = User_idUser
												 WHERE idPost=:id");

		$stm->bindParam(':id', $postID, \PDO::PARAM_INT);

		$stm->execute();

		$row = $stm->fetch(\PDO::FETCH_ASSOC);

		return $row;
	}

	/**
	 * @param  post\model\Post $post
	 * @return int PostID
	 */
	public function addPost(\post\model\Post $post) {
		$pdo = self::getDBConnection();

		$stm = $pdo->prepare("INSERT INTO Post (title, content, added, projectID_Project, User_idUser) 
							  VALUES(:title, :content, :added, :projectID, :userID)");

		$title = $post->getTitle();
		$content = $post->getContent();
		$added = $post->getDateAdded();
		$projectID = $post->getProjectID();
		$userID = $post->getUserID();

		$stm->bindParam(':title', $title);
		$stm->bindParam(':content', $content);
		$stm->bindParam(':added', $added);
		$stm->bindParam(':projectID', $projectID);
		$stm->bindParam(':userID', $userID);

		$stm->execute();

		return +$pdo->lastInsertId();
	}

	/**
	 * @param  post\model\Post $post
	 * @return void
	 */
	public function editPost(\post\model\Post $post) {
		$stm = self::getDBConnection()->prepare("UPDATE Post SET title = :title, content = :content 
												 WHERE idPost = :postID");

		$postTitle = $post->getTitle();
		$postContent = $post->getContent();
		$postID = $post->getPostID();

		$stm->bindParam(':title', $postTitle, \PDO::PARAM_STR);
		$stm->bindParam(':content', $postContent, \PDO::PARAM_STR);
		$stm->bindParam(':postID', $postID, \PDO::PARAM_INT);

		$stm->execute();
	}

	/**
	 * @param  int $id
	 * @return void
	 */
	public function deletPost($id) {
		$stm = self::getDBConnection()->prepare('DELETE Post WHERE idPost = :id');

		$stm->bindParam(':id', $id, \PDO::PARAM_INT);

		$stm->execute();
	}
}