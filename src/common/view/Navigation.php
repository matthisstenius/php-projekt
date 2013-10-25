<?php

namespace common\view;

class Navigation {
	
	public function goToPost($id, $title) {
		header("Location: /php-projekt/post/$id/$title");
	}

	public function goToProject($id, $name) {
		header("Location: /php-projekt/project/$id/$name");
	}

	public function getProjectLink($id, $name) {
		return "<a href='/php-projekt/project/$id/$name'>$name</a>";
	}

	public function getPostLink($projectID, $postID, $postName) {
		return "<a href='/php-projekt/project/$projectID/post/$postID/$postName'>$postName</a>";
	}
}