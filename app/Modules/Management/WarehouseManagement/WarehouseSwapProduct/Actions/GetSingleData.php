<?php

namespace App\Modules\Management\WarehouseManagement\WarehouseSwapProduct\Actions;



class GetSingleData
{
    static $model = \App\Modules\Management\WarehouseManagement\WarehouseSwapProduct\Models\Model::class;

    public static function execute($slug)
    {
        try {
            $with = ['fromWarehouse', 'toWarehouse','product:id,title'];
            $fields = request()->input('fields') ?? ['*'];
            if (!$data = self::$model::query()->with($with)->select($fields)->where('slug', $slug)->first()) {
                return messageResponse('Data not found...',$data, 404, 'error');
            }
            return entityResponse($data);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}
