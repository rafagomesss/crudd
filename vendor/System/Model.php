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

	public function insert()
	{
		try{
			$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$stmt = $this->conexao->prepare("INSERT INTO {$this->table} (email, password) VALUES (:email, :password)");
			$stmt->bindValue(':email', $data['email'], \PDO::PARAM_STR);
			$stmt->bindValue(':password', password_hash($data['password'], PASSWORD_BCRYPT, ["cost" => 12]), \PDO::PARAM_STR);
			$stmt->execute();
			return ['message' => 'Registro salvo com sucesso!'];
		} catch (\PDOException $e) {
			return ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
		}
	}
}
