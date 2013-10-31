<?php

namespace comment\controller;

class NewComment {
	/**
	 * @var post\model\Post
	 */
	private $post;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var comment\model\CommentHandeler
	 */
	private $commentHandeler;

	/**
	 * @var user\model\User
	 */
	private $user;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @var comment\view\NewComment
	 */
	private $newCommentView; 

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

		$this->newCommentView = new \comment\view\NewComment($this->post,
															 $this->project,
															 $this->user,
															 $this->commentHandeler);
	}

	/**
	 * @return string HTML
	 */
	public function showNewCommentForm() {
		return $this->newCommentView->getNewCommentForm();
	}

	public function addComment() {
		$this->newCommentView->addComment();
	}
}