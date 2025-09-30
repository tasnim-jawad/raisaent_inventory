<?php

use App\Modules\Management\Reporting\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('get-all-expense-report',[Controller::class,'GetAllExpenseReport']);
    Route::get('get-all-income-report',[Controller::class,'GetAllIncomeReport']);
    Route::get('get-all-income-expense-report', [Controller::class,'GetaAllIncomeExpenseReport']);

});
