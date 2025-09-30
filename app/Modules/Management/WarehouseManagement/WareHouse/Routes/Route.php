<?php

use App\Modules\Management\WarehouseManagement\WareHouse\Controller\Controller;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('ware-houses')->group(function () {
        Route::get('', [Controller::class, 'index']);
        Route::get('{slug}', [Controller::class, 'show']);
        Route::post('store', [Controller::class, 'store']);
        Route::post('update/{slug}', [Controller::class, 'update']);
        Route::post('update-status', [Controller::class, 'updateStatus']);
        Route::post('soft-delete', [Controller::class, 'softDelete']);
        Route::post('destroy/{slug}', [Controller::class, 'destroy']);
        Route::post('restore', [Controller::class, 'restore']);
        Route::post('import', [Controller::class, 'import']);
        Route::post('bulk-action', [Controller::class, 'bulkAction']);
        Route::get('warehouse-wise-product-lists/{slug}', [Controller::class, 'GetWarehouseWiseProductLists']);
    });

    Route::get('get-product-related-warehouse-by-order-id-and-product-id', [Controller::class, 'GetProductRelatedWarehouseByOrderIdAndProductId']);
});
