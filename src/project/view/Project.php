<?php

namespace project\view;

class Project {
	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param project\model\Project $project
	 */
	public function __construct(\project\model\Project $project) {
		$this->project = $project;

		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @todo  check if this is okey
	 * @param  sting  $projectPosts HTML containg Posts
	 * @return string HTML
	 */
	public function getProjectHTML($projectPosts) {
		$project = $this->project;
		$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());

		$html = "<header class='project-header'>";

		$html .= "<div class='title-area left'>";
		$html .= "<h1 class='title'>" . $project->getName() . "</h1>";
		$html .= "<span class='created'>Created by: " . $project->getUsername() . " " . 
				 $project->getDateCreated() . "</span>";
		$html .= "</div>";

		$html .= "<div class='btn-area right'>";
		$newPostSrc = $this->navigationView->getNewPostSrc($project->getProjectID(), $cleanProjectName);

		$html .= "<a class='btn btn-add right' href='$newPostSrc'>Add new post</a>";

		$editProjectSrc = $this->navigationView->getEditProjectSrc($project->getProjectID(), $cleanProjectName);
		$html .= "<a href='$editProjectSrc' class ='btn btn-edit right'>Edit Project</a>";
		
		$deleteProjectSrc = $this->navigationView->getDeleteProjectSrc($project->getProjectID());
		$html .= "<form class='right' action='$deleteProjectSrc' method='POST'>
					<input name='_method' type='hidden' value='delete'>
					<button class='btn btn-remove'>Delete Project</button>
				</form>";

		$html .= "</div>";
		$html .= "</header>";
		$html .= "<p class='content'>" . $project->getDescription() . "</p>";
		

		$html .= $projectPosts;

		return $html;
	}
}