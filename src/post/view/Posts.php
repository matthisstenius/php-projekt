<?php

namespace post\view;

class Posts {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param post\model\PostHandeler $postHandeler
	 * @param project\model\Project $project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, \project\model\Project $project) {
		$this->postHandeler = $postHandeler;
		$this->project = $project;

		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return string HTML
	 */
	public function getHTML() {
		$html = "<div class='post-thumbs'>";

		foreach ($this->postHandeler->getPosts($this->project) as $post) {
			$cleanTitle = \common\view\Filter::getCleanUrl($post->getTitle());
			$cleanProjectName = \common\view\Filter::getCleanUrl($this->project->getName());

			$postSrc = $this->navigationView->getPostLink($this->project->getProjectID(), 
															$cleanProjectName, 
															$post->getPostID(), 
															$cleanTitle);

			$html .= "<div class='post-thumb box pad'>";
			$html .= "<a class='title-link' href='$postSrc'>
						<h2 class='post-title title'>" . $post->getTitle() . "</h2>
					</a>";

			$postExcerpt = \common\view\Filter::getExcerpt($post->getContent());

			$html .= "<span class='created'>Added by: " . $post->getUsername() . " " . $post->getDateAdded() . "</span>";
			$html .= "<p class='post-excerpt'>$postExcerpt...</p>";
			$html .= "<a class='btn-attention' href='$postSrc'>Read More</a>";
			$html .= "</div>";
		}

		$html .= "</div>";


		return $html;
	}
}