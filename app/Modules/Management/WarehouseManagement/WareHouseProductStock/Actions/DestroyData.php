<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Actions;

class DestroyData
{
    static $model = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;
    static $PurchaseOrderProductModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderProductModel::class;
    static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;

    public static function execute($slug)
    {
        try {

            if (!$data = self::$model::where('slug', $slug)->first()) {
                return messageResponse('Data not found...', $data, 404, 'error');
            }

            
            $WareHouseProductStockProducts = self::$WareHouseProductStockProductModel::where('ware_house_product_stock_id', $data->id)->get();
            foreach($WareHouseProductStockProducts as $item){
                self::$PurchaseOrderProductModel::where([
                    'purchase_order_id' => $data->purchase_order_id,
                    'product_id' => $item->product_id,
                ])->increment('available_for_stock', $item->quantity);

                $item->forceDelete();
            }
            $data->forceDelete();
            return messageResponse('Item Successfully deleted', [], 200, 'success');
        } catch (\Exception $e) {
            return messageResponse($e->getMessage(), [], 500, 'server_error');
        }
    }
}