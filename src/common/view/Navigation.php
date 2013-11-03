<?php

namespace common\view;

class Navigation {
	/**
	 * Chnage this to correspond the the basepath on your server. Usually /
	 */
	private static $basepath = "/php-projekt/";

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
		header("Location: " . self::$basepath . "project/$projectID/$projectName/post/$postID/$title");
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return void
	 */
	public function gotoNewPost($projectID, $projectName) {
		header("Location: " . self::$basepath . "project/$projectID/$projectName/new/post");
	}

	public function gotoProjects() {
		header("Location: " . self::$basepath . "projects");
	}

	/**
	 * @param  int $projectID
	 * @param  string $name
	 * @return void
	 */
	public function goToProject($projectID, $name) {
		header("Location: " . self::$basepath . "project/$projectID/$name");
	}

	public function gotoNewProject() {
		header("Location: " . self::$basepath . "new/project");
	}

	/**
	 * Redirect to project
	 * @param  int $projectID
	 * @param  string $projectName
	 */
	public function gotoEditProject($projectID, $projectName) {
		header("Location: " . self::$basepath . "edit/project/$projectID/$projectName");
	}
	
	/**
	 * Redirect to post
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @param  string $postName
	 */
	public function gotoEditPost($projectID, $projectName, $postID, $postName) {
		header("Location: " . self::$basepath . "project/$projectID/$projectName/edit/post/$postID/$postName");
	}

	/**
	 * Redirect to collaborators
	 * @param  int $projectID   
	 * @param  string $projectName 
	 */
	public function gotoCollaborators($projectID, $projectName) {
		header("Location: " . self::$basepath . "project/$projectID/$projectName/collaborators");
	}

	/**
	 * Redirect to loginpage
	 */
	public function gotoLoginPage() {
		header("Location: " . self::$basepath . "login");
	}

	/**
	 * Redirect registerpage
	 */
	public function gotoRegisterPage() {
		header("Location: " . self::$basepath . "register");
	}

	/**
	 * Redirect to error page
	 */
	public function gotoErrorPage() {
		header("Location: " . self::$basepath . "500");
	}

	/**
	 * @return string
	 */
	public function getHomeSrc() {
		return self::$basepath;
	}

	/**
	 * @return string abslolute path to current project
	 */
	public function getProjectShareLink($projectID, $projectName) {
		return "http://" . $_SERVER['HTTP_HOST'] .  self::$basepath . "project/$projectID/$projectName";
	}

	/**
	 * @return string
	 */
	public function getProjectsSrc() {
		return self::$basepath . "projects";
	}
	
	/**
	 * @param  int $porjectID
	 * @param  string $cleanName
	 * @return string
	 */
	public function getProjectSrc($projectID, $cleanName) {
		return self::$basepath . "project/$projectID/$cleanName";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return string
	 */
	public function getEditProjectSrc($projectID, $projectName) {
		return self::$basepath . "edit/project/$projectID/$projectName";
	}

	/**
	 * @param  int $projectID
	 * @return string
	 */
	public function getDeleteProjectSrc($projectID) {
		return self::$basepath . "remove/project/$projectID";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return string
	 */
	public function getCollaboratorsSrc($projectID, $projectName) {
		return self::$basepath . "project/$projectID/$projectName/collaborators";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $collaboratorID
	 * @return string
	 */
	public function getRemoveCollaboratorSrc($projectID, $projectName, $collaboratorID) {
		return self::$basepath . "project/$projectID/$projectName/remove/collaborator/$collaboratorID";
	}

	/**
	 * @param  int $projectID
	 * @param  int $postID
	 * @param  string $postName
	 * @return string 
	 */
	public function getPostLink($projectID, $projectName, $postID, $postName) {
		return self::$basepath . "project/$projectID/$projectName/post/$postID/$postName";
	}

	/**
	 * @return string
	 */
	public function getAddNewProjectSrc() {
		return self::$basepath . "new/project";
	}

	/**
	 * @param  int $projectID
	 * @param string $projectName
	 * @return string
	 */
	public function getNewPostSrc($projectID, $projectName) {
		return self::$basepath . "project/$projectID/$projectName/new/post";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @param  string $postName
	 * @return string
	 */
	public function getEditPostSrc($projectID, $projectName, $postID, $postName) {
		return self::$basepath . "project/$projectID/$projectName/edit/post/$postID/$postName";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @return string
	 */
	public function getDeletePostSrc($projectID, $projectName, $postID) {
		return self::$basepath . "project/$projectID/$projectName/remove/post/$postID";
	}

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @param  int $postID
	 * @param  string $postName
	 * @return string
	 */
	public function getCommentSrc($projectID, $projectName, $postID, $postName) {
		return self::$basepath . "project/$projectID/$projectName/post/$postID/$postName/comment";
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
		return self::$basepath . "project/$projectID/$projectName/post/$postID/$postName/edit/comment/$commentID";
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
		return self::$basepath . "project/$projectID/$projectName/post/$postID/$postName/comment/$commentID";
	}

	/**
	 * @return string
	 */
	public function getLoginSrc() {
		return self::$basepath . "login";
	}

	/**
	 * @return string
	 */
	public function getLogoutSrc() {
		return self::$basepath . "logout";
	}

	/**
	 * @return string
	 */
	public function getRegisterSrc() {
		return self::$basepath . "register";
	}

	/**
	 * @param  int $userID
	 * @param  string $username
	 * @return string
	 */
	public function getUserPageSrc($userID, $username) {
		return self::$basepath . "user/$userID/$username";
	}

	/**
	 * @param  int $userID
	 * @param  string $username
	 * @return string
	 */
	public function getDeleteAccountSrc($userID, $username) {
		return self::$basepath . "remove/user/$userID/$username";
	}
}