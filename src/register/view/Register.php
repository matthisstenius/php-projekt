<?php

namespace register\view;

require_once("src/user/model/NewUser.php");

class Register {
	private static $username = "username";
	private static $password = "password";
	private static $passwordAgain = "passwordAgain";
	private static $inputFaultyMessage = "register::view::Register::inputFaultyMessage";
	private static $usernameAlreadyExist = "register::view::Register::usernameAlreadyExist";
	private static $saveUsername = "register::view::Register::saveUsername";

	/**
	 * @var common\view\Navigation
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
	public function getRegisterForm() {
		$html = "<div class='register-box centered'>
					<h1>Register account</h1>";

		$registerSrc = $this->navigationView->getRegisterSrc();

		if (isset($_SESSION[self::$inputFaultyMessage])) {
			$html .= $_SESSION[self::$inputFaultyMessage];
			unset($_SESSION[self::$inputFaultyMessage]);
		}

		if (isset($_SESSION[self::$usernameAlreadyExist])) {
			$html .= $_SESSION[self::$usernameAlreadyExist];
			unset($_SESSION[self::$usernameAlreadyExist]);
		}

		$username = "";

		if (isset($_SESSION[self::$saveUsername])) {
			$username .= $_SESSION[self::$saveUsername];
			unset($_SESSION[self::$saveUsername]);
		}

		$html .= "<form class='pure-form register-form' action='$registerSrc' method='POST'>
					<div class='pure-group'>
						<input type='text' name='" . self::$username . "' placeholder='Username' value='$username'>
						<input type='password' name='" . self::$password . "' placeholder='Password'>
						<input type='password' name='" . self::$passwordAgain . "' placeholder='Password Again'>

						<button class='btn btn-wide btn-register'>Create Account</button>
					</div>
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

		return "";
	}

	/**
	 * @return string clean string
	 */
	private function getPassword() {
		if (isset($_POST[self::$password])) {
			return \common\view\Filter::clean($_POST[self::$password]);
		}

		return "";
	}

	/**
	 * @return string clean string
	 */
	private function getPasswordAgain() {
		if (isset($_POST[self::$passwordAgain])) {
			return \common\view\Filter::clean($_POST[self::$passwordAgain]);
		}

		return "";
	}

	/**
	 * @return boolean
	 * @throws Exception If passwords don't match
	 */
	private function doesPasswordsMatch() {
		if ($this->getPassword() == $this->getPasswordAgain()) {
			return true;
		}

		throw new \Exception("Passwords don't match");
		
	}

	/**
	 * @return user\model\NewUser
	 */
	public function getUserCredentials() {
		try {
			if ($this->doesPasswordsMatch()) {
				return new \user\model\NewUser($this->getUsername(), $this->getPassword());
			}
			
		}

		catch (\Exception $e) {
			$this->InputFaulty();
			$this->saveUsername();
			$this->navigationView->gotoRegisterPage();
		}
	}

	public function saveUsername() {
		$_SESSION[self::$saveUsername] = $this->getUsername();
	}

	public function usernameAlreadyExist() {
		$_SESSION[self::$usernameAlreadyExist] = "<p>Username already exist</p>";
	}

	private function inputFaulty() {
		$errorMessage = "";

		if ($this->getUsername() == "") {
			$errorMessage .= "<p>Enter a username</p>";
		}


		else if (strlen($this->getUsername()) < 5) {
			$errorMessage .= "<p>Username to short. Miminum 5 charachters</p>";
		}

		else if (preg_match('/[^\w+]/', $this->getUsername())) {
			$errorMessage .= "<p>Invalid charachters in username.</br> Only alphanumeric charachters allowed.</p>";
		}

		if ($this->getPassword() == "") {
			$errorMessage .= "<p>Enter a password</p>";
		}

		else if (strlen($this->getPassword()) < 6) {
			$errorMessage .= "<p>Password to short. Minimum 6 charachters</p>";
		}

		if ($this->getPassword() != $this->getPasswordAgain()) {
			$errorMessage .= "<p>Password does not match</p>";
		}

		$_SESSION[self::$inputFaultyMessage] = $errorMessage;
	}
}