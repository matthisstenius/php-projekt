<?php

namespace login\model;

class TokenCredentials {
	/**
	 * @var string
	 */
	protected $token;

	/**
	 * @param string $token
	 */
	public function __construct($token = null) {
		if ($token != null) {
			if (!is_string($token) || $token == "") {
				throw new \Exception("Invalid token");
			}

			$this->token = $token;	
		}
	}

	/**
	 * @return string
	 */
	public function getToken() {
		return $this->token;
	}
}


