<?php

namespace register\model;

class Register {
	/**
	 * @var user\model\NewUser
	 */
	private $user;

	/**
	 * @var user\model\UserHandeler
	 */
	private $userHandeler;

	public function __construct(\user\model\NewUser $newUser, \user\model\UserHandeler $userHandeler) {

		$this->user = $newUser;
		$this->userHandeler = $userHandeler;
	}

	public function isUsernameFree() {
		foreach ($this->userHandeler->getUsers() as $user) {
			if ($this->user->getUsername() == $user->getUsername()) {
				throw new \Exception("Username already exist");
			}
		}

		return true;	
	}
}