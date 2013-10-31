<?php

namespace comment\view;

class NewComment {
	private static $comment = "comment";
	private static $inputFaultyMessage = "comment::view::newComment::errorMessage";
	private $post;

	private $project;

	private $user;

	private $commentHandeler;

	public function __construct(\post\model\Post $post,
				 				\project\model\Project $project,
				 				\user\model\User $user,
				 				\comment\model\CommentHandeler $commentHandeler) {
		$this->post = $post;
		$this->project = $project;
		$this->user = $user;
		$this->commentHandeler = $commentHandeler;
		$this->navigationView = new \common\view\Navigation();
	}

	public function getNewCommentForm() {
		$html = "<h1>Add comment</h1>";

		$commentSrc = $this->navigationView->getCommentSrc($this->project->getProjectID(),
															\common\view\Filter::getCleanUrl($this->project->getName()),
															$this->post->getPostID(),
															\common\view\Filter::getCleanUrl($this->post->getTitle()));

		if (isset($_SESSION[self::$inputFaultyMessage])) {
			$html .= $_SESSION[self::$inputFaultyMessage];
			unset($_SESSION[self::$inputFaultyMessage]);
		}

		$html .= "<form class='pure-form pure-form-stacked' action='$commentSrc' method='POST'>
	 					<textarea class='comment-input' name='" . self::$comment . "' placeholder='Comment'></textarea>

	 					<button class='btn btn-add'>Post Comment</button>
	 			</form>";

		return $html;
	}

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
												\Date('y-m-d'),
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