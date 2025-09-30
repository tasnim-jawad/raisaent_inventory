<?php

namespace App\Modules\Management\SalesOrderManagement\SalesOrder\Actions;

use Illuminate\Support\Str;

class StoreData
{
    static $model = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\Model::class;
    static $SalesOrderProductModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderProductModel::class;
    static $SalesOrderLogModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderLogModel::class;
    static $SalesOrderCollectionHistorymodel = \App\Modules\Management\SalesOrderManagement\SalesOrderCollectionHistory\Models\Model::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;
    public static function execute($request)
    {
        try {

            if (!$request->product_items) {
                return messageResponse('Please add at least one product', [], 500, 'server_error');
            }


            foreach ($request->product_items as $product) {
                $totalProduct =   self::$WareHouseProductStockProductModel::where('product_id', $product['product_id'])->sum('quantity');

                if ($totalProduct == 0) {
                    return messageResponse('Product is not available in warehouse stock', [], 500, 'server_error');
                }

                if ($totalProduct < $product['quantity']) {
                    return messageResponse('Quantity is not available in stock for product : ' . $product['product_name'] .  '  Available in stock : ' . $totalProduct, [], 500, 'server_error');
                }
            }


            $requestData = $request->validated();
            $requestData['order_status'] = $request->due == 0  ? 'paid' : 'due';
            $requestData['order_id'] = "SO-" . uniqid();
            if ($data = self::$model::query()->create($requestData)) {
                if ($requestData['paid'] > 0) {
                    self::$SalesOrderCollectionHistorymodel::create([
                        'sales_order_id' => $data->id,
                        'amount' => $requestData['paid'],
                        'creator' => auth()->user()?->id ?? null,
                    ]);
                }
                foreach ($request->product_items as $product) {
                    $createdSalesOrderProduct = self::$SalesOrderProductModel::create([
                        'sales_order_id' => $data->id,
                        'product_id' => $product['product_id'],
                        'product_name' => $product['product_name'],
                        'price' => $product['price'],
                        'quantity' => $product['quantity'],
                        'subtotal' => $product['subtotal'],
                        'creator' => auth()->user()?->id ?? null,
                        'slug' => Str::slug($product['product_name'] ?? 'product') . '-' . uniqid(),
                    ]);
                    // Attach the created product to the sales order
                    $data->sales_order_products()->attach($createdSalesOrderProduct->id, [
                        'creator' => auth()->user()?->id ?? null,
                        'status' => 'active',
                    ]);
                }

                $requestData['sales_order_id'] = $data->id;
                $requestData['sales_order_products'] = $request->product_items;
                unset($requestData['order_id']);
                self::$SalesOrderLogModel::create($requestData);
            }

            return messageResponse('Item added successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
