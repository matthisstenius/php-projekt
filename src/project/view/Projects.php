<?php

namespace project\view;

class Projects {
	/**
	 * @var project\model\ProjectHandeler
	 */
	private $projectHandeler;

	/**
	 * @var user\model\User
	 */
	private $user;
	
	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param project\model\ProjectHandeler $projectHandeler
	 * @param user\model\User $user
	 */
	public function __construct(\project\model\ProjectHandeler $projectHandeler, \user\model\User $user) {
		$this->projectHandeler = $projectHandeler;
		$this->user = $user;
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return string HTML
	 */
	public function getProjectsList() {
		$html = "<ul class='projects-list'>";

		foreach ($this->projectHandeler->getProjects($this->user) as $project) {
			$cleanName = \common\view\Filter::getCleanUrl($project->getName());
			$link = $this->navigationView->getProjectSrc($project->getProjectID(), $cleanName);
			$html .= "<li><a href='$link'>" . $project->getName() . "</a></li>";

		}

		$html .= "</ul>";

		return $html;
	}

	/**
	 * @return string HTML
	 */
	public function getProjects() {
		$html = "<header class='projects-header'>";
		$html .= "<h1 class='projects-title title left'>" . $this->user->getUsername() . "'s projects</h1>";
		
		$newProjectSrc = $this->navigationView->getAddNewProjectSrc();
		$html .= "<a href='$newProjectSrc' class='btn btn-setting right'><span class='icon-plus'></span>Add Project</a>";

		$html .= "</header>";

		$html .= "<div class='post-thumbs'>";

		$projects = $this->projectHandeler->getProjects($this->user);

		foreach ($projects as $project) {
			$cleanProjectName = \common\view\Filter::getCleanUrl($project->getName());

			$projectSrc = $this->navigationView->getProjectSrc($project->getProjectID(), 
																$cleanProjectName);

			$html .= "<div class='post-thumb box pad'>";
			$html .= "<a class='title-link' href='$projectSrc'>
						<h2 class='post-title title'>" . $project->getName() . "</h2>
					</a>";

			$projectExcerpt = \common\view\Filter::getExcerpt($project->getDescription());

			$html .= "<span class='created'>Added by: " . $project->getUsername() . " " . $project->getDateCreated() . "</span>";
			$html .= "<p class='post-excerpt'>$projectExcerpt</p>";
			$html .= "<a class='btn-attention' href='$projectSrc'>Open Project</a>";
			$html .= "</div>";
		}

		if (count($projects) == 0) {
			$html .= "<p class='nothing-found'>You dont have any projects</p>";
		}
		$html .= "</div>";

		return $html;
	}
}