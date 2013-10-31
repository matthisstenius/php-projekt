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

	private $post;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param post\model\Posts $postsModel
	 * @param project\model\Project $project
	 */
	public function __construct(\post\model\PostHandeler $postHandeler, 
								\project\model\Project $project,
								\post\model\Post $post) {

		$this->postHandeler = $postHandeler;
		$this->project = $project;
		$this->post = $post;

		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @param  string HTML
	 * @return string     HTML
	 */
	public function getPostHTML($commentForm, $comments) {
		
		$cleanPostTitle = \common\view\Filter::getCleanUrl($this->post->getTitle());
		$cleanProjectName = \common\view\Filter::getCleanUrl($this->project->getName());

		$html = "<article class='post'>";

		$html .= "<header class='post-header'>";
		$html .= "<div class='left'>";
		$html .= "<h1 class='post-title title'>" . $this->post->getTitle() . "</h1>";
		$html .= "<span class='created'>Added by: " . $this->post->getUsername() . " " . $this->post->getDateAdded() . "</span>";
		$html .= "</div>";

		$html .= "<div class='btn-area right'>";

		$editPostSrc = $this->navigationView->getEditPostSrc($this->project->getProjectID(),
								 							$cleanProjectName, 
								 							$this->post->getPostID(), 
								 							$cleanPostTitle);

		$html .= "<a href='$editPostSrc' class='btn btn-setting right'>
					<span class='icon-pencil'></span>Edit Post</a>";

		$deletePostSrc = $this->navigationView->getDeletePostSrc($this->project->getProjectID(), 
																$cleanProjectName,
																$this->post->getPostID());

		$html .= "<form class='right' action='$deletePostSrc' method='POST'>
					<input type='hidden' name='_method' value='delete'>
					<button class='btn btn-setting'><span class='icon-remove'></span>Delete Post</button>
				</form>";

		$html .= "</div>";
		$html .= "</header>";

		$html .= "<div class='box pad post-content'>";
		$html .= "<p class='content'>" . $this->post->getContent() . "</p>";
		$html .= "</div>";

		$html .= $commentForm;

		$html .= $comments;
		$html .= "</article>
				</div>";
				
		return $html;
	}
}