<?php

namespace App\Modules\Management\SalesOrderManagement\SalesOrderCollectionHistory\Actions;

class StoreData
{
    static $model = \App\Modules\Management\SalesOrderManagement\SalesOrderCollectionHistory\Models\Model::class;
    static $SalesOrderModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\Model::class;

    public static function execute($request)
    {
        try {
            $requestData = $request->validated();
            $salesOrder = self::$SalesOrderModel::findOrFail($requestData['sales_order_id']);
            if ($salesOrder->due < $requestData['amount']) {
                return messageResponse('Amount is greater than due amount', [], 400, 'error');
            }
            $data = self::$model::create($requestData);
            $salesOrder->paid += $requestData['amount'];
            $salesOrder->due = $salesOrder->total - $salesOrder->paid;
            if ($salesOrder->paid >= $salesOrder->total) {
                $salesOrder->order_status = 'paid';
            }
            $salesOrder->save();
            return messageResponse('Item added successfully', $data, 201);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
