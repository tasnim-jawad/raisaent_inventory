<?php

namespace App\Modules\Management\WarehouseManagement\WarehouseProductOut\Actions;

class UpdateData
{
    static $model = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\Model::class;
    static $WareHouseProductOutProductModel = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\WareHouseProductOutProductModel::class;
    static $WareHouseProductStockModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;
    static $SalesOrderProductModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderProductModel::class;
    public static function execute($request, $slug)
    {
        try {


            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...', $data, 404, 'error');
            }



            // if ($request->product_items) {

            //     $is_available_for_stock = self::$SalesOrderProductModel::where([
            //         'sales_order_id' => $request->purchase_order_id,
            //         'product_id' => $request->product_items['product_id'],
            //     ])->first();

            //     if (!$is_available_for_stock) {
            //         return messageResponse('Product not found: ' . $request->product_items['product_name'], [], 404, 'not_found');
            //     }

            //     $curentStorckQuantity = self::$WareHouseProductOutProductModel::where([
            //         'ware_house_product_out_id' => $data->id,
            //         'product_id' => $request->product_items['product_id'],
            //     ])->first();

            //     $requestForStockQuantity = $request->product_items['quantity'] ?? 0;
            //     $totalStockQuantity = ($is_available_for_stock->available_for_stock ?? 0) +  ($curentStorckQuantity->quantity ?? 0);



            //     if ($requestForStockQuantity > $totalStockQuantity) {
            //         return messageResponse(
            //             'Insufficient stock for product: ' . $request->product_items['product_name'],
            //             [],
            //             400,
            //             'error'
            //         );
            //     }
            // }






            $previousrData =  self::$WareHouseProductOutProductModel::where('ware_house_product_out_id', $data->id)->where('product_id', $request->product_items['product_id'])->first();

            $WareHouseProductStockProductBalance =  self::$WareHouseProductStockModel::where('warehouse_id', $data->warehouse_id)->first();

            $product_item = $WareHouseProductStockProductBalance->ware_house_product_stock_products()
                ->where('product_id', $request->product_items['product_id'])
                ->first();

            if ($request->product_items['quantity'] > $product_item->quantity) {
                return messageResponse('Product quantity is not available for : ' . $product_item['product_name'], [], 400, 'error');
            }
            
            $product_item->quantity +=  $previousrData->quantity;
            $product_item->save();

            self::$WareHouseProductOutProductModel::where('ware_house_product_out_id', $data->id)->forceDelete();


            self::$WareHouseProductOutProductModel::query()->create([
                'ware_house_product_out_id' => $data->id,
                'product_id' => $request->product_items['product_id'],
                'product_name' => $request->product_items['product_name'],
                'quantity' => $request->product_items['quantity'],
            ]);


            $requestData = $request->validated();
            $data->update($requestData);
            return messageResponse('Item updated successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
