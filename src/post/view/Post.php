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
		try {
			$post = $this->postHandeler->getPost($id);

			if ($post->getCleanTitle() != $title) {
				header("Location: /php-projekt/post/". $id . '/' . $post->getCleanTitle());
			}

			$html = "<h2>" . $post->getTitle() . "</h2>";
			$html .= "<p>" . $post->getContent() . "</p>";
			$html .= "<p>" . $post->getDateAdded() . "</p>";	
		}
		
		catch (\Exception $e) {
			$html = "<p>No post found</p>";
		}

		return $html;
	}
}