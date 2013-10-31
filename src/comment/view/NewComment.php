<?php

namespace comment\view;

class NewComment {
	private static $comment = "comment";
	private static $inputFaultyMessage = "comment::view::newComment::errorMessage";

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
	 * @return string HTML
	 */
	public function getNewCommentForm() {
		$html = "<h2>Add comment</h2>";

		$commentSrc = $this->navigationView->getCommentSrc($this->project->getProjectID(),
															\common\view\Filter::getCleanUrl($this->project->getName()),
															$this->post->getPostID(),
															\common\view\Filter::getCleanUrl($this->post->getTitle()));

		if (isset($_SESSION[self::$inputFaultyMessage])) {
			$html .= $_SESSION[self::$inputFaultyMessage];
			unset($_SESSION[self::$inputFaultyMessage]);
		}

		$html .= "<form class='pure-form pure-form-stacked comment-form' action='$commentSrc' method='POST'>
	 					<textarea class='comment-input pure-input-1' name='" . self::$comment . "' placeholder='Comment'></textarea>

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

	public function addComment() {
		try {
			$comment = new \comment\model\Comment(0, 
												$this->getComment(), 
												$this->post->getPostID(), 
												\Date('Y-m-d H:i'),
												$this->user->getUserID(),
												$this->user->getUsername());

			$this->commentHandeler->addComment($comment);

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