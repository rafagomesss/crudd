<?php
namespace Crud\Controller;

use Crud\Model\ModelExpense;
use Crud\View\View;

class ExpenseController
{

    public function __construct()
    {
        $this->model = new ModelExpense();
    }

	public function list()
    {
		$view = new View('site/expense/list.phtml', true);
        $view->myExpenses = $this->model->findAll();
		return $view->render();
	}
}
