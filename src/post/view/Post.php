<?php

namespace post\view;

class Post {
	/**
	 * @var post\model\Posts
	 */
	private $postsModel;

	/**
	 * @param post\model\Posts $postsModel
	 */
	public function __construct(\post\model\Posts $postsModel) {
		$this->postsModel = $postsModel;
	}

	/**
	 * @param  int $id
	 * @param string $title
	 * @return string     HTML
	 */
	public function getPostHTML($id, $title) {
		try {
			$post = $this->postsModel->getPost($id);

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