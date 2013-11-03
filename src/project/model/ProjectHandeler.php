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
	 * @param user\model\User $user
	 * @return array of Projects
	 */
	public function getProjects(\user\model\User $user) {
		$projects = array();

		foreach ($this->projectDAL->getProjects($user) as $row) {
			try {
				$projects[] = new Project(+$row['idProject'], $row['name'], $row['description'], 
										Date($row['created']), $row['username'], +$row['userID'], (bool)$row['private']);
			}

			catch (\Exception $e) {
				throw $e;
			}
		}
		
		return $projects;
	}

	/**
	 * @param  int $limit
	 * @return array        array of project\model\Project
	 */
	public function getPublicProjects($limit) {
		$publicProjects = array();

		foreach ($this->projectDAL->getPublicProjects($limit) as $row) {
			try {
				$publicProjects[] = new Project(+$row['idProject'], $row['name'], $row['description'], 
										Date($row['created']), $row['username'], +$row['userID'], (bool)$row['private']);
			}

			catch (\Exception $e) {
				throw $e;
			}
		}
		
		return $publicProjects;
	}

	/**
	 * @param  int $id
	 * @return project\model\Project
	 * @throws Exception If no post is found
	 */
	public function getProject($id) {
		$row = $this->projectDAL->getProject($id);

		try {
			return new Project(+$row['idProject'], $row['name'], $row['description'], 
								Date($row['created']), $row['username'], +$row['userID'], (bool)$row['private']);
		}

		catch (\Exception $e) {
			throw $e;
		}
	}

	/**
	 * @param project\model\Project $project
	 * @return  void
	 */
	public function addProject(\project\model\Project $project) {
		$projectID = $this->projectDAL->addProject($project);
		$project->setProjectID($projectID);
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
		$this->projectDAL->deleteProject($project);
	}
}