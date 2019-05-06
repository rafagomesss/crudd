<?php
namespace Crud\Controller;

use Crud\Model\ModelCategory;
use Crud\Model\ModelExpense;
use Crud\View\View;
use System\Session\Session;

class ExpenseController
{

    public function __construct()
    {
        $this->model = new ModelExpense();
    }

	public function list()
    {
		$view = new View('site/expense/list.phtml', true);
        $view->controller = 'expense';
        $view->myExpenses = $this->model->executeProcedureReturbale('getUserExpenses', [Session::get('USER_ID')]);
		return $view->render();
	}

    public function register()
    {
        $view = new View('site/expense/register.phtml', true);
        $view->controller = 'expense';
        $view->viewName = 'register';
        $view->categories = (new ModelCategory())->findAll();
        return $view->render();
    }

    public function edit($id)
    {
        $view = new View('site/expense/edit.phtml', true);
        $view->controller = 'expense';
        $view->expense = $this->model->find($id);
        $view->categories = (new ModelCategory())->findAll();
        return $view->render();
    }

    public function insert()
    {
        echo json_encode($this->model->insert());
    }

    public function delete()
    {
        echo json_encode($this->model->delete());
    }

    public function update()
    {
        $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        echo json_encode($this->model->update($data));
    }
}
