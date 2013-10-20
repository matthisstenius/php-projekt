<?php

namespace post\view;

class Post {
	/**
	 * @var post\model\Posts
	 */
	private $posts;

	/**
	 * @param post\model\Posts $posts
	 */
	public function __construct(\post\model\Posts $posts) {
		$this->posts = $posts;
	}

	public function getHTML() {
		$html = "";

		foreach ($this->posts->getPosts() as $post) {
			$html .= "<p>" . $post->getTitle() . "</p>";
		}

		return $html;
	}
}