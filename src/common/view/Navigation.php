<?php

namespace common\view;

class Navigation {
	
	public function goToPost($id, $title) {
		header("Location: /php-projekt/post/$id/$title");
	}
}