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
	 * @return string     HTML
	 */
	public function getPostHTML($id) {
		try {
			$post = $this->postsModel->getPost($id);

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