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

			if ($project->getCleanName() != $projectName) {
				$this->navigationView->goToProject($projectID, $project->getCleanName());
			}

			$html = "<header class='project-header'>";

			$html .= "<h1 class='title'>" . $project->getName() . "</h1>";
			$html .= "<p>" . $project->getUsername() . "</p>";
			$html .= "<p>" . $project->getDescription() . "</p>";
			$html .= "<span class='date'>" . $project->getDateCreated() . "</span>";

			$newPostSrc = $this->navigationView->getNewPostSrc($projectID, $projectName);
			$html .= "<a href='$newPostSrc'>Add new post to this project</a>";
			
			$html .= "</header>";

			$html .= $projectPosts;
		}

		catch (\Exception $e) {
			$html = "No project found!";
		}

		return $html;
	}
}