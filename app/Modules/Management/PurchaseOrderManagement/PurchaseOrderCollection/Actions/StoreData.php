<?php

namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrderCollection\Actions;

class StoreData
{
    static $model = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrderCollection\Models\Model::class;
    static $PurchaseOrderModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();
            $PurchaseOrder = self::$PurchaseOrderModel::findOrFail($requestData['purchase_order_id']);
            if ($PurchaseOrder->due < $requestData['amount']) {
                return messageResponse('Amount is greater than due amount', [], 400, 'error');
            }
            if (self::$model::create($requestData)) {
                $PurchaseOrder->paid += $requestData['amount'];
                $PurchaseOrder->due = $PurchaseOrder->total - $PurchaseOrder->paid;
                if ($PurchaseOrder->paid >= $PurchaseOrder->total) {
                    $PurchaseOrder->order_status = 'paid';
                }
                $PurchaseOrder->save();
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
