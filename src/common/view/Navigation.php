<?php

namespace common\view;

class Navigation {
	
	/**
	 * @param  int $projectID
	 * @param  int $postID
	 * @param  string $title
	 * @return string HTML
	 */
	public function goToPost($projectID, $postID, $title) {
		header("Location: /php-projekt/project/$projectID/post/$postID/$title");
	}

	/**
	 * @param  int $projectID
	 * @param  string $name
	 * @return string HTML
	 */
	public function goToProject($projectID, $name) {
		header("Location: /php-projekt/project/$projectID/$name");
	}

	/**
	 * @param  int $porjectID
	 * @param  string $cleanName
	 * @param  string $name
	 * @return string HTML
	 */
	public function getProjectLink($projectID, $cleanName, $name) {
		return "<a href='/php-projekt/project/$projectID/$cleanName'>$name</a>";
	}

	/**
	 * @param  int $projectID
	 * @param  int $postID
	 * @param  string $postName
	 * @return string HTML
	 */
	public function getPostLink($projectID, $postID, $postName) {
		return "<a href='/php-projekt/project/$projectID/post/$postID/$postName'>$postName</a>";
	}
}