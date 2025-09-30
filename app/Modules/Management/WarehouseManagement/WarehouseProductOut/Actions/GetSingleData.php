<?php

namespace App\Modules\Management\WarehouseManagement\WarehouseProductOut\Actions;



class GetSingleData
{
    static $model = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\Model::class;

    public static function execute($slug)
    {
        try {
            $with = ['sales_order:id,title,reference', 'warehouse:id,name','ware_house_product_out_products'];
            $fields = request()->input('fields') ?? ['*'];
            if (!$data = self::$model::query()->with($with)->select($fields)->where('slug', $slug)->withCount('ware_house_product_out_products')->first()) {
                return messageResponse('Data not found...',$data, 404, 'error');
            }
            return entityResponse($data);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(),[], 500, 'server_error');
        }
    }
}
