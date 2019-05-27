<?php
namespace Crud\Controller;

use Crud\Model\ModelExpense;
use Crud\View\View;
use System\Common;
use System\Session\Session;

class ReportController
{
    private $model;

    public function __construct()
    {
        $this->model = new ModelExpense();
    }

    public function category()
    {
        $view = new View("site/report/category.phtml", true);
        $view->controller = 'report';
        $view->myExpenses = $this->model->executeProcedureReturbale('reportUserExpenseByCategory', [Session::get('USER_ID')]);
        $view->category = empty($view->myExpenses) ? null : Common::filterDataToReport('category', $view->myExpenses);
        return $view->render();
    }

    public function value()
    {
        $view = new View("site/report/value.phtml", true);
        $view->controller = 'report';
        $view->myExpenses = $this->model->executeProcedureReturbale('reportUserExpenseByValue', [Session::get('USER_ID')]);
        $view->total = 0;
        foreach ($view->myExpenses as $key => $value) {
            $view->total += (int) $value->value;
        }
        $view->total = number_format($view->total, 2, ',', '.');
        $view->value = empty($view->myExpenses) ? null : Common::filterDataToReport('value', $view->myExpenses);
        return $view->render();
    }
}
