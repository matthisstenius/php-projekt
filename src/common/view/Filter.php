<?php

namespace common\view;

class Filter {
	/**
	 * @param  string $input
	 * @return string
	 */
	public static function clean($input) {
		return trim(htmlspecialchars($input));
	}

	/**
	 * @param  string $input string with spaces
	 * @return string        string with dash insetad of space
	 */
	public static function getCleanUrl($input) {
		$cleanTitle = preg_replace('/\s+/', ' ', $input);
		$cleanTitle = str_replace(' ', '-', $cleanTitle);
		$cleanTitle = strtolower($cleanTitle);

		return $cleanTitle;
	}
}