<?php
namespace System;

use System\Connection;

class Model extends Connection
{
	public $connection;
	protected $table;

	public function __construct()
	{
		$this->connection = Connection::getInstance();
	}

	private function bind($sql, $data)
	{
		$bind = $this->connection->prepare($sql);
		foreach ($data as $k => $v) {
			gettype($v) == 'int' ? $bind->bindValue(':' . $k, $v, \PDO::PARAM_INT)
				: $bind->bindValue(':' . $k, $v, \PDO::PARAM_STR);
		}
		return $bind;
	}

	public function where(array $conditions, $operator = ' AND ', $fields = '*') : array
	{
		$sql = 'SELECT ' . $fields . ' FROM ' . $this->table . ' WHERE ';
		$binds = array_keys($conditions);
		$where  = null;
		foreach($binds as $v) {
			if(is_null($where)) {
				$where .= $v . ' = :' . $v;
			} else {
				$where .= $operator . $v . ' = :' . $v;
			}
		}
		$sql .= $where;
		$get = $this->bind($sql, $conditions);
		$get->execute();
		return $get->fetchAll();
	}

	public function findAll($fields = '*')
	{
		$sql = 'SELECT ' . $fields . ' FROM ' . $this->table;
		$get = $this->connection->query($sql);
		return $get->fetchAll();
	}

	public function find(int $id, $fields = '*')
	{
		return current($this->where(['id' => $id], '', $fields));
	}

	public function insert()
	{
		try{
			$data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
			$sql = "INSERT INTO {$this->table} (" . implode(',', array_keys($data)). ") VALUES (:" . implode(', :', array_keys($data)) . ")";
			$stmt = $this->bind($sql, $data);
			$stmt->execute();
			return ['message' => 'Registro salvo com sucesso!'];
		} catch (\PDOException $e) {
			return ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
		}
	}

	public function delete($id = null)
	{
		$id = $id ?? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
		try{
			$sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
			$delete = $this->bind($sql, ['id' => $id]);
			$delete->execute();
			if ($delete->rowCount() > 0) {
				return ['message' => 'Registro excluído com sucesso!'];
			} else {
				throw new \PDOException("Registro não encontrado", 1);
			}
		} catch (\PDOException $e) {
			return ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
		}
	}

	public function update(array $data): array
	{
		try{
			$stmt = $this->connection->prepare("UPDATE {$this->table} SET email = :email, password = :password, access_level_id = :access_level_id WHERE id = :id");
			$stmt->bindValue(':email', $data['email'], \PDO::PARAM_STR);
			$stmt->bindValue(':password', password_hash($data['password'], PASSWORD_BCRYPT, ["cost" => 12]), \PDO::PARAM_STR);
			$stmt->bindValue(':id', $data['id'], \PDO::PARAM_INT);
			$stmt->bindValue(':access_level_id', $data['access_level'], \PDO::PARAM_INT);
			$stmt->execute();
			if ($stmt->execute()) {
				return ['message' => 'Registro atualizado com sucesso!'];
			} else {
				throw new \PDOException("Falha ao atualizar registro", 2);
			}
		} catch (\PDOException $e) {
			return ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
		}
	}

	public function findBy(array $dados)
	{
		$stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE email = :email");
		$stmt->bindParam(':email', $dados['email'], \PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function executeProcedureReturbale(string $procedureName, array $data = [])
	{
		$sql = "CALL {$procedureName}";
		if (is_array($data) && count($data) > 0) {
			$sql .= '(';
			foreach ($data as $value) {
				$sql .= "'$value'" . ',';
			}
			$sql = substr($sql, 0, -1);
			$sql .= ')';
		}
		$stmt = $this->connection->query($sql);
		return $stmt->fetchAll();
	}
}
