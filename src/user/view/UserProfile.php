<?php

namespace user\view;

class UserProfile {
	/**
	 * @var user\model\User
	 */
	private $user;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param user\model\User         $user
	 */
	public function __construct(\user\model\User $user) {
		$this->user = $user;
		$this->navigationView = new \common\view\Navigation();
	}

	/**
	 * @return string HTML
	 */
	public function getUserProfile() {
		$deleteAccountSrc = $this->navigationView->getDeleteAccountSrc($this->user->getUserID(),
																		$this->user->getUsername());

		$html = "<div class='centered'>";
		$html .= "<h1>" . $this->user->getUsername() . "'s Profile</h1>";
		$html .= "<form action='$deleteAccountSrc' method='POST'>
					<input type='hidden' name='_method' value='delete'>
					<button class='btn btn-remove'>Delete Account</button>
				</form>";
		$html .= "<div>";

		return $html;
	}
}