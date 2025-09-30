<?php

namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions;

use Illuminate\Support\Str;

class StoreData
{
    static $model = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\Model::class;
    static $PurchaseOrderProductModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderProductModel::class;
    static $PurchaseOrderLogModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderLogModel::class;
    static $PurchaseOrderCollectionModel =
    \App\Modules\Management\PurchaseOrderManagement\PurchaseOrderCollection\Models\Model::class;
    public static function execute($request)
    {
        try {


            if (!$request->product_items) {
                return messageResponse('Please add at least one product', [], 500, 'server_error');
            }
            $requestData = $request->validated();
            $requestData['subtotal'] = $request->update_total_price['subtotal'] ?? 0;
            $requestData['discount'] = $request->update_total_price['discount'] ?? 0;;
            $requestData['other_cost'] = $request->update_total_price['other_cost'] ?? 0;;
            $requestData['total'] = $request->update_total_price['total'] ?? 0;
            $requestData['total_in_bdt'] = $request->update_total_price['total_in_bdt'] ?? 0;
            $requestData['order_id'] = "PO-" . uniqid();
            $requestData['order_status'] = $request->due == 0  ? 'paid' : 'due';
            $requestData['paid'] = $request->paid ?? 0;
            $requestData['due'] = $request->due ?? 0;

            if ($data = self::$model::query()->create($requestData)) {
                if ($requestData['paid'] > 0) {
                    self::$PurchaseOrderCollectionModel::create([
                        'purchase_order_id' => $data->id,
                        'amount' => $requestData['paid'],
                        'creator' => auth()->user()?->id ?? null,
                    ]);
                }
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
                    // Attach the created product to the purchase order
                    $data->purchase_order_products()->attach($createdPurchaseOrderProduct->id, [
                        'creator' => auth()->user()?->id ?? null, // Optional pivot table data
                        'status' => 'active', // Optional pivot table data
                    ]);
                }

                $requestData['purchase_order_id'] = $data->id;
                $requestData['purchase_order_products'] = $request->product_items;
                unset($requestData['order_id']);
                unset($requestData['due']);
                unset($requestData['paid']);
                unset($requestData['order_status']);
                self::$PurchaseOrderLogModel::create($requestData);
            }

            return messageResponse('Item added successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
