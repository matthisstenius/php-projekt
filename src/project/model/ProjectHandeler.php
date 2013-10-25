<?php

namespace project\model;

require_once("src/project/model/ProjectDAL.php");
require_once("src/project/model/Project.php");

class ProjectHandeler {
	/**
	 * @var project\model\ProjectDAL
	 */
	private $projectDAL;

	public function __construct() {
		$this->projectDAL = new ProjectDAL();
	}

	/**
	 * @return array of Projects
	 */
	public function getProjects() {
		$projects = array();

		foreach ($this->projectDAL->getProjects() as $row) {
			$projects[] = new Project(+$row['idProject'], $row['name'], $row['description'], Date($row['created']), $row['username']);
		}
		
		return $projects;
	}

	/**
	 * @param  int $id
	 * @return project\model\Project
	 * @throws Exception If no post is found
	 */
	public function getProject($id) {
		if ($row = $this->projectDAL->getProject($id)) {
			return new Project(+$row['idProject'], $row['name'], $row['description'], Date($row['created']), $row['username']);
		}
		
		throw new \Exception("No project found");
	}

	/**
	 * @param project\model\Project $project
	 * @return  void
	 */
	public function addProject(\project\model\Project $project) {
		$this->projectDAL->addProject($project);
	}

	/**
	 * @param project\model\Project $project
	 * @return  void
	 */
	public function editProject(\project\model\Project $project) {
		$this->projectDAL->editProject($project);
	}

	/**
	 * @param project\model\Project $project
	 * @return  void
	 */
	public function deleteProject(\project\model\Project $project) {
		$this->projectDAL->deleteProject($project->getProjectsID());
	}
}