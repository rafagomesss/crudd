<?php
namespace Crud\Model;

use System\Model;

class ModelUsuario extends Model
{
	public function __construct()
	{
		$this->table = 'user_access';
		parent::__construct();
	}

	/*public function listarUsuarios()
	{
		$stmt = $this->conexao->query("SELECT * FROM USER_ACCESS");
		return $stmt->fetchAll();
	}*/
}
