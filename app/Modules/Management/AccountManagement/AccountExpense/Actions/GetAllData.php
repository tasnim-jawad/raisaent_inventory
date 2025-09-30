<?php

namespace App\Modules\Management\AccountManagement\AccountExpense\Actions;

class GetAllData
{
    static $model = \App\Modules\Management\AccountManagement\AccountExpense\Models\Model::class;

    public static function execute()
    {
        try {




            $pageLimit = request()->input('limit') ?? 10;
            $orderByColumn = request()->input('sort_by_col') ?? 'id';
            $orderByType = request()->input('sort_type') ?? 'desc';
            $status = request()->input('status') ?? 'active';
            $fields = request()->input('fields') ?? '*';
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');
            $with = ['account_category', 'user:id,name', 'customer:id,name'];
            $condition = [];

            $data = self::$model::query();

            if (request()->has('status') && request()->input('status')) {
                if (request()->input('status') == 'pending_voucher') {
                    $data = $data->where('is_approved', 0);
                }
            }


            if (request()->has('is_seen')) {
                $condition['is_seen'] = request()->input('is_seen');
            }

            if (request()->has('only_employee_data') && request()->input('only_employee_data')) {
                $condition['creator'] = auth()->id();
            }

            if (request()->has('search') && request()->input('search')) {
                $searchKey = request()->input('search');
                $data = $data->where(function ($q) use ($searchKey) {
                    $q->where('account_category_id', 'like', '%' . $searchKey . '%');

                    $q->orWhere('title', 'like', '%' . $searchKey . '%');

                    $q->orWhere('amount', 'like', '%' . $searchKey . '%');

                    $q->orWhere('description', 'like', '%' . $searchKey . '%');

                    $q->orWhere('is_approved', 'like', '%' . $searchKey . '%');

                    $q->orWhere('user_type', 'like', '%' . $searchKey . '%');
                });
            }

            if ($start_date && $end_date) {
                if ($end_date > $start_date) {
                    $data->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
                } elseif ($end_date == $start_date) {
                    $data->whereDate('created_at', $start_date);
                }

                if (request()->has('employee_id') && request()->input('employee_id')) {
                    $condition['creator'] = request()->input('employee_id');
                }
            }

            if ($status == 'trased') {
                $data = $data->trased();
            }

            if (request()->has('get_all') && (int)request()->input('get_all') === 1) {
                $data = $data
                    ->with($with)
                    ->select($fields)
                    ->where($condition)
                    ->where('status', $status)
                    ->limit($pageLimit)
                    ->orderBy($orderByColumn, $orderByType)
                    ->get();

                return entityResponse($data);
            } else if ($status == 'trased') {
                $data = $data
                    ->with($with)
                    ->select($fields)
                    ->where($condition)
                    ->orderBy($orderByColumn, $orderByType)
                    ->paginate($pageLimit);
            } else {

                $data = $data
                    ->with($with)
                    ->select($fields)
                    ->where($condition)
                    ->orderBy($orderByColumn, $orderByType)
                    ->paginate($pageLimit);
            }



            return entityResponse([
                ...$data->toArray(),
                "active_data_count" => self::$model::active()->count(),
                "inactive_data_count" => self::$model::inactive()->count(),
                "trased_data_count" => self::$model::trased()->count(),
            ]);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
