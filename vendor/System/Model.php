<?php
namespace System;

use System\Connection;

class Model extends Connection
{
	public $conexao;
	protected $table;

	public function __construct()
	{
		$this->conexao = Connection::conexao();
	}

	public function findAll()
	{
		$stmt = $this->conexao->query("SELECT * FROM {$this->table}");
		return $stmt->fetchAll();
	}

	public function find($id)
	{
		$stmt = $this->conexao->prepare("SELECT * FROM {$this->table} WHERE id = :id");
		$stmt->bindParam(':id', $id, \PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}
}
