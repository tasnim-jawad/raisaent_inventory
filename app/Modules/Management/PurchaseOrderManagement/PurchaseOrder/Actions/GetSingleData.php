<?php

namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions;



class GetSingleData
{
    static $model = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\Model::class;

    public static function execute($slug)
    {
        try {
            $with = ['purchase_order_products', 'purchase_order_logs', 'suppliyer:id,name', 'purchase_order_providing_history'];
            $fields = request()->input('fields') ?? ['*'];
            if (!$data = self::$model::query()->with($with)->select($fields)->where('slug', $slug)->orWhere('id', $slug)->first()) {
                return messageResponse('Data not found...', $data, 404, 'error');
            }
            return entityResponse($data);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
