<?php

namespace comment\model;

class CommentDAL extends \common\model\DALBase {
	/**
	 * @return array of commentrows
	 */
	public function getComments(\post\model\Post $post) {
		$db = self::getDBConnection();

		$stm = $db->prepare("SELECT idComment AS commentID, comment, Post_idPost AS postID, added, userID, User.username
							 FROM Comment
							 INNER JOIN User ON User.idUser = userID
							 WHERE Post_idPost = :postID");

		$postID = $post->getPostID();
		$stm->bindParam(':postID', $postID, \PDO::PARAM_STR);

		$stm->execute();

		$result = array();

		while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
			$result[] = $row;
		}

		return $result;
	}

	/**
	 * @param  Comment $comment
	 * @return int commentID
	 */
	public function addComment(Comment $comment) {
		try {
			$pdo = self::getDBConnection();

			$stm = $pdo->prepare("INSERT INTO Comment (comment, Post_idPost, added, userID)
								  VALUES(:comment, :postID, :added, :userID)");



			$commentContent = $comment->getComment();
			$postID = $comment->getPostID();
			$added = $comment->getDateAdded();
			$userID = $comment->getUserID();

			$stm->bindParam(':comment', $commentContent);
			$stm->bindParam(':postID', $postID);
			$stm->bindParam(':added', $added);
			$stm->bindParam(':userID', $userID);

			$stm->execute();

			return +$pdo->lastInsertId();
		}

		catch (\Exception $e) {
			var_dump($e->getMessage());
		}
	}

	/**
	 * @param  Comment $comment
	 * @return void
	 */
	public function editComment(Comment $comment) {
		$pdo = self::getDBConnection();

		$stm = $pdo->prepare("UPDATE Comment SET comment = :comment, Post_idPost = :postID, added = :added,
							  userID = :userID WHERE idComment = :commentID");

		$comment = $comment->getComment();
		$postID = $comment->getPostID();
		$added = $comment->getDateAdded();
		$userID = $comment->getUserID();

		$stm->bindParam(':comment', $comment, \PDO::PARAM_STR);
		$stm->bindParam(':postID', $postID, \PDO::PARAM_INT);
		$stm->bindParam(':added', $added);
		$stm->bindParam(':userID', $userID, \PDO::PARAM_INT);

		$stm->execute();
	}

	/**
	 * @param  Comment $comment
	 * @return void
	 */
	public function deleteComment(Comment $comment) {
		$stm = self::getDBConnection()->prepare('DELETE FROM Comment WHERE idComment =  :commentID');

		$commentID = $comment->getCommentID();

		$stm->bindParam(':commentID', $commentID, \PDO::PARAM_INT);

		$stm->execute();
	}
}