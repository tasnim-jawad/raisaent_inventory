<?php

namespace App\Modules\Management\Reporting\Actions;

class GetAllExpenseReport
{
    static $model = \App\Modules\Management\AccountManagement\AccountExpense\Models\Model::class;

    public static function execute()
    {
        try {

            $start_date = request()->start_date;
            $end_date = request()->end_date;

            $with = ['account_category'];
            $query = self::$model::query()->with($with);


            if ($start_date && $end_date) {
                if ($end_date > $start_date) {
                    $query->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
                } elseif ($end_date == $start_date) {
                    $query->whereDate('created_at', $start_date);
                }
            }

            $data = $query->get();
            $total = $data->sum('amount');

            $response = [
                'data' => $data,
                'total' => $total,
            ];
            return entityResponse($response);
            
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
