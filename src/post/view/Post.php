<?php

namespace post\view;

class Post {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param post\model\Posts $postsModel
	 */
	public function __construct(\post\model\PostHandeler $postHandeler) {
		$this->postHandeler = $postHandeler;
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @param  int $id
	 * @param  string $title
	 * @return string     HTML
	 */
	public function getPostHTML($projectID, $id, $title) {
		$html = "<div class='box pad'>
					<article>";
		try {
			$post = $this->postHandeler->getPost($id);

			if ($post->getCleanTitle() != $title) {
				$this->navigationView->goToPost($projectID, $id, $post->getCleanTitle());
			}

			$html .= "<h1 class='post-title title'>" . $post->getTitle() . "</h1>";
			$html .= "<span class='created'>Added by: " . $post->getUsername() . " " . $post->getDateAdded() . "</span>";
			$html .= "<p class='post-content'>" . $post->getContent() . "</p>";
		}
		
		catch (\Exception $e) {
			$html = "<p>No post found</p>";
		}

		$html .= "</article>
				</div>";
				
		return $html;
	}
}