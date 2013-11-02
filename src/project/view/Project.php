<?php

namespace project\view;

class Project {
	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var array of post\model\Post
	 */
	private $posts;

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
	 * @param array              	$posts   array of post\model\Post
	 * @param login\model\Login 	$loginHandeler
	 */
	public function __construct(\project\model\Project $project, $posts, $collaborators) {
		$this->project = $project;
		$this->posts = $posts;
		$this->collaborators = $collaborators;

		$this->loginHandeler = new \login\model\Login();
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return string HTML
	 */
	public function getProjectHTML() {
		$project = $this->project;
		$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());

		$html = "<header class='project-header'>";

		if ($project->isPrivate()) {
			$lockIcon = "<span title='Private Project' class='private icon-locked'></span>";
		}

		else {
			$lockIcon = "";
		}

		$html .= "<div class='title-area left'>";
		$html .= "<h1 class='title'>$lockIcon" . $project->getName() . "</h1>";
		$html .= "<span class='created'>Created by: " . $project->getUsername() . " " . 
				 $project->getDateCreated() . "</span>";
		$html .= "</div>";

		$html .= "<div class='btn-area right'>";

		if ($this->loginHandeler->isAdmin($project)) {
			$collaboratorsSrc = $this->navigationView->getCollaboratorsSrc($project->getProjectID(), $cleanProjectName);

			$html .= "<a href='$collaboratorsSrc' class='btn btn-setting right'>Collaborators</a>";

			$newPostSrc = $this->navigationView->getNewPostSrc($project->getProjectID(), $cleanProjectName);

			$html .= "<a class='btn btn-setting right' href='$newPostSrc'>
						<span class='icon-plus'></span>Add new post</a>";

			$editProjectSrc = $this->navigationView->getEditProjectSrc($project->getProjectID(), $cleanProjectName);
			$html .= "<a href='$editProjectSrc' class ='btn btn-setting right'>
						<span class='icon-pencil'></span>Edit Project</a>";
			
			$deleteProjectSrc = $this->navigationView->getDeleteProjectSrc($project->getProjectID());
			$html .= "<form class='right' action='$deleteProjectSrc' method='POST'>
						<input name='_method' type='hidden' value='delete'>
						<button class='btn btn-setting'><span class='icon-remove'></span>Delete Project</button>
					</form>";
		}

		else if ($this->loginHandeler->isCollaborator($this->collaborators, $this->project)) {
			$newPostSrc = $this->navigationView->getNewPostSrc($project->getProjectID(), $cleanProjectName);

			$html .= "<a class='btn btn-setting right' href='$newPostSrc'>
						<span class='icon-plus'></span>Add new post</a>";
		}

		$html .= "</div>";
		$html .= "</header>";
		$html .= \common\view\Filter::newlineToParagraph($project->getDescription());;
		
		$html .= $this->getPosts();
		
		return $html;
	}

	/**
	 * @return string HTML
	 */
	private function getPosts() {
		$html = "<div class='post-thumbs'>";

		foreach ($this->posts as $post) {
			$cleanTitle = \common\view\Filter::getCleanUrl($post->getTitle());
			$cleanProjectName = \common\view\Filter::getCleanUrl($this->project->getName());

			$postSrc = $this->navigationView->getPostLink($this->project->getProjectID(), 
															$cleanProjectName, 
															$post->getPostID(), 
															$cleanTitle);

			$html .= "<div class='post-thumb box pad'>";
			$html .= "<a class='title-link' href='$postSrc'>
						<h2 class='post-title title'>" . $post->getTitle() . "</h2>
					</a>";

			$postExcerpt = \common\view\Filter::getExcerpt($post->getContent());

			$html .= "<span class='created'>Added by: " . $post->getUsername() . " " . $post->getDateAdded() . "</span>";
			$html .= "<p class='post-excerpt'>$postExcerpt...</p>";
			$html .= "<a class='btn-attention' href='$postSrc'>Read More</a>";
			$html .= "</div>";
		}

		$html .= "</div>";

		return $html;
	}
}