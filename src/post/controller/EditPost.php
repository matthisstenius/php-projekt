<?php

namespace post\controller;

require_once("src/post/view/EditPost.php");

class EditPost {
	private $postHandeler;

	public function __construct(\post\model\PostHandeler $postHandeler, $postID) {
		$this->postHandeler = $postHandeler;
		$this->navigationView = new \common\view\Navigation();

		try {
			$this->post = $this->postHandeler->getPost($postID);
			$this->editPostView = new \post\view\EditPost($this->postHandeler, $this->post, $this->navigationView);
		}
		
		catch (\Exception $e) {
			$this->navigationView->gotoErrorPage();
		}

	}

	public function showEditPostForm($projectID, $projectName, $postName) {
		return $this->editPostView->getEditPostForm($projectID, $projectName, $postName);
	}

	public function editPost($projectID, $projectName) {
		$this->editPostView->editPost($projectID, $projectName);
	}
}