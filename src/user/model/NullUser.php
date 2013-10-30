<?php

namespace user\model;

/**
 * Nullable User used when no user is logged in
 */
class NullUser extends User {

	public function __construct() {

	}
}