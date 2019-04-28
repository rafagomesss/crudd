<?php
namespace Crud\Model;

use System\Model;

class ModelUser extends Model
{
    public function __construct()
    {
        $this->table = 'user_access';
        parent::__construct();
    }
}
