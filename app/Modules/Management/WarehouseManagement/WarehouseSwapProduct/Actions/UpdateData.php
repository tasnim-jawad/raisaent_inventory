<?php

namespace App\Modules\Management\WarehouseManagement\WarehouseSwapProduct\Actions;

class UpdateData
{

    static $model = \App\Modules\Management\WarehouseManagement\WarehouseSwapProduct\Models\Model::class;
    static $WareHouseProductStockModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;

    public static function execute($request, $slug)
    {
        try {

            $requestData = $request->validated();

            if ($requestData['from_warehouse_id'] == $requestData['to_warehouse_id']) {
                return messageResponse('From warehouse and to warehouse can not be same', [], 500, 'server_error');
            }


            $WareHouseProductStock = self::$WareHouseProductStockModel::with(['ware_house_product_stock_products' => function ($query) use ($requestData) {
                $query->where('product_id', $requestData['product_id']);
            }])
                ->where('warehouse_id', $requestData['from_warehouse_id'])
                ->first();

            if (!$WareHouseProductStock || $WareHouseProductStock->ware_house_product_stock_products->isEmpty()) {
                return messageResponse('Product not found in stock', [], 404, 'not_found');
            }

            $WareHouseProductStockProduct = $WareHouseProductStock->ware_house_product_stock_products->first();

            if ($WareHouseProductStockProduct->quantity < $requestData['quantity']) {
                return messageResponse('Quantity is not available in stock', [], 500, 'server_error');
            }



            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...', $data, 404, 'error');
            }


            $WareHouseProductStockProduct->quantity = $data->quantity + $WareHouseProductStockProduct->quantity;
            $WareHouseProductStockProduct->available_for_stock = $WareHouseProductStockProduct->quantity;
            $WareHouseProductStockProduct->save();



            if ($data->update($requestData)) {
                $WareHouseProductStockProduct->quantity = $WareHouseProductStockProduct->quantity - $requestData['quantity'];
                $WareHouseProductStockProduct->available_for_stock = $WareHouseProductStockProduct->quantity;
                $WareHouseProductStockProduct->save();
            }


            return messageResponse('Item updated successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
