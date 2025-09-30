<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions;

class UpdateData
{
    static $model = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;
    static $PurchaseOrderProductModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderProductModel::class;
    public static function execute($request, $slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...', $data, 404, 'error');
            }

            if ($request->product_items) {
                foreach ($request->product_items as $product_item) {
                    $is_available_for_stock = self::$PurchaseOrderProductModel::where([
                        'purchase_order_id' => $request->purchase_order_id,
                        'product_id' => $product_item['product_id'],
                    ])->first();

                    if (!$is_available_for_stock) {
                        return messageResponse('Product not found: ' . $product_item['product_name'], [], 404, 'not_found');
                    }

                    $curentStorckQuantity = self::$WareHouseProductStockProductModel::where([
                        'ware_house_product_stock_id' => $data->id,
                        'product_id' => $product_item['product_id'],
                    ])->first();

                    $requestForStockQuantity = $product_item['quantity'] ?? 0;
                    $totalStockQuantity = ($is_available_for_stock->available_for_stock ?? 0) +  ($curentStorckQuantity->quantity ?? 0);



                    if ($requestForStockQuantity > $totalStockQuantity) {
                        return messageResponse(
                            'Insufficient stock for product: ' . $product_item['product_name'],
                            [],
                            400,
                            'error'
                        );
                    }
                }
            }

            if ($request->product_items && count($request->product_items) > 0) {

                $previousrData =  self::$WareHouseProductStockProductModel::where('ware_house_product_stock_id', $data->id)->get();

                foreach ($previousrData as $item) {
                    self::$PurchaseOrderProductModel::where([
                        'purchase_order_id' => $data->purchase_order_id,
                        'product_id' => $item->product_id,
                    ])->increment('available_for_stock', $item->quantity);

                    self::$WareHouseProductStockProductModel::where('id', $item->id)->forceDelete();
                }


                foreach ($request->product_items as $product_item) {

                    $stockProduct =  self::$WareHouseProductStockProductModel::query()->create([
                        'ware_house_product_stock_id' => $data->id,
                        'product_id' => $product_item['product_id'],
                        'product_name' => $product_item['product_name'],
                        'quantity' => $product_item['quantity'],
                    ]);

                    $updateAvailableStock = self::$PurchaseOrderProductModel::where([
                        'purchase_order_id' => $data->purchase_order_id,
                        'product_id' => $product_item['product_id'],
                    ])->first();

                    $updateAvailableStock->available_for_stock = $updateAvailableStock->available_for_stock - $product_item['quantity'];
                    $updateAvailableStock->save();
                    $stockProduct->available_for_stock = $updateAvailableStock->available_for_stock;
                    $stockProduct->save();
                }
            } else {
                $previousrData =  self::$WareHouseProductStockProductModel::where('ware_house_product_stock_id', $data->id)->get();
                foreach ($previousrData as $item) {
                    self::$PurchaseOrderProductModel::where([
                        'purchase_order_id' => $data->purchase_order_id,
                        'product_id' => $item->product_id,
                    ])->increment('available_for_stock', $item->quantity);

                    self::$WareHouseProductStockProductModel::where('id', $item->id)->forceDelete();
                }
            }
            $requestData = $request->validated();
            $data->update($requestData);
            return messageResponse('Item updated successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
