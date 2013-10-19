<?php

namespace common\view;

class Filter {
	/**
	 * @param  string $input
	 * @return string
	 */
	public static function clean($input) {
		return trim(htmlentities($input));
	}
}