<?php

namespace post\controller;

require_once('src/post/view/Post.php');
require_once("src/comment/view/NewComment.php");
require_once("src/comment/view/EditComment.php");

class Post {
	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var post\model\Post
	 */
	private $post;

	/**
	 * @var user\model\User
	 */
	private $user;

	/**
	 * @var array of comment\model\Comment
	 */
	private $comments;

	/**
	 * @var comment\view\NewComment
	 */
	private $newCommentView;

	/**
	 * @var comment\view\editComment
	 */
	private $editCommentView;

	/**
	 * @var post\view\Post
	 */
	private $postView;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 * @param project\model\Project   $project
	 * @param post\model\Post         $post
	 * @param user\model\User         $user
	 * @param array                	  $comments     array of comment\model\Comment
	 */
	public function __construct(\project\model\Project $project,
								\post\model\Post $post,
								\user\model\User $user,
								$comments) {

		$this->project = $project;
		$this->post = $post;
		$this->user = $user;
		$this->comments = $comments;

		$this->newCommentView = new \comment\view\NewComment($this->post, $this->project, $this->user);
		$this->editCommentView = new \comment\view\EditComment($this->post, $this->project, $this->user);

		$this->postView = new \post\view\Post($this->project, $this->post, $this->comments, $this->user);
	}

	/**
	 * @return string HTML
	 */
	public function showPost() {
		return $this->postView->getPostHTML() . $this->newCommentView->getNewCommentForm();
	}

	/**
	 * @param  comment\model\Comment $comment
	 * @return string HTML
	 */
	public function showPostWithEditComment(\comment\model\Comment $comment) {
		return $this->postView->getPostHTML() . $this->editCommentView->getEditCommentForm($comment);
	}
}