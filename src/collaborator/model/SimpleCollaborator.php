<?php

namespace collaborator\model;

class SimpleCollaborator extends Collaborator {

	/**
	 * @param int $collaboratorID
	 */
	public function __construct($collaboratorID) {
		if (!is_int($collaboratorID)) {
			throw new \Exception("Invalid collaboratorID");
		}

		$this->collaboratorID = $collaboratorID;
	}
}