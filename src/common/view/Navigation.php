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
	public function goToPost($projectID, $projectName, $postID, $title) {
		header("Location: /php-projekt/project/$projectID/$projectName/post/$postID/$title");
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return void
	 */
	public function gotoNewPost($projectID, $projectName) {
		header("Location: /php-projekt/project/$projectID/$projectName/new/post");
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
		header("Location: /php-projekt/new/project");
	}

	/**
	 * Redirect to project
	 * @param  int $projectID
	 * @param  string $projectName
	 */
	public function gotoEditProject($projectID, $projectName) {
		header("Location: /php-projekt/edit/project/$projectID/$projectName");
	}
	
	/**
	 * Redirect to post
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @param  string $postName
	 */
	public function gotoEditPost($projectID, $projectName, $postID, $postName) {
		header("Location: /php-projekt/project/$projectID/$projectName/edit/post/$postID/$postName");
	}

	/**
	 * Redirect to collaborators
	 * @param  int $projectID   
	 * @param  string $projectName 
	 */
	public function gotoCollaborators($projectID, $projectName) {
		header("Location: /php-projekt/project/$projectID/$projectName/collaborators");
	}

	/**
	 * Redirect to loginpage
	 */
	public function gotoLoginPage() {
		header("Location: /php-projekt/login");
	}

	/**
	 * Redirect registerpage
	 */
	public function gotoRegisterPage() {
		header("Location: /php-projekt/register");
	}

	/**
	 * Redirect to error page
	 */
	public function gotoErrorPage() {
		header("Location: /php-projekt/500");
	}

	/**
	 * @return string
	 */
	public function getHomeSrc() {
		return "/php-projekt";
	}

	/**
	 * @return string abslolute path to current project
	 */
	public function getProjectShareLink($projectID, $projectName) {
		return "http://" . $_SERVER['HTTP_HOST'] . "/php-projekt/project/$projectID/$projectName";
	}

	/**
	 * @return string
	 */
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
	 * @param  string $projectName
	 * @return string
	 */
	public function getCollaboratorsSrc($projectID, $projectName) {
		return "/php-projekt/project/$projectID/$projectName/collaborators";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $collaboratorID
	 * @return string
	 */
	public function getRemoveCollaboratorSrc($projectID, $projectName, $collaboratorID) {
		return "/php-projekt/project/$projectID/$projectName/remove/collaborator/$collaboratorID";
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
		return "/php-projekt/new/project";
	}

	/**
	 * @param  int $projectID
	 * @param string $projectName
	 * @return string
	 */
	public function getNewPostSrc($projectID, $projectName) {
		return "/php-projekt/project/$projectID/$projectName/new/post";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @param  string $postName
	 * @return string
	 */
	public function getEditPostSrc($projectID, $projectName, $postID, $postName) {
		return "/php-projekt/project/$projectID/$projectName/edit/post/$postID/$postName";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @return string
	 */
	public function getDeletePostSrc($projectID, $projectName, $postID) {
		return "/php-projekt/project/$projectID/$projectName/remove/post/$postID";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @param  string $postName
	 * @return string
	 */
	public function getCommentSrc($projectID, $projectName, $postID, $postName) {
		return "/php-projekt/project/$projectID/$projectName/post/$postID/$postName/comment";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @param  string $postName
	 * @param  int $commentID
	 * @return string
	 */
	public function getEditCommentSrc($projectID, $projectName, $postID, $postName, $commentID) {
		return "/php-projekt/project/$projectID/$projectName/post/$postID/$postName/edit/comment/$commentID";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @param  string $postName
	 * @param  int $commentID
	 * @return string
	 */
	public function getDeleteCommentSrc($projectID, $projectName, $postID, $postName, $commentID) {
		return "/php-projekt/project/$projectID/$projectName/post/$postID/$postName/comment/$commentID";
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
	 * @param  int $userID
	 * @param  string $username
	 * @return string
	 */
	public function getUserPageSrc($userID, $username) {
		return "/php-projekt/user/$userID/$username";
	}

	/**
	 * @param  int $userID
	 * @param  string $username
	 * @return string
	 */
	public function getDeleteAccountSrc($userID, $username) {
		return "/php-projekt/remove/user/$userID/$username";
	}
}