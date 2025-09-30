<?php

namespace App\Modules\Management\SalesOrderManagement\SalesOrder\Actions;



class GetSingleData
{
    static $model = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\Model::class;
    static $WareHouseProductStockModel =
    \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;
    public static function execute($slug)
    {
        try {
            $with = ['sales_order_products', 'sales_order_logs', 'customer:id,name', 'sales_collection_histories'];
            $fields = request()->input('fields') ?? ['*'];
            if (!$data = self::$model::query()->with($with)->select($fields)->where('slug', $slug)->orWhere('id', $slug)->first()) {

                return messageResponse('Data not found...', $data, 404, 'error');
            }
            $sales_order_products =  $data->sales_order_products;
            foreach ($sales_order_products as $sales_order_product) {
                $WareHouseProductStockProductsQuantity = self::$WareHouseProductStockModel::where('product_id', $sales_order_product['product_id'])->sum('quantity');
                $sales_order_product->available_quantity = (int) $WareHouseProductStockProductsQuantity;
            }
            // dd($data);
            return entityResponse($data);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
