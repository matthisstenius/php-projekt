<?php

namespace project\view;

class Project {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler) {
		$this->projectHandeler = $projectHandeler;
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @param  int $id
	 * @param  sting HTML containg Posts
	 * @return string HTML
	 */
	public function getProjectHTML($projectID, $projectName, $projectPosts) {
		try {
			$project = $this->projectHandeler->getProject($projectID);

			if (\common\view\Filter::getCleanUrl($project->getName()) != $projectName) {
				$this->navigationView->goToProject($projectID, \common\view\Filter::getCleanUrl($project->getName()));
			}

			$html = "<header class='project-header'>";

			$html .= "<div class='title-area left'>";
			$html .= "<h1 class='title'>" . $project->getName() . "</h1>";
			$html .= "<span class='created'>Created by: " . $project->getUsername() . " " . 
					 $project->getDateCreated() . "</span>";
			$html .= "</div>";

			$html .= "<div class='btn-area right'>";
			$newPostSrc = $this->navigationView->getNewPostSrc($projectID, $projectName);
			$html .= "<a class='btn btn-add right' href='$newPostSrc'>Add new post</a>";

			$editProjectSrc = $this->navigationView->getEditProjectSrc($projectID, $projectName);
			$html .= "<a href='$editProjectSrc' class ='btn btn-edit right'>Edit Project</a>";
			
			$deleteProjectSrc = $this->navigationView->getDeleteProjectSrc($projectID);
			$html .= "<form class='right' action='$deleteProjectSrc' method='POST'>
						<input name='_method' type='hidden' value='delete'>
						<button class='btn btn-remove'>Delete Project</button>
					</form>";

			$html .= "</div>";
			$html .= "</header>";
			$html .= "<p class='content'>" . $project->getDescription() . "</p>";
			

			$html .= $projectPosts;
		}

		catch (\Exception $e) {
			$html = "No project found!";
		}

		return $html;
	}
}