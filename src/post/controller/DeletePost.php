<?php

namespace post\controller;

class DeletePost {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 * @param int $postID
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, $postID) {
		$this->postHandeler = $postHandeler;
		$this->navigationView = new \common\view\Navigation();

		try {
			$this->post = $this->postHandeler->getPost($postID);
		}

		catch (\Exception $e) {
			$this->navigationView->gotoErrorPage();
		}
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return void
	 */
	public function deletePost($projectID, $projectName) {
		$this->postHandeler->deletePost($this->post);
		$this->navigationView->goToProject($projectID, $projectName);
	}
}