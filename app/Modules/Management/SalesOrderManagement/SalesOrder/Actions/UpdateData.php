<?php

namespace App\Modules\Management\SalesOrderManagement\SalesOrder\Actions;

use Illuminate\Support\Str;

class UpdateData
{
    static $model = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\Model::class;
    static $SalesOrderProductModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderProductModel::class;
    static $SalesOrderLogModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderLogModel::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;

    public static function execute($request, $slug)
    {
        try {
            if (!$data = self::$model::query()->where('slug', $slug)->first()) {
                return messageResponse('Data not found...', $data, 404, 'error');
            }
            $data = self::$model::query()->where('slug', $slug)->first();
            if (!$data) {
                return messageResponse('Data not found...', [], 404, 'error');
            }

            // Check if there are product items
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

            // Prepare request data
            $requestData = $request->validated();
            $requestData['order_status'] = $request->due == 0  ? 'paid' : 'due';
            if ($data->update($requestData)) {
                // Create or update purchase order products
                self::$SalesOrderProductModel::query()->where('sales_order_id', $data->id)->forceDelete();
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
               
                self::$SalesOrderLogModel::create($requestData);
            }
            return messageResponse('Item updated successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
