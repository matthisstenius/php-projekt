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

	/**
	 * @param  string $input
	 * @return string        Returns the forst 200 characters from given string
	 */
	public static function getExcerpt($input) {
		if (strlen($input) > 200) {
			return substr($input, 0, 200);
		}

		else {
			return $input;
		}
	}
}