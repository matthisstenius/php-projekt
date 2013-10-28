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
	public function getPostHTML($projectID, $projectName, $postID, $postTitle) {
		$html = "<div class='box pad'>
					<article class='post'>";
		try {
			$post = $this->postHandeler->getPost($postID);

			$cleanTitle = \common\view\Filter::getCleanUrl($post->getTitle());

			if ($cleanTitle != $postTitle) {
				$this->navigationView->goToPost($projectID, $projectName, $postID, $cleanTitle);
			}

			$html .= "<header class='post-header'>";
			$html .= "<div class='left'>";
			$html .= "<h1 class='post-title title'>" . $post->getTitle() . "</h1>";
			$html .= "<span class='created'>Added by: " . $post->getUsername() . " " . $post->getDateAdded() . "</span>";
			$html .= "</div>";

			$html .= "<div class='btn-area right'>";
			$editPostSrc = $this->navigationView->getEditPostSrc($projectID, $projectName, $postID, $postTitle);
			$html .= "<a href='$editPostSrc' class='btn btn-edit right'>Edit Post</a>";

			$deletePostSrc = $this->navigationView->getDeletePostSrc($projectID, $projectName, $postID);
			$html .= "<form class='right' action='$deletePostSrc' method='POST'>
						<input type='hidden' name='_method' value='delete'>
						<button class='btn btn-remove'>Delete Post</button>
					</form>";

			$html .= "</div>";
			$html .= "</header>";

			$html .= "<p class='content'>" . $post->getContent() . "</p>";
		}
		
		catch (\Exception $e) {
			$html = "<p>No post found</p>";
		}

		$html .= "</article>
				</div>";
				
		return $html;
	}
}