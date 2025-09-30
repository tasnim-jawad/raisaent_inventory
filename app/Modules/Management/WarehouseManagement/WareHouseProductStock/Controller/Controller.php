<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Controller;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\GetAllData;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\DestroyData;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\GetSingleData;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\StoreData;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\UpdateData;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\UpdateStatus;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\SoftDelete;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\RestoreData;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\ImportData;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\GetWarehouseProductAvailableStockQuantity;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\GetProductStockQuantityByProductId;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Validations\BulkActionsValidation;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Validations\DataStoreValidation;
use App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions\BulkActions;
use App\Http\Controllers\Controller as ControllersController;


class Controller extends ControllersController
{

    public function index( ){

        $data = GetAllData::execute();
        return $data;
    }

    public function store(DataStoreValidation $request)
    {
        $data = StoreData::execute($request);
        return $data;
    }

    public function show($slug)
    {
        $data = GetSingleData::execute($slug);
        return $data;
    }

    public function update(DataStoreValidation $request, $slug)
    {
        $data = UpdateData::execute($request, $slug);
        return $data;
    }
         public function updateStatus()
    {
        $data = UpdateStatus::execute();
        return $data;
    }

    public function softDelete()
    {
        $data = SoftDelete::execute();
        return $data;
    }
    public function destroy($slug)
    {
        $data = DestroyData::execute($slug);
        return $data;
    }
    public function restore()
    {
        $data = RestoreData::execute();
        return $data;
    }
    public function import()
    {
        $data = ImportData::execute();
        return $data;
    }
    public function bulkAction(BulkActionsValidation $request)
    {
        $data = BulkActions::execute($request);
        return $data;
    }
    public function GetWarehouseProductAvailableStockQuantity()
    {
        $data = GetWarehouseProductAvailableStockQuantity::execute();
        return $data;
    }
    public function GetProductStockQuantityByProductId($product_id)
    {
        $data = GetProductStockQuantityByProductId::execute($product_id);
        return $data;
    }

}