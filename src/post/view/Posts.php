<?php

namespace post\view;

class Posts {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 */
	public function __construct(\post\model\PostHandeler $postHandeler) {
		$this->postHandeler = $postHandeler;
	}

	public function getHTML() {
		$html = "<div class='post-thumbs'>";

		foreach ($this->postHandeler->getPosts() as $post) {
			$html .= "<div class='post-thumb box pad'>";
			$html .= "<h1 class='post-title'>" . $post->getTitle() . "</h1>";
			$html .= "<p class='post-excerpt'>" . $post->getExcerpt() . "...</p>";
			$html .= "<a href='post/" . $post->getPostID() . "/" . $post->getCleanTitle() . "'>Läs mer</a>";
			$html .= "</div>";
		}

		return $html;
	}
}