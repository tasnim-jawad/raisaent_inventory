<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions;

class StoreData
{
    static $model = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;
    static $PurchaseOrderProductModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderProductModel::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;

    public static function execute($request)
    {
        try {

            if (!$request->product_items) {
                return messageResponse('Please add at least one product', [], 500, 'server_error');
            }

            $requestData = $request->validated();



            if ($request->product_items) {
                foreach ($request->product_items as $product_item) {
                    $is_available_for_stock =   self::$PurchaseOrderProductModel::where([
                        'purchase_order_id' => $request->purchase_order_id,
                        'product_id' => $product_item['product_id'],
                    ])->first();

                    if (!$is_available_for_stock ||  $product_item['quantity'] == 0 || $is_available_for_stock->available_for_stock < $product_item['quantity']) {
                        return messageResponse('Product quantity is not available for : ' . $product_item['product_name'], [], 500, 'server_error');
                    }
                }
            }

            $is_warehouse_exist = self::$model::where([
                'warehouse_id' => $requestData['warehouse_id'],
                'purchase_order_id' => $requestData['purchase_order_id']
            ])->first();

            if ($is_warehouse_exist) {
                // Update or create product stock for existing warehouse
                foreach ($request->product_items as $product_item) {
                    $is_warehouse_product_exist = $is_warehouse_exist->ware_house_product_stock_products()
                        ->where('product_id', $product_item['product_id'])
                        ->first();

                    if ($is_warehouse_product_exist) {
                        // Update quantity if the product exists
                        $is_warehouse_product_exist->increment('quantity', $product_item['quantity']);
                        $is_warehouse_product_exist->decrement('available_for_stock', $product_item['quantity']);
                        $updateAvailableStock = self::$PurchaseOrderProductModel::where([
                            'purchase_order_id' => $is_warehouse_exist->purchase_order_id,
                            'product_id' => $product_item['product_id'],
                        ])->first();
                        if ($updateAvailableStock) {
                            $updateAvailableStock->decrement('available_for_stock', $product_item['quantity']);                          
                        }
                    } else {
                        // Create a new product stock record
                        $stockProduct = self::$WareHouseProductStockProductModel::create([
                            'ware_house_product_stock_id' => $is_warehouse_exist->id,
                            'product_id' => $product_item['product_id'],
                            'product_name' => $product_item['product_name'],
                            'quantity' => $product_item['quantity'],
                        ]);
                        $updateAvailableStock = self::$PurchaseOrderProductModel::where([
                            'purchase_order_id' => $is_warehouse_exist->purchase_order_id,
                            'product_id' => $product_item['product_id'],
                        ])->first();
    
                        if ($updateAvailableStock) {
                            $updateAvailableStock->decrement('available_for_stock', $product_item['quantity']);
                            $stockProduct->update(['available_for_stock' => $updateAvailableStock->available_for_stock]);
                        }
                    }
                }

                return messageResponse('Item added successfully', $is_warehouse_exist, 201);
            } else {
                // Create a new warehouse record if it doesn't exist
                $data = self::$model::create($requestData);

                foreach ($request->product_items as $product_item) {
                    // Create a new stock product record
                    $stockProduct = self::$WareHouseProductStockProductModel::create([
                        'ware_house_product_stock_id' => $data->id,
                        'product_id' => $product_item['product_id'],
                        'product_name' => $product_item['product_name'],
                        'quantity' => $product_item['quantity'],
                    ]);

                    // Update available stock in the purchase order product model
                    $updateAvailableStock = self::$PurchaseOrderProductModel::where([
                        'purchase_order_id' => $data->purchase_order_id,
                        'product_id' => $product_item['product_id'],
                    ])->first();

                    if ($updateAvailableStock) {
                        $updateAvailableStock->decrement('available_for_stock', $product_item['quantity']);
                        $stockProduct->update(['available_for_stock' => $updateAvailableStock->available_for_stock]);
                    }
                }

                return messageResponse('Item added successfully', $data, 201);
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
