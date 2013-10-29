<?php

namespace login\controller;

require_once("src/login/view/Login.php");

class Login {
	/**
	 * @var view\Login
	 */
	private $loginView;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @var user\model\UserHandeler
	 */
	private $userHandeler;

	/**
	 * @var array of Users
	 */
	private $users;

	/**
	 * @param user\model\UserHandeler $userHandeler
	 * @param login\model\Login       $loginHandeler
	 */
	public function __construct(\user\model\UserHandeler $userHandeler, \login\model\Login $loginHandeler) {
		$this->userHandeler = $userHandeler;
		$this->loginHandeler = $loginHandeler;

		$this->navigationView = new \common\view\Navigation();
		$this->loginView = new \login\view\Login($this->navigationView);

		$this->users = $this->userHandeler->getUsers();
	}

	/**
	 * @return string HTML
	 */
	public function showLoginForm() {
		return $this->loginView->getLoginForm();
	}

	public function login() {
		$loginCredentials = $this->loginView->getUserCredentials();

		try {
			if ($this->loginHandeler->isLoginOK($this->users, $loginCredentials)) {
				$this->navigationView->gotoFrontPage();
			}
		}

		catch (\Exception $e) {
			$this->loginView->setErrorMessage();
			$this->navigationView->gotoLoginPage();
		}
	}
}