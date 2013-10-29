<?php

namespace login\model;

class TokenCredentials {
	/**
	 * @var string
	 */
	private $token;

	/**
	 * @param string $token
	 */
	public function __construct($token) {
		if (!is_string($token) || $token == "") {
			throw new \Exception("Invalid token");
		}
		
		$this->token = $token;
	}

	/**
	 * @return string
	 */
	public function getToken() {
		return $this->token;
	}
}


