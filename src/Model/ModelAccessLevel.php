<?php
namespace Crud\Model;

use System\Model;

class ModelAccessLevel extends Model
{
    public function __construct()
    {
        $this->table = 'access_level';
        parent::__construct();
    }
}
