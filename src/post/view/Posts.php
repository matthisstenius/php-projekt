<?php

namespace post\view;

class Posts {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 */
	public function __construct(\post\model\PostHandeler $postHandeler) {
		$this->postHandeler = $postHandeler;
		$this->navigationView = new \common\view\Navigation();
	}

	public function getHTML($projectID) {
		$html = "<div class='post-thumbs'>";

		foreach ($this->postHandeler->getPosts($projectID) as $post) {
			$postSrc = $this->navigationView->getPostLink($projectID, $post->getPostID(), $post->getCleanTitle());

			$html .= "<div class='post-thumb box pad'>";
			$html .= "<h1 class='post-title title'>" . $post->getTitle() . "</h1>";
			$html .= "<span class='created'>Added by: " . $post->getUsername() . " " . $post->getDateAdded() . "</span>";
			$html .= "<p class='post-excerpt'>" . $post->getExcerpt() . "...</p>";
			$html .= "<a href='$postSrc'>Read More</a>";
			$html .= "</div>";
		}

		$html .= "</div>";


		return $html;
	}
}