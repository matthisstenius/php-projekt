<?php

namespace user\controller;

require_once("src/user/view/UserProfile.php");

class UserProfile {
	/**
	 * @var user\model\User
	 */
	private $user;

	/**
	 * @var user\view\UserProfile
	 */
	private $userProfileView;

	/**
	 * @param user\model\User $user
	 */
	public function __construct(\user\model\User $user) {
		$this->user = $user;
		$this->userProfileView = new \user\view\UserProfile($this->user);
	}

	/**
	 * @return string HTML
	 */
	public function showUserProfile() {
		return $this->userProfileView->getUserProfile();
	}
}