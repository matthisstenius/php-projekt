<?php

namespace post\view;

class Post {
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
	 * @var login\model\Login
	 */
	private $loginHandeler;

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

		$this->loginHandeler = new \login\model\Login();
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

		if ($this->loginHandeler->isSameUser(new \user\model\SimpleUser($this->project->getUserID(), 
																		$this->project->getUsername()))) {
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
		}

		$html .= "</header>";

		$html .= "<div class='box pad post-content'>";
		$html .= "<p class='content'>" . $this->post->getContent() . "</p>";
		$html .= "</div>";

		$html .= $this->getComments();

		$html .= "</article>";
				
		return $html;
	}

	/**
	 * @return string HTML
	 */
	private function getComments() {
		$commentAmount = count($this->comments);
		$postTitle = $this->post->getTitle();

		$html = "<h2>$postTitle has $commentAmount comments</h2>";

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

			if ($this->post->getUserID() == $comment->getUserID()) {
				$commentAuthor = "author-comment";
				$ribbon = "<div class='ribbon-wrapper'><div class='ribbon'>Author</div></div>";
			}

			else {
				$commentAuthor = "user-comment";
				$ribbon = "";
			}

			$html .= "<div class='comment $commentAuthor pad'>";
			$html .= "<span class='created'>Posted by: " . $comment->getUsername() . " $commentDate</span>";
			$html .= "<p>" . $comment->getComment() . "</p>";

			if ($this->loginHandeler->isSameUser(new \user\model\SimpleUser($comment->getUserID(), 
																		$comment->getUsername()))) {
				$html .= "<div class='btn-area'>";
				$html .= "<a href='$editCommentSrc' class='btn btn-edit left'><span class='icon-pencil'></span>Edit Comment</a>";
				$html .= "<form class='left' action='$deleteCommentSrc' method='POST'>
							<input type='hidden' name='_method' value='delete'>
							<button class='btn btn-remove'><span class='icon-remove'></span>Delete Comment</button>
						</form>";
				$html .= "</div>";
			}

			$html .= $ribbon;
			$html .= "</div>";
		}
		
		return $html;
	}
}