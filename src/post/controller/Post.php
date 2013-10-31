<?php

namespace post\controller;

require_once('src/post/view/Post.php');
require_once('src/comment/controller/NewComment.php');
require_once('src/comment/controller/Comments.php');
require_once('src/comment/model/CommentHandeler.php');

class Post {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var post\view\Post
	 */
	private $postView;

	/**
	 * @param post\model\PostsHandeler $postHandeler
	 * @param project\model\Project $project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, 
								\project\model\Project $project,
								\post\model\Post $post,
								\user\model\User $user) {

		$this->postHandeler = $postHandeler;
		$this->project = $project;
		$this->post = $post;
		$this->user = $user;

		$this->postView = new \post\view\Post($this->postHandeler, $this->project, $this->post);

		$this->commentsController = new \comment\controller\Comments($this->post);
		$this->newCommentController = new \comment\controller\NewComment($this->post,
																	 $this->project,
																	 $this->user);
	}

	/**
	 * @param  post\model\Post $post
	 * @return string HTML
	 */
	public function showPost() {
		return $this->postView->getPostHTML($this->newCommentController->showNewCommentForm(),
											$this->commentsController->showComments());

	}
}