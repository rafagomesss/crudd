<?php
namespace System;

use System\Connection;
use System\Router;

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

	public function insert(array $data = [])
	{
		try{
			$sql = "INSERT INTO {$this->table} (" . implode(',', array_keys($data)). ") VALUES (:" . implode(', :', array_keys($data)) . ")";
			$stmt = $this->bind($sql, $data);
			$stmt->execute();
			return ['message' => 'Registro salvo com sucesso!'];
		} catch (\PDOException $e) {
			return ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
		}
	}

	public function delete()
	{
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
		try{
			$sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
			$delete = $this->bind($sql, ['id' => $id]);
			$delete->execute();
			if ($delete->rowCount() > 0) {
				return ['message' => 'Registro excluído com sucesso!'];
			}
			throw new CruddException('danger', 'Registro não encontrado!', 286);
		} catch (\PDOException $e) {
			return ['erro' => true, 'code' => $e->getCode(), 'message' => $e->getMessage()];
		}
	}

	public function update(array $data): array
	{
		try{
			if (!array_key_exists('id', $data)) {
				throw new CruddException('warning', 'ID não encontrado!', 286, true);
			}

			$datasSql = '';

			foreach($data as $key => $value)
			{
				if($key !== 'id') {
					$datasSql .= $key . ' = ' . ':' . $key . ', ';
				}
			}

			$datasSql = substr($datasSql, 0, -2);

			$sql = "UPDATE " . $this->table . " SET " . $datasSql . " WHERE id = :id";
			$stmt = $this->bind($sql, $data);
			if ($stmt->execute()) {
				return ['message' => 'Registro atualizado com sucesso!'];
			}
			throw new CruddException('error', 'Falha ao atualizar registro!', 2, true);
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
