<?php

use App\Modules\Management\Dashboard\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('get-all-dashboard-data', [Controller::class,'GetAllDashboardData']);
});
