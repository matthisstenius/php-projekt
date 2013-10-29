<?php

namespace login\model;

class NullTokenCredentials extends TokenCredentials {
	public function __construct() {
		// Empty
	}
}