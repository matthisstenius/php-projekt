<?php

namespace comment\model;

require_once("src/comment/model/Comment.php");
require_once("src/comment/model/CommentDAL.php");

class CommentHandeler {
	/**
	 * @var CommentDAL
	 */
	private $commentDAL;

	public function __construct() {
		$this->commentDAL = new CommentDAL();
	}

	/**
	 * @return Comment
	 */
	public function getComment($commentID) {
		$row = $this->commentDAL->getComment($commentID);

		try {
			$comment = new Comment(+$row['commentID'], $row['comment'], +$row['postID'], $row['added'], +$row['userID'], $row['username']);
			return $comment;
		}
		
		catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * @return array of Comments
	 */
	public function getComments(\post\model\Post $post) {
		$rows = $this->commentDAL->getComments($post);
		$comments = array();

		foreach ($rows as $row) {
			try {
				$comments[] = new Comment(+$row['commentID'], $row['comment'], +$row['postID'], $row['added'], 
											+$row['userID'], $row['username']);
			}

			catch (\Exception $e) {
				throw $e;
			}
		}

		return $comments;
	}

	/**
	 * @param Comment $comment
	 * @param void
	 */
	public function addComment(Comment $comment) {
		$commentID = $this->commentDAL->addComment($comment);
		$comment->setCommentID($commentID);
	}

	/**
	 * @param  Comment   $comment
	 * @return void
	 */
	public function editComment(Comment $comment) {
		$this->commentDAL->editComment($comment);
	}

	/**
	 * @param  Comment   $comment
	 * @return void
	 */
	public function deleteComment(Comment $comment) {
		$this->commentDAL->deleteComment($comment);
	}
}