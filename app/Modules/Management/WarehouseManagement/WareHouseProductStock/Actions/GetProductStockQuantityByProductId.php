<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions;

class GetProductStockQuantityByProductId
{
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;

    public static function execute($prduct_id)
    {
        try {


            $WareHouseProductStockProductsQuantity = self::$WareHouseProductStockProductModel::where('product_id', $prduct_id)->sum('quantity');
            return entityResponse($WareHouseProductStockProductsQuantity);

        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
