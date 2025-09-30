<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions;

class GetWarehouseProductAvailableStockQuantity
{
    static $model = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;

    public static function execute()
    {
        try {
            $requestData = request()->all();

            $WareHouseProductStock = self::$model::with(['ware_house_product_stock_products' => function ($query) use ($requestData) {
                $query->where('product_id', $requestData['product_id']);
            }])
                ->where('warehouse_id', $requestData['warehouse_id'])
                ->first();

            if (!$WareHouseProductStock || $WareHouseProductStock->ware_house_product_stock_products->isEmpty()) {
                return messageResponse('Product not found in stock', [], 200);
            }

            $WareHouseProductStockProduct = $WareHouseProductStock->ware_house_product_stock_products->first();



            return messageResponse('Quantity is available  for swap : ' . $WareHouseProductStockProduct->quantity, [], 200);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
