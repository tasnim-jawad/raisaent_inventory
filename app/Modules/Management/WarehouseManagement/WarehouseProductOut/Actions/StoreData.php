<?php

namespace App\Modules\Management\WarehouseManagement\WarehouseProductOut\Actions;

class StoreData
{
    static $model = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\Model::class;
    static $SalesOrderProductModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderProductModel::class;
    static $WareHouseProductOutProductModel = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\WareHouseProductOutProductModel::class;
    static $WareHouseProductStockModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;

    public static function execute($request)
    {
        try {

            // if (!$request->product_items) {
            //     return messageResponse('Please add at least one product', [], 500, 'server_error');
            // }

            $requestData = $request->validated();



            // if ($request->product_items) {
            //     foreach ($request->product_items as $product_item) {
            //         $is_available_for_stock =   self::$SalesOrderProductModel::where([
            //             'sales_order_id' => $request->sales_order_id,
            //             'product_id' => $product_item['product_id'],
            //         ])->first();

            //         if (!$is_available_for_stock || $is_available_for_stock->quantity < $product_item['quantity']) {
            //             return messageResponse('Product quantity is not available for : ' . $product_item['product_name'], [], 500, 'server_error');
            //         }
            //     }
            // }

            $WareHouseProductStock = self::$WareHouseProductStockModel::where('warehouse_id', $request->warehouse_id)->first();

            $product_item = $WareHouseProductStock->ware_house_product_stock_products()
                ->where('product_id', $request->product_items['product_id'])
                ->first();

            if ($request->product_items['quantity'] > $product_item->quantity) {
                return messageResponse('Product quantity is not available for : ' . $product_item['product_name'], [], 400, 'error');
            }



            if ($data = self::$model::query()->create($requestData)) {
                self::$WareHouseProductOutProductModel::query()->create([
                    'ware_house_product_out_id' => $data->id,
                    'product_id' => $request->product_items['product_id'],
                    'product_name' => $request->product_items['product_name'],
                    'quantity' => $request->product_items['quantity'],
                ]);


                $product_item->quantity -= $request->product_items['quantity'];
                $product_item->save();


                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
