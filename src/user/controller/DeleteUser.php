<?php

namespace user\controller;

class DeleteUser {
	/**
	 * @var user\model\User
	 */
	private $user;

	/**	
	 * @var user\model\UserHandeler
	 */
	private $userHandeler;

	/**	
	 * @var login\model\Login
	 */
	private $loginHandeler;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**	
	 * @param user\model\User         $user
	 * @param login\model\Login         $loginHandeler
	 */
	public function __construct(\user\model\User $user, \login\model\Login $loginHandeler) {
		$this->loginHandeler = $loginHandeler;
		$this->user = $user;

		$this->userHandeler = new \user\model\UserHandeler();
		$this->navigationView = new \common\view\Navigation();
	}

	public function deleteUser() {
		$this->userHandeler->deleteUser($this->user);
		$this->loginHandeler->unsetUserLoggedIn();
		$this->navigationView->gotoFrontPage();
	}

}