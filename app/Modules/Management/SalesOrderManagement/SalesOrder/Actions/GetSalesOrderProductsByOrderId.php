<?php

namespace App\Modules\Management\SalesOrderManagement\SalesOrder\Actions;

class GetSalesOrderProductsByOrderId
{
    static $model = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderProductModel::class;

    public static function execute($sales_order_id)
    {
        try {

            $data = self::$model::query()->where('sales_order_id', $sales_order_id)->get();
            if (!$data) {
                return messageResponse('Data not found...', [], 404, 'error');
            }
            return entityResponse($data);
            
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
