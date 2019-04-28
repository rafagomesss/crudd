<?php
namespace Crud\Model;

use System\Model;

class AccessLevelModel extends Model
{
	public function __construct()
	{
		$this->table = 'access_level';
		parent::__construct();
	}
}
