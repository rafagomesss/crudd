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

    public function reportData(string $type)
    {
        $view = new View("site/report/{$type}.phtml", true);
        $view->controller = 'report';
        $view->type = $type;
        $view->myExpenses = $this->model->executeProcedureReturbale('getUserExpenses', [Session::get('USER_ID')]);
        $view->{$type} = Common::filterDataToReport($type, $view->myExpenses);
        return $view->render();
    }
}
