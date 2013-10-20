<?php

namespace common\model;

class DALBase {
	private static $dbName = "Blog";
	private static $host = "127.0.0.1";
	private static $username = "root";
	private static $password = "7scTt8MB";
	private static $charset = "utf8";

	/**
	 * @return PDO
	 */
	public static function getDBConnection() {
		try {
		 	$pdo = new \PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=" . self::$charset
		 	, self::$username, self::$password);
		 	$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		 	return $pdo;
		} 
		
		catch (\PDOException $e) {

		}
	}
}