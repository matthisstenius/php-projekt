<?php

namespace login\model;

class TokenGenerator extends TokenCredentials {
	/**
	 * @var string
	 */
	private $tokenExpireDate;

	public function __construct() {
		$this->token = uniqid();
		$this->tokenExpireDate = time() + 60 * 60 * 120;
	}

	/**
	 * @return string
	 */
	public function getTokenExpireDate() {
		return $this->tokenExpireDate;
	}
}