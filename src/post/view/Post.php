<?php

namespace post\view;

class Post {
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
	 * @param post\model\Posts $postsModel
	 * @param project\model\Project $project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, \project\model\Project $project) {
		$this->postHandeler = $postHandeler;
		$this->project = $project;

		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @param  post\model\Post $post
	 * @return string     HTML
	 */
	public function getPostHTML(\post\model\Post $post) {
		
		$cleanPostTitle = \common\view\Filter::getCleanUrl($post->getTitle());
		$cleanProjectName = \common\view\Filter::getCleanUrl($this->project->getName());

		$html = "<article class='post'>";

		$html .= "<header class='post-header'>";
		$html .= "<div class='left'>";
		$html .= "<h1 class='post-title title'>" . $post->getTitle() . "</h1>";
		$html .= "<span class='created'>Added by: " . $post->getUsername() . " " . $post->getDateAdded() . "</span>";
		$html .= "</div>";

		$html .= "<div class='btn-area right'>";

		$editPostSrc = $this->navigationView->getEditPostSrc($this->project->getProjectID(),
								 							$cleanProjectName, 
								 							$post->getPostID(), 
								 							$cleanPostTitle);

		$html .= "<a href='$editPostSrc' class='btn btn-setting right'>
					<span class='icon-pencil'></span>Edit Post</a>";

		$deletePostSrc = $this->navigationView->getDeletePostSrc($this->project->getProjectID(), 
																$cleanProjectName,
																$post->getPostID());

		$html .= "<form class='right' action='$deletePostSrc' method='POST'>
					<input type='hidden' name='_method' value='delete'>
					<button class='btn btn-setting'><span class='icon-remove'></span>Delete Post</button>
				</form>";

		$html .= "</div>";
		$html .= "</header>";

		$html .= "<div class='box pad post-content'>";
		$html .= "<p class='content'>" . $post->getContent() . "</p>";
		$html .= "</div>";

		$html .= "</article>
				</div>";
				
		return $html;
	}
}