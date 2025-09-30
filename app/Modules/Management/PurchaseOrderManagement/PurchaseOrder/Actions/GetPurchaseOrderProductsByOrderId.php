<?php

namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions;

class GetPurchaseOrderProductsByOrderId
{
    static $model = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderProductModel::class;

    public static function execute($purchase_order_id)
    {
        try {



            $data = self::$model::query()->where('purchase_order_id', $purchase_order_id)->get();
            if (!$data) {
                return messageResponse('Data not found...', [], 404, 'error');
            }
            return entityResponse($data);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
