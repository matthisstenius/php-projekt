<?php

namespace register\controller;

require_once("src/register/view/Register.php");
require_once("src/register/model/Register.php");

class Register {
	/**
	 * @var login\model\Login
	 */
	private $loginHandeler;

	/**
	 * @var user\model\UserHandeler
	 */
	private $userHandeler;

	/**
	 * @var register\view\Register
	 */
	private $registerView;

	/**
	 * @var register\model\Register
	 */
	private $registerModel;

	/**
	 * @var common\view\Navigation
	 */
	private $navigationView;

	/**
	 * @param login\model\Login       $loginHandeler
	 * @param user\model\UserHandeler $userHandeler
	 */
	public function __construct(\login\model\Login $loginHandeler, \user\model\UserHandeler $userHandeler) {
		$this->userHandeler = $userHandeler;
		$this->loginHandeler = $loginHandeler;

		$this->navigationView = new \common\view\Navigation();
		$this->registerView = new \register\view\Register($this->navigationView);
	}

	/**
	 * @return string HTML
	 */
	public function showRegisterForm() {
		return $this->registerView->getRegisterForm();
	}

	public function register() {
		$user = $this->registerView->getUserCredentials();

		try {
			$registerModel = new \register\model\Register($user, $this->userHandeler);
			
			if ($registerModel->isUsernameFree()) {
				$this->userHandeler->addUser($user);
				$this->loginHandeler->setUserLoggedIn($user);
				$this->navigationView->gotoFrontPage();
			}
		}

		catch (\Exception $e) {
			$this->registerView->usernameAlreadyExist();
			$this->registerView->saveUsername();
			$this->navigationView->gotoRegisterPage();
		}
	}
}