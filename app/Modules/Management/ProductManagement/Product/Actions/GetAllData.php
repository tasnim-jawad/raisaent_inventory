<?php

namespace App\Modules\Management\ProductManagement\Product\Actions;

class GetAllData
{
    static $model = \App\Modules\Management\ProductManagement\Product\Models\Model::class;

    public static function execute()
    {
        try {



            $pageLimit = request()->input('limit') ?? 500;
            $orderByColumn = request()->input('sort_by_col') ?? 'id';
            $orderByType = request()->input('sort_type') ?? 'desc';
            $status = request()->input('status') ?? 'active';
            $fields = request()->input('fields') ?? '*';
            $start_date = request()->input('start_date');
            $end_date = request()->input('end_date');
            $with = ['product_category:id,title', 'product_sub_category:id,title', 'suppliyer:id,name'];
            $condition = [];

            $data = self::$model::query();

            if (request()->has('search') && request()->input('search')) {
                $searchKey = request()->input('search');
                $data = $data->where(function ($q) use ($searchKey) {
                    $q->where('title', 'like', '%' . $searchKey . '%');
                    $q->orWhere('title', 'like', '%' . $searchKey . '%');
                    $q->orWhere('description', 'like', '%' . $searchKey . '%');
                });
            }

            if ($start_date && $end_date) {
                // dd(request()->input('product_category_id'));
                if ($end_date > $start_date) {
                    $data->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
                } elseif ($end_date == $start_date) {
                    $data->whereDate('created_at', $start_date);
                }

                if (request()->input('product_category_id')) {
                    $data->where('product_category_id', request()->input('product_category_id'));
                }
                if (request()->input('product_sub_category_id')) {
                    $data->where('product_sub_category_id', request()->input('product_sub_category_id'));
                }
                if (request()->input('suppliyer_id')) {
                    $data->where('suppliyer_id', request()->input('suppliyer_id'));
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
                    ->where('status', $status)
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
