<?php

namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Controller;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\LogSearch;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\GetAllData;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\DestroyData;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\GetSingleData;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\StoreData;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\UpdateData;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\UpdateStatus;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\SoftDelete;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\RestoreData;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\ImportData;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\GetPurchaseOrderProductsByOrderId;

use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Validations\BulkActionsValidation;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Validations\DataStoreValidation;
use App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions\BulkActions;
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
    public function logSearch()
    {
        $data = LogSearch::execute();
        return $data;
    }
    public function GetPurchaseOrderProductsByOrderId($purchase_order_id)
    {
        $data = GetPurchaseOrderProductsByOrderId::execute($purchase_order_id);
        return $data;
    }

}
