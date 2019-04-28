<?php
namespace System;

class Connection
{
	protected static $db;

	private function __construct()
	{
		$db_host = "localhost";
		$db_name = "omni";
		$db_user = "root";
		$db_password = "";
		$db_driver = "mysql";

		try {
			self::$db = new \PDO("$db_driver:host=$db_host; dbname=$db_name", $db_user, $db_password);
			self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			self::$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			self::$db->exec('SET NAMES utf8');
		} catch (\PDOException $e) {
			die("Connection Error: " . $e->getMessage());
		}
	}

	public static function getInstance()
	{
		if (!self::$db) {
			new Connection();
		}
		return self::$db;
	}
}
