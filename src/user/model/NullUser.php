<?php

namespace user\model;

require_once("src/user/model/User.php");

/**
 * Nullable User used when no user is logged in
 */
class NullUser extends User {

	public function __construct() {

	}
}