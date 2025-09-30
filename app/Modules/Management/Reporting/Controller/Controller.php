<?php

namespace App\Modules\Management\Reporting\Controller;

use App\Modules\Management\Reporting\Actions\GetAllIncomeExpenseReport;

use App\Http\Controllers\Controller as ControllersController;
use App\Modules\Management\Reporting\Actions\GetAllExpenseReport;
use App\Modules\Management\Reporting\Actions\GetAllIncomeReport;
class Controller extends ControllersController
{
    public function GetAllExpenseReport()
    {
        $data = GetAllExpenseReport::execute();
        return $data;
    }
    public function GetAllIncomeReport()
    {
        $data = GetAllIncomeReport::execute();
        return $data;
    }
   
    public function GetaAllIncomeExpenseReport()
    {
        $data = GetAllIncomeExpenseReport::execute();
        return $data;
    }

}
