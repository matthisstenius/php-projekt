<?php

namespace comment\controller;

class DeleteComment {
	/**
	 * @var comment\model\Comment
	 */
	private $comment;

	/**
	 * @var comment\model\CommentHandeler
	 */
	private $commentHandeler;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var post\model\Post
	 */
	private $post;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param comment\model\Comment         $comment
	 * @param comment\model\CommentHandeler $commentHandeler
	 * @param project\model\Project         $project
	 * @param post\model\Post               $post
	 */
	public function __construct(\comment\model\Comment $comment, 
								\comment\model\CommentHandeler $commentHandeler,
								\project\model\Project $project,
								\post\model\Post $post) {

		$this->comment = $comment;
		$this->commentHandeler = $commentHandeler;
		$this->project = $project;
		$this->post = $post;
		$this->navigationView = new \common\view\Navigation();
	}

	public function deleteComment() {
		$this->commentHandeler->deleteComment($this->comment);

		$this->navigationView->goToPost($this->project->getProjectID(),
										\common\view\Filter::getCleanUrl($this->project->getName()),
										$this->post->getPostID(),
										\common\view\Filter::getCleanUrl($this->post->getTitle()));
	}
}