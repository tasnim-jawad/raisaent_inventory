<?php

namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Actions;



class LogSearch
{
    static $model = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\Model::class;
    static $PurchaseOrderLogModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderLogModel::class;
    public static function execute()
    {
        try {

            $with = ['purchase_order_products', 'purchase_order_logs'];
            $fields = request()->input('fields') ?? ['*'];
            $purcahseOrderId = self::$model::with($with)->select($fields)->first()->id;
            if (!$purcahseOrderId) {
                return messageResponse('Data not found...', $purcahseOrderId, 404, 'error');
            }

            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');
            if ($start_date && $end_date) {
                $data = self::$PurchaseOrderLogModel::query()->where('purchase_order_id', $purcahseOrderId);

                if ($end_date > $start_date) {
                    $data->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
                } elseif ($end_date == $start_date) {
                    $data->whereDate('created_at', $start_date);
                }

                $data = $data->get();

                return entityResponse($data);
            } else {
                return messageResponse('Start date and end date is required ', [], 404, 'error');
            }
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
