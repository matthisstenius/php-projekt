<?php

namespace post\controller;

class DeletePost {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var post\model\Post
	 */
	private $post;

	/**
	 * @var post\model\Post
	 */
	private $project;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 * @param post\model\Post $post
	 * @param project\model\Project $project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, 
								\post\model\Post $post,
								\project\model\Project $project) {

		$this->postHandeler = $postHandeler;
		$this->post = $post;
		$this->project = $project;

		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return void
	 */
	public function deletePost() {
		$this->postHandeler->deletePost($this->post);
		$this->navigationView->goToProject($this->project->getProjectID(),
				 							\common\view\Filter::getCleanUrl($this->project->getName()));
	}
}