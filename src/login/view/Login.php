<?php

namespace login\view;

require_once("src/login/model/LoginCredentials.php");

class Login {
	private static $username = "username";
	private static $password = "password";

	/**
	 * @var common\view\Navigtion
	 */
	private $navigationView;

	/**
	 * @param common\view\Navigation $navigationView
	 */
	public function __construct(\common\view\Navigation $navigationView) {
		$this->navigationView = $navigationView;
	}

	/**
	 * @return string HTML
	 */
	public function getLoginForm() {
		$html = "<h1>Log in</h1>";

		$loginSrc = $this->navigationView->getLoginSrc();

		if (isset($_SESSION['errorMessage'])) {
			$html .= $this->userInputFaulty();
			unset($_SESSION['errorMessage']);
		}

		$html .= "<form class='pure-form pure-form-stacked' action='$loginSrc' method='POST'>
					<input type='text' name='" . self::$username . "' placeholder='Username'>
					<input type='password' name='" . self::$password . "' placeholder='Password'>

					<button class='btn btn-login'>Log In</button>
				</form>";

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

	public function getUserCredentials() {
		try {
			return new \login\model\LoginCredentials($this->getUsername(), $this->getPassword());
		}

		catch (\Exception $e) {
			$this->setErrorMessage();
			$this->navigationView->gotoLoginPage();
		}
	}

	public function setErrorMessage() {
		$_SESSION['errorMessage'] = true;
	}

	/**
	 * @return string HTML
	 */
	private function userInputFaulty() {
		$errorMessage = "";

		if ($this->getUsername() == "") {
			$errorMessage .= "<p>Enter your username</p>";
		}

		if ($this->getPassword() == "") {
			$errorMessage .= "<p>Enter your password</p>";
		}

		return $errorMessage;
	}
}