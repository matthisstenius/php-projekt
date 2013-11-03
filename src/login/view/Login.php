<?php

namespace login\view;

require_once("src/login/model/LoginCredentials.php");
require_once("src/login/model/TokenCredentials.php");
require_once("src/login/model/TokenGenerator.php");

class Login {
	private static $username = "username";
	private static $password = "password";
	private static $remember = "remember";
	private static $userCookie = "persistent";
	private static $inputFaultyMessage = "login::view::login::inputFaultyMessage";
	private static $errorMessage = "login::view::login::errorMessage";
	private static $saveUsername = "login::view::login::saveUsername";

	/**
	 * @var common\view\Navigtion
	 */
	private $navigationView;

	/**
	 * @var user\model\UserHandeler
	 */
	private $userHandeler;

	/**
	 * @param common\view\Navigation $navigationView
	 * @param user\model\UserHandeler $userHandeler
	 */
	public function __construct(\common\view\Navigation $navigationView, \user\model\UserHandeler $userHandeler) {
		$this->navigationView = $navigationView;
		$this->userHandeler = $userHandeler;
	}

	/**
	 * @return string HTML
	 */
	public function getLoginForm() {
		$html = "<div class='login-box centered'>
					<h1>Log in</h1>";

		$loginSrc = $this->navigationView->getLoginSrc();

		if (isset($_SESSION[self::$inputFaultyMessage])) {
			$html .= $_SESSION[self::$inputFaultyMessage];
			unset($_SESSION[self::$inputFaultyMessage]);
		}

		else if (isset($_SESSION[self::$errorMessage])) {
			$html .= $_SESSION[self::$errorMessage];
			unset($_SESSION[self::$errorMessage]);
		}

		$username = "";

		if (isset($_SESSION[self::$saveUsername])) {
			$username = $_SESSION[self::$saveUsername];
			unset($_SESSION[self::$saveUsername]);
		}

		$html .= "<form class='pure-form login-form' action='$loginSrc' method='POST'>
					<div class='pure-group'>
						<input type='text' name='" . self::$username . "' placeholder='Username' value='$username'>
						<input type='password' name='" . self::$password . "' placeholder='Password'>
						
						<label for='remember'>Remember Me</label>
						<input id='" . self::$remember . "' type='checkbox' name='" . self::$remember . "'>
						<button class='btn btn-wide btn-login'>Log In</button>
					</div>
				</form>";
		$html .= "</div>";
		return $html;
	}

	/**
	 * @return string clean string
	 */
	private function getUsername() {
		if (isset($_POST[self::$username])) {
			return \common\view\Filter::clean($_POST[self::$username]);
		}
	}

	/**
	 * @return string clean string
	 */
	private function getPassword() {
		if (isset($_POST[self::$password])) {
			return \common\view\Filter::clean($_POST[self::$password]);
		}
	}

	/**
	 * @return boolean
	 */
	public function userWantsToBeRemebered() {
		return isset($_POST[self::$remember]);
	}

	/**
	 * @return boolean
	 */
	public function userIsRemembered() {
		return isset($_COOKIE[self::$userCookie]);
	}

	/**
	 * @return string
	 */
	private function getCookieValue() {
		if ($this->userIsRemembered()) {
			return $_COOKIE[self::$userCookie];
		}
	}

	public function setCookieValue(\user\model\User $user) {
		$tokenGenerator = new \login\model\TokenGenerator();

		$token = $tokenGenerator->getToken();
		$tokenExpireDate = $tokenGenerator->getTokenExpireDate();

		$user->setTokenExpireDate($tokenExpireDate);
		$user->setToken($token);

		$this->userHandeler->saveTokenCredentials($user);

		setcookie(self::$userCookie, $token, $tokenExpireDate);
	}

	public function removeCookie() {
		setCookie(self::$userCookie, $this->getCookieValue(), time() - 3600);
	}

	/**
	 * @return login\model\UserCredentials
	 */
	public function getUserCredentials() {
		try {
			return new \login\model\LoginCredentials($this->getUsername(), $this->getPassword());
		}

		catch (\Exception $e) {
			$this->inputFaulty();
			$this->saveUsername();
			$this->navigationView->gotoLoginPage();
		}
	}

	/**
	 * @return login\model\TokenCredentials
	 */
	public function getTokenCredentials() {
		try {
			if ($this->userIsRemembered()) {
				return new \login\model\TokenCredentials($this->getCookieValue());
			}

			return new \login\model\TokenCredentials();
		}

		catch (\Exception $e) {

		}
	}

	private function saveUsername() {
		$_SESSION[self::$saveUsername] = $this->getUsername();
	}

	public function errorMessage() {
		$_SESSION[self::$errorMessage] = "<p>Wrong username or password</p>";
	}

	/**
	 * @return string HTML
	 */
	private function inputFaulty() {
		$errorMessage = "";

		if ($this->getUsername() == "") {
			$errorMessage .= "<p>Enter your username</p>";
		}

		if ($this->getPassword() == "") {
			$errorMessage .= "<p>Enter your password</p>";
		}

		$_SESSION[self::$inputFaultyMessage] = $errorMessage;
	}
}