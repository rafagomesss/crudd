<?php
namespace Crud\Model;

use System\Model;

class ModelExpense extends Model
{
    public function __construct()
    {
        $this->table = 'expense';
        parent::__construct();
    }
}