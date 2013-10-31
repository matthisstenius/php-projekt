<?php

namespace comment\view;

class EditComment {
	private static $comment = "comment";
	private static $inputFaultyMessage = "comment::view::editComment::errorMessage";

	/**
	 * @var post\model\Post
	 */
	private $post;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var user\model\User
	 */
	private $user;

	/**
	 * @var comment\model\CommentHandeler
	 */
	private $commentHandeler;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param post\model\Post       $post
	 * @param project\model\Project $project
	 * @param user\model\User       $user
	 */
	public function __construct(\post\model\Post $post,
				 				\project\model\Project $project,
				 				\user\model\User $user) {
		$this->post = $post;
		$this->project = $project;
		$this->user = $user;
		$this->commentHandeler = new \comment\model\CommentHandeler();
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @param  comment\model\Comment $comment
	 * @return string HTML
	 */
	public function getEditCommentForm(\comment\model\Comment $comment) {
		$html = "<h1>Edit comment</h1>";

		$editCommentSrc = $this->navigationView->getEditCommentSrc($this->project->getProjectID(),
															\common\view\Filter::getCleanUrl($this->project->getName()),
															$this->post->getPostID(),
															\common\view\Filter::getCleanUrl($this->post->getTitle()),
															$comment->getCommentID());

		if (isset($_SESSION[self::$inputFaultyMessage])) {
			$html .= $_SESSION[self::$inputFaultyMessage];
			unset($_SESSION[self::$inputFaultyMessage]);
		}

		$html .= "<form id='edit-comment' class='pure-form pure-form-stacked comment-form' action='$editCommentSrc' method='POST'>
						<input type='hidden' name='_method' value='put'>
	 					<textarea class='comment-input pure-input-1' name='" . self::$comment . "' 
	 					placeholder='Comment'>" . $comment->getComment() . "</textarea>

	 					<button class='btn btn-add'>Post Comment</button>
	 			</form>";

		return $html;
	}

	/**
	 * @return string
	 */
	private function getComment() {
		if (isset($_POST[self::$comment])) {
			return $_POST[self::$comment];
		}

		return "";
	}

	/**
	 * @param  comment\model\Comment $comment
	 * @return void
	 */
	public function editComment(\comment\model\Comment $comment) {
		try {
			$comment = new \comment\model\Comment($comment->getCommentID(), 
												$this->getComment(), 
												$this->post->getPostID(), 
												$comment->getDateAdded(),
												$this->user->getUserID(),
												$this->user->getUsername());

			$this->commentHandeler->editComment($comment);

			$this->navigationView->goToPost($this->project->getProjectID(),
											\common\view\Filter::getCleanUrl($this->project->getName()),
											$this->post->getPostID(),
											\common\view\Filter::getCleanUrl($this->post->getTitle()));
		}

		catch(\Exception $e) {
			$this->inputFaulty();
			$this->navigationView->goToPost($this->project->getProjectID(),
											\common\view\Filter::getCleanUrl($this->project->getName()),
											$this->post->getPostID(),
											\common\view\Filter::getCleanUrl($this->post->getTitle()));
		}
	}

	private function inputFaulty() {
		$_SESSION[self::$inputFaultyMessage] = "<p>Enter a comment</p>";
	}
}