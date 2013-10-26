<?php

namespace common\view;

class Navigation {
	
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