<?php

namespace comment\controller;

require_once("src/comment/view/NewComment.php");

class NewComment {
	private $post;

	private $project;

	private $commentHandeler;

	private $user;

	private $navigationView;

	private $newCommentView; 

	public function __construct(\post\model\Post $post,
								\project\model\Project $project,
								\user\model\User $user) {

		$this->post = $post;
		$this->project = $project;
		$this->user = $user;
		$this->commentHandeler = new \comment\model\CommentHandeler();

		$this->navigationView = new \common\view\Navigation();

		$this->newCommentView = new \comment\view\NewComment($this->post,
															 $this->project,
															 $this->user,
															 $this->commentHandeler);
	}

	public function showNewCommentForm() {
		return $this->newCommentView->getNewCommentForm();
	}

	public function addComment() {
		$this->newCommentView->addComment();
	}
}