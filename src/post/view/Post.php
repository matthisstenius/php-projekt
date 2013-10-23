<?php

namespace post\view;

class Post {
	/**
	 * @var post\model\PostHandeler
	 */
	private $postHandeler;

	/**
	 * @param post\model\Posts $postsModel
	 */
	public function __construct(\post\model\PostHandeler $postHandeler) {
		$this->postHandeler = $postHandeler;
	}

	/**
	 * @param  int $id
	 * @param  string $title
	 * @return string     HTML
	 */
	public function getPostHTML($id, $title) {
		$html = "<div class='box pad'>
					<article>";
		try {
			$post = $this->postHandeler->getPost($id);

			if ($post->getCleanTitle() != $title) {
				header("Location: /php-projekt/post/". $id . '/' . $post->getCleanTitle());
			}

			$html .= "<h1 class='post-title'>" . $post->getTitle() . "</h1>";
			$html .= "<p class='post-username'>By: " . $post->getUsername() . "</p>";
			$html .= "<p class='post-content'>" . $post->getContent() . "</p>";
			$html .= "<span class='date'>" . $post->getDateAdded() . "</span>";	
		}
		
		catch (\Exception $e) {
			$html = "<p>No post found</p>";
		}

		$html .= "</article>
				</div>";
		return $html;
	}
}