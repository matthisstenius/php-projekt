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
		$cleanTitle = preg_replace('/[()?!]*/', '', $input);
		$cleanTitle = preg_replace('/\s+/', ' ', $cleanTitle);
		$cleanTitle = str_replace(' ', '-', $cleanTitle);
		$cleanTitle = mb_strtolower($cleanTitle, 'UTF-8');

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

	/**
	 * @param  date $date
	 * @return date       ex 2013-01-01 20:00 pm
	 */
	public static function formatDate($date) {
		return \Date("Y-m-d H:i a", time($date));
	}
}