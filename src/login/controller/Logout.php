<?php

namespace login\controller;

class Logout {
	/**
	 * @var user\model\UserHandeler
	 */
	private $userHandeler;

	/**
	 * @var login\view\Login
	 */
	private $loginView;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @var login\model\Login
	 */
	private $loginHandeler;

	/**	
	 * @param user\model\UserHandeler $userHandeler
	 * @param login\model\Login $loginHandeler
	 */
	public function __construct(\user\model\UserHandeler $userHandeler, \login\model\Login $loginHandeler) {
		$this->userHandeler = $userHandeler;
		$this->loginHandeler = $loginHandeler;
		$this->navigationView = new \common\view\Navigation();
		$this->loginView = new \login\view\Login($this->navigationView, $this->userHandeler);
	}

	public function logout() {
		$this->loginView->removeCookie();
		$this->loginHandeler->unsetUserLoggedIn();
		$this->navigationView->gotoFrontPage();
	}
}