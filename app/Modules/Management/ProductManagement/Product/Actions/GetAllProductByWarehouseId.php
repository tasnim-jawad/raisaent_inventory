<?php

namespace App\Modules\Management\ProductManagement\Product\Actions;

use Illuminate\Support\Facades\DB;

class GetAllProductByWarehouseId
{
    static $model = \App\Modules\Management\ProductManagement\Product\Models\Model::class;

    public static function execute()
    {
        try {

            // dd(request()->input('warehouse_id'));


            $data = DB::table('products')
                ->select('products.*')
                ->join('ware_house_product_stock_products', 'ware_house_product_stock_products.product_id', '=', 'products.id')
                ->join('ware_house_product_stocks', 'ware_house_product_stocks.id', '=', 'ware_house_product_stock_products.ware_house_product_stock_id')
                ->where('ware_house_product_stocks.warehouse_id', request()->warehouse_id)
                ->get();




            return entityResponse($data);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
