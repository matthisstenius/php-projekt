<?php

namespace collaborator\controller;

class DeleteCollaborator {
	/**
	 * @var collaborator\model\Collaborator
	 */
	private $collaborator;

	/**
	 * @var collaborator\model\CollaboratorHandeler
	 */
	private $collaboratorHandeler;

	/**
	 * @var project\model\Project
	 */
	private $project;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param collaborator\model\Collaborator         $collaborator
	 * @param collaborator\model\CollaboratorHandeler $collaboratorHandeler
	 * @param project\model\Project                   $project
	 */
	public function __construct(\collaborator\model\Collaborator $collaborator,
								\collaborator\model\CollaboratorHandeler $collaboratorHandeler,
								\project\model\Project $project) {

		$this->collaborator = $collaborator;
		$this->collaboratorHandeler = $collaboratorHandeler;
		$this->project = $project;

		$this->navigationView = new \common\view\Navigation();
	}

	public function deleteCollaborator() {
		$this->collaboratorHandeler->deleteCollaborator($this->collaborator);
		$this->navigationView->gotoCollaborators($this->project->getProjectID(),
											\common\view\Filter::getCleanUrl($this->project->getName()));
	}
}