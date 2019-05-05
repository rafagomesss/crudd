<?php
namespace Crud\Model;

use System\Model;

class ModelCategory extends Model
{
    public function __construct()
    {
        $this->table = 'category';
        parent::__construct();
    }
}