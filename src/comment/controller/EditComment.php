<?php

namespace comment\controller;

class EditComment {
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
	private $editCommentView; 

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

		$this->editCommentView = new \comment\view\EditComment($this->post,
															 $this->project,
															 $this->user,
															 $this->commentHandeler);
	}

	/**
	 * @param  comment\model\Comment $comment
	 * @return void
	 */
	public function editComment(\comment\model\Comment $comment) {
		$this->editCommentView->editComment($comment);
	}
}