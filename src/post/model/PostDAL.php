<?php

namespace post\model;

require_once("src/common/model/DALBase.php");
require_once("src/post/model/Post.php");

class PostDAL extends \common\model\DALBase {
	/**
	 * @return array
	 */
	public function getPosts($id) {
		$result = array();

		$stm = self::getDBConnection()->prepare("SELECT idPost, title, content, added, User.username FROM Post
												 INNER JOIN User ON User.idUser = User_idUser
												 WHERE projectID_Project=:projectID");

		$stm->bindParam(':projectID', $id, \PDO::PARAM_INT);
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
	public function getPost($id) {
		$stm = self::getDBConnection()->prepare("SELECT idPost, title, content, added, User.username FROM Post
												 INNER JOIN User ON User.idUser = User_idUser
												 WHERE idPost=:id");

		$stm->bindParam(':id', $id, \PDO::PARAM_INT);

		$stm->execute();

		$row = $stm->fetch(\PDO::FETCH_ASSOC);

		return $row;
	}

	/**
	 * @param  post\model\Post $post
	 * @return void
	 */
	public function addPost(\post\model\Post $post) {
		$stm = self::getDBConnection()->prepare("INSERT INTO Post title, content, added VALUES(:title, :content, :added)");

		$stm->bindParam(':title', $post->getTitle(), \PDO::PARAM_STRING);
		$stm->bindParam(':content', $post->getContent(), \PDO::PARAM_STRING);
		$stm->bindParam(':added', $post->getDateAdded(), \PDO::PARAM_DATE);

		$stm->execute();
	}

	/**
	 * @param  post\model\Post $post
	 * @return void
	 */
	public function editPost(\post\model\Post $post) {
		$stm = self::getDBConnection()->prepare("UPDATE Post SET title = :title, content = :content WHERE idPost = :id");

		$stm->bindParam(':title', $post->getTitle(), \PDO::PARAM_STRING);
		$stm->bindParam(':content', $post->getContent(), \PDO::PARAM_STRING);

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