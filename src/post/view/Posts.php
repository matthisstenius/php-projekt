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
		$html = "";

		foreach ($this->postHandeler->getPosts() as $post) {
			$html .= "<h1>" . $post->getTitle() . "</h1>";
			$html .= "<a href='post/" . $post->getPostID() . "/" . $post->getCleanTitle() . "'>Läs mer</a>";
		}

		return $html;
	}
}