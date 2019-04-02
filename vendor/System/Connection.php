<?php
namespace System;

class Connection
{
	protected static $db;

	private function __construct()
	{
		$db_host = "localhost";
		$db_nome = "omni";
		$db_usuario = "root";
		$db_senha = "";
		$db_driver = "mysql";

		try
		{
			self::$db = new \PDO("$db_driver:host=$db_host; dbname=$db_nome", $db_usuario, $db_senha);
			self::$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			self::$db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			self::$db->exec('SET NAMES utf8');
		}
		catch (\PDOException $e)
		{
			die("Connection Error: " . $e->getMessage());
		}
	}

	public static function conexao()
	{
		if (!self::$db)
		{
			new Connection();
		}
		return self::$db;
	}
}
