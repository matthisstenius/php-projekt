<?php

namespace common\view;

class Navigation {
	public function compareParams($url, $param, $otherParam) {
		if (\common\view\Filter::getCleanUrl($param) != $otherParam) {
			header("Location: $url");
		}
	}

	public function gotoFrontPage() {
		header("Location: /php-projekt/");
	}

	/**
	 * @param  int $projectID
	 * @param  int $postID
	 * @param  string $title
	 * @return void
	 */
	public function goToPost($projectID, $projectName, $postID, $title) {
		header("Location: /php-projekt/project/$projectID/$projectName/post/$postID/$title");
	}

	/**
	 * @param  int $projectID
	 * @return void
	 */
	public function gotoNewPost($projectID, $projectName) {
		header("Location: /php-projekt/project/$projectID/$projectName/newPost");
	}

	public function gotoProjects() {
		header("Location: /php-projekt/projects");
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
	
	public function gotoEditPost($projectID, $projectName, $postID, $postName) {
		header("Location: /php-projekt/project/$projectID/$projectName/edit/post/$postID/$postName");
	}

	public function gotoLoginPage() {
		header("Location: /php-projekt/login");
	}

	public function gotoRegisterPage() {
		header("Location: /php-projekt/register");
	}

	public function gotoErrorPage() {
		header("Location: /php-projekt/500");
	}

	/**
	 * @return string
	 */
	public function getHomeSrc() {
		return "/php-projekt";
	}

	public function getProjectsSrc() {
		return "/php-projekt/projects";
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
	public function getPostLink($projectID, $projectName, $postID, $postName) {
		return "/php-projekt/project/$projectID/$projectName/post/$postID/$postName";
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

	/**
	 * @return string
	 */
	public function getEditPostSrc($projectID, $projectName, $postID, $postName) {
		return "/php-projekt/project/$projectID/$projectName/edit/post/$postID/$postName";
	}

	/**
	 * @return string
	 */
	public function getDeletePostSrc($projectID, $projectName, $postID) {
		return "/php-projekt/project/$projectID/$projectName/remove/post/$postID";
	}

	/**
	 * @return string
	 */
	public function getLoginSrc() {
		return "/php-projekt/login";
	}

	/**
	 * @return string
	 */
	public function getLogoutSrc() {
		return "/php-projekt/logout";
	}

	/**
	 * @return string
	 */
	public function getRegisterSrc() {
		return "/php-projekt/register";
	}

	/**
	 * @return string
	 */
	public function getUserPageSrc($userID, $username) {
		return "/php-projekt/user/$userID/$username";
	}

	public function getDeleteAccountSrc($userID, $username) {
		return "/php-projekt/remove/user/$userID/$username";
	}
}