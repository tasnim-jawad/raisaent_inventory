<?php

namespace App\Modules\Management\WarehouseManagement\WareHouse\Actions;

class GetProductRelatedWarehouseByOrderIdAndProductId
{
    static $model = \App\Modules\Management\WarehouseManagement\WareHouse\Models\Model::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;
    public static function execute()
    {
        try {


            $warehouseData = [];


            $data = self::$WareHouseProductStockProductModel::with('warehouse_product_stock:id,warehouse_id')->where('product_id', request('product_id'))->get();

            if ($data && count($data)) {
                foreach ($data as $item) {
                    $warehouse = self::$model::find($item['warehouse_product_stock']['warehouse_id']);
                    if ($warehouse) {
                        $warehouseData[] = [
                            "id" => $item['warehouse_product_stock']['warehouse_id'],
                            "name"  => $warehouse->name,
                            "quantity" => $item['quantity']
                        ];
                    }
                }
            }

            return entityResponse($warehouseData);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
