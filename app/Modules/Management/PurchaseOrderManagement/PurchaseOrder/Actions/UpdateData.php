<?php

namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions;

use Illuminate\Support\Str;

class UpdateData
{
    static $model = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\Model::class;
    static $PurchaseOrderProductModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderProductModel::class;
    static $PurchaseOrderLogModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderLogModel::class;

    public static function execute($request, $slug)
    {
        try {
            // dd($request->all(), $slug);
            // Find the purchase order by slug
            $data = self::$model::query()->where('slug', $slug)->first();
            if (!$data) {
                return messageResponse('Data not found...', [], 404, 'error');
            }

            // Check if there are product items
            if (!$request->product_items) {
                return messageResponse('Please add at least one product', [], 500, 'server_error');
            }

            // Prepare request data
            $requestData = $request->validated();
            $requestData['subtotal'] = $request->update_total_price['subtotal'] ?? 0;
            $requestData['discount'] = $request->update_total_price['discount'] ?? 0;
            $requestData['other_cost'] = $request->update_total_price['other_cost'] ?? 0;
            $requestData['total'] = $request->update_total_price['total'] ?? 0;
            $requestData['total_in_bdt'] = $request->update_total_price['total_in_bdt'] ?? 0;
            $requestData['due'] =  abs($requestData['due']);


            // Update the main purchase order data
            if ($data->update($requestData)) {
                // Create or update purchase order products
                self::$PurchaseOrderProductModel::query()->where('purchase_order_id', $data->id)->forceDelete();
                foreach ($request->product_items as $product) {


                    $createdPurchaseOrderProduct = self::$PurchaseOrderProductModel::create([
                        'purchase_order_id' => $data->id,
                        'product_id' => $product['product_id'],
                        'product_name' => $product['product_name'],
                        'price' => $product['price'],
                        'currency_id' => $product['currency_id'],
                        'quantity' => $product['quantity'],
                        'available_for_stock' => $product['quantity'],
                        'subtotal' => $product['subtotal'],
                        'subtotal_in_bdt' => $product['subtotal_in_bdt'],
                        'creator' => auth()->user()?->id ?? null, // Optional pivot table data
                        'slug' => Str::slug($product['product_name'] ?? 'product') . '-' . uniqid(),
                    ]);

                    // Attach the product to the purchase order if it's not already attached
                    $data->purchase_order_products()->syncWithoutDetaching([
                        $createdPurchaseOrderProduct->id => [
                            'creator' => auth()->user()?->id ?? null,
                            'status' => 'active',
                        ]
                    ]);
                }

                // Log the update action
                $requestData['purchase_order_id'] = $data->id;
                $requestData['purchase_order_products'] = $request->product_items;
                unset($requestData['due']);
                unset($requestData['paid']);
                self::$PurchaseOrderLogModel::create($requestData);
            }

            return messageResponse('Item updated successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
