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
	 * @var post\model\Post
	 */
	private $post;

	/**
	 * @var array of comment\model\Comment
	 */
	private $comments;

	/**
	 * @var user\model\User
	 */
	private $user;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param project\model\Project $project
	 * @param post\model\Post       $post
	 * @param array              	$comments array of comment\model\Comment
	 * @param user\model\User       $user
	 */
	public function __construct(\project\model\Project $project,
								\post\model\Post $post,
								$comments,
								\user\model\User $user) {

		$this->project = $project;
		$this->post = $post;
		$this->comments = $comments;
		$this->user = $user;

		$this->postHandeler = new \post\model\PostHandeler();
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return string     HTML
	 */
	public function getPostHTML() {
		
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

		$html .= $this->getComments();

		$html .= "</article>
				</div>";
				
		return $html;
	}

	/**
	 * @return string HTML
	 */
	private function getComments() {
		$html = "";

		foreach ($this->comments as $comment) {
			$cleanProjectName = \common\view\Filter::getCleanUrl($this->project->getName());
			$cleanPostTitle = \common\view\Filter::getCleanUrl($this->post->getTitle());

			$editCommentSrc = $this->navigationView->getEditCommentSrc($this->project->getProjectID(),
																		$cleanProjectName,
																		$this->post->getPostID(),
																		$cleanPostTitle,
																		$comment->getCommentID());

			$deleteCommentSrc = $this->navigationView->getdeleteCommentSrc($this->project->getProjectID(),
																		$cleanProjectName,
																		$this->post->getPostID(),
																		$cleanPostTitle,
																		$comment->getCommentID());

			$commentDate = \common\view\Filter::formatDate($comment->getDateAdded());

			$html .= "<p>" . $comment->getComment() . "</p>";
			$html .= "<p>" . $commentDate . "</p>";
			$html .= "<p>" . $comment->getUsername() . "</p>";
			$html .= "<a href='$editCommentSrc' class='btn btn-edit'>Edit Comment</a>";
			$html .= "<form action='$deleteCommentSrc' method='POST'>
						<input type='hidden' name='_method' value='delete'>
						<button class='btn btn-remove'>Delete Comment</button>
					</form>";
		}
		
		return $html;
	}
}