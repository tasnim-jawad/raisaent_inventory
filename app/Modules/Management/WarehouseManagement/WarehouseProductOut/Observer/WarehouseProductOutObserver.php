<?php

namespace App\Modules\Management\WarehouseManagement\WarehouseProductOut\Observer;

use App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\WareHouseProductOutProductModel  as WarehouseProductOut;
use Illuminate\Support\Facades\Log;

class WarehouseProductOutObserver
{
    static $WareHouseProductOutModel = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\Model::class;
    static $WarehouseProductOutLogModel = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\WarehouseProductOutLogModel::class;
    /**
     * Handle the WarehouseProductOut "created" event.
     */
    public function created(WarehouseProductOut $warehouseProductOut): void
    {

        $warehouseProductOutData = self::$WareHouseProductOutModel::find($warehouseProductOut->ware_house_product_out_id);

        $data = [
            'warehouse_product_out' =>  $warehouseProductOutData,
            'warehouse_product_out_products' => $warehouseProductOut,
        ];

        self::$WarehouseProductOutLogModel::create([
            'ware_house_product_out_id' => $warehouseProductOut->ware_house_product_out_id,
            'data' => $data,
        ]);
    }

    /**
     * Handle the WarehouseProductOut "updated" event.
     */
    public function updated(WarehouseProductOut $warehouseProductOut): void
    {
        $warehouseProductOutData = self::$WareHouseProductOutModel::find($warehouseProductOut->ware_house_product_out_id);

        $data = [
            'warehouse_product_out' =>  $warehouseProductOutData,
            'warehouse_product_out_products' => $warehouseProductOut,
        ];

        self::$WarehouseProductOutLogModel::create([
            'ware_house_product_out_id' => $warehouseProductOut->ware_house_product_out_id,
            'data' => $data,
        ]);
    }

    /**
     * Handle the WarehouseProductOut "deleted" event.
     */
    public function deleted(WarehouseProductOut $warehouseProductOut): void
    {
        //
    }

    /**
     * Handle the WarehouseProductOut "restored" event.
     */
    public function restored(WarehouseProductOut $warehouseProductOut): void
    {
        //
    }

    /**
     * Handle the WarehouseProductOut "force deleted" event.
     */
    public function forceDeleted(WarehouseProductOut $warehouseProductOut): void
    {
        //
    }
}
