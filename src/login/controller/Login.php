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
		$this->loginView = new \login\view\Login($this->navigationView, $this->userHandeler);

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
			if ($user = $this->loginHandeler->isLoginOK($this->users, $loginCredentials)) {
				if ($this->loginView->userWantsToBeRemebered()) {
					$this->loginView->setCookieValue($user);	
				}
				
				$this->navigationView->gotoFrontPage();
			}
		}

		catch (\Exception $e) {
			$this->loginView->errorMessage();
			$this->navigationView->gotoLoginPage();
		}
	}

	public function loginWithToken() {
		$loginCredentials = $this->loginView->getTokenCredentials();

		try {
			if ($this->loginView->userIsRemembered()) {
				$this->loginHandeler->loginWithTokenOK($this->users, $loginCredentials);
			}
		}

		catch (\Exception $e) {
			$this->loginView->removeCookie();
			$this->navigationView->gotoLoginPage();
		}
	}
}