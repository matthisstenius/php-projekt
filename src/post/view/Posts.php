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

	/**
	 * @param  int $projectID
	 * @param  string $projectName
	 * @return string HTML
	 */
	public function getHTML($projectID, $projectName) {
		$html = "<div class='post-thumbs'>";

		foreach ($this->postHandeler->getPosts($projectID) as $post) {
			$cleanTitle = \common\view\Filter::getCleanUrl($post->getTitle());

			$postSrc = $this->navigationView->getPostLink($projectID, $projectName, $post->getPostID(), $cleanTitle);

			$html .= "<div class='post-thumb box pad'>";
			$html .= "<a class='title-link' href='$postSrc'>
						<h1 class='post-title title'>" . $post->getTitle() . "</h1>
					</a>";

			$html .= "<span class='created'>Added by: " . $post->getUsername() . " " . $post->getDateAdded() . "</span>";
			$html .= "<p class='post-excerpt'>" . $post->getExcerpt() . "...</p>";
			$html .= "<a href='$postSrc'>Read More</a>";
			$html .= "</div>";
		}

		$html .= "</div>";


		return $html;
	}
}