<?php

namespace post\view;

class Posts {
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
			$html .= "<h1>" . $post->getTitle() . "</h1>";
			$html .= "<a href='post/" . $post->getPostID() . "/" . $post->getCleaTitle() . "'>Läs mer</a>";
		}

		return $html;
	}
}