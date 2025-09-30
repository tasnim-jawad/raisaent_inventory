<?php

namespace App\Modules\Management\WarehouseManagement\WareHouse\Actions;

class GetWarehouseWiseProductLists
{
    static $model = \App\Modules\Management\WarehouseManagement\WareHouse\Models\Model::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;
    static $ProductModel = \App\Modules\Management\ProductManagement\Product\Models\Model::class;

    public static function execute($slug)
    {
        try {


            $data = self::$model::with([
                'warehouse_stock_product.ware_house_product_stock_products' => function ($query) {
                    $query->select('id', 'product_id', 'ware_house_product_stock_id');
                }
            ])->where('slug', $slug)
                ->first();

          

            $product_ids = $data->warehouse_stock_product?->ware_house_product_stock_products?->pluck('product_id')->unique();

            if (!$product_ids) {
                return messageResponse('Product not found', [], 404, 'not_found');
            }

            $products = self::$ProductModel::whereIn('id', $product_ids)->get();




            return entityResponse($products);
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}
