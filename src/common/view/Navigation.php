<?php

namespace common\view;

class Navigation {
	public function gotoFrontPage() {
		header("Location: /php-projekt/");
	}

	/**
	 * @param  int $projectID
	 * @param  int $postID
	 * @param  string $title
	 * @return void
	 */
	public function goToPost($projectID, $postID, $title) {
		header("Location: /php-projekt/project/$projectID/post/$postID/$title");
	}

	/**
	 * @param  int $projectID
	 * @return void
	 */
	public function gotoNewPost($projectID, $projectName) {
		header("Location: /php-projekt/project/$projectID/$projectName/newPost");
	}

	/**
	 * @param  int $projectID
	 * @param  string $name
	 * @return void
	 */
	public function goToProject($projectID, $name) {
		header("Location: /php-projekt/project/$projectID/$name");
	}

	public function gotoNewProject() {
		header("Location: /php-projekt/newProject");
	}

	public function gotoEditProject($projectID, $projectName) {
		header("Location: /php-projekt/edit/project/$projectID/$projectName");
	}
	
	/**
	 * @return string
	 */
	public function getHomeSrc() {
		return "/php-projekt";
	}

	/**
	 * @param  int $porjectID
	 * @param  string $cleanName
	 * @return string
	 */
	public function getProjectSrc($projectID, $cleanName) {
		return "/php-projekt/project/$projectID/$cleanName";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return string
	 */
	public function getEditProjectSrc($projectID, $projectName) {
		return "/php-projekt/edit/project/$projectID/$projectName";
	}

	/**
	 * @param  int $projectID
	 * @return string
	 */
	public function getDeleteProjectSrc($projectID) {
		return "/php-projekt/remove/project/$projectID";
	}

	/**
	 * @param  int $projectID
	 * @param  int $postID
	 * @param  string $postName
	 * @return string 
	 */
	public function getPostLink($projectID, $postID, $postName) {
		return "/php-projekt/project/$projectID/post/$postID/$postName";
	}

	/**
	 * @return string
	 */
	public function getAddNewProjectSrc() {
		return "/php-projekt/newProject";
	}

	/**
	 * @param  int $projectID
	 * @return string
	 */
	public function getNewPostSrc($projectID, $projectName) {
		return "/php-projekt/project/$projectID/$projectName/newPost";
	}
}