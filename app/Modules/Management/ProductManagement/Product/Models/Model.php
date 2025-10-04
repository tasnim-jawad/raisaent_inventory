<?php

namespace App\Modules\Management\ProductManagement\Product\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Model extends EloquentModel
{
    use SoftDeletes;
    protected $table = "products";
    protected $guarded = [];

    protected $appends = ['total_stock_quantity', 'warehouse_stock_details'];

    protected static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;
    protected static $WarehouseProductOutProductModel = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\WarehouseProductOutProductModel::class;
    protected static $WareHouseModel = \App\Modules\Management\WarehouseManagement\WareHouse\Models\Model::class;
    protected static $WareHouseProductStockModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;
    protected static $WarehouseProductOutModel = \App\Modules\Management\WarehouseManagement\WarehouseProductOut\Models\Model::class;

    protected static function booted()
    {
        static::created(function ($data) {
            $random_no = random_int(100, 999) . $data->id . random_int(100, 999);
            $slug = $data->title . " " . $random_no;
            $data->slug = Str::slug($slug); //use Illuminate\Support\Str;
            if (strlen($data->slug) > 50) {
                $data->slug = substr($data->slug, strlen($data->slug) - 50, strlen($data->slug));
            }
            if (auth()->check()) {
                $data->creator = auth()->user()->id;
            }
            $data->save();
        });
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }

    public function scopeInactive($q)
    {
        return $q->where('status', 'inactive');
    }
    public function scopeTrased($q)
    {
        return $q->onlyTrashed();
    }

    public function product_category()
    {
        return $this->belongsTo('App\Modules\Management\ProductManagement\ProductCategory\Models\Model', 'product_category_id');
    }
    public function product_sub_category()
    {
        return $this->belongsTo('App\Modules\Management\ProductManagement\ProductSubCategory\Models\Model', 'product_sub_category_id');
    }
    public function suppliyer()
    {
        return $this->belongsTo('App\Modules\Management\SuppliyerManagement\Suppliyer\Models\Model', 'suppliyer_id');
    }

    public function getTotalStockQuantityAttribute()
    {
        $warehouseStockData = $this->getWarehouseStockData();
        return $warehouseStockData['total_stock'] ?? 0;
    }

    public function getWarehouseStockDetailsAttribute()
    {
        return $this->getWarehouseStockData();
    }

    public function getWarehouseStockData()
    {
        // Get all warehouses
        $warehouses = self::$WareHouseModel::active()->get(['id', 'name']);
        
        // Get stock in data for this product grouped by warehouse
        $stockInData = DB::table('ware_house_product_stock_products as whpsp')
            ->join('ware_house_product_stocks as whps', 'whpsp.ware_house_product_stock_id', '=', 'whps.id')
            ->where('whpsp.product_id', $this->id)
            ->where('whpsp.status', 'active')
            ->where('whps.status', 'active')
            ->groupBy('whps.warehouse_id')
            ->select('whps.warehouse_id', DB::raw('SUM(whpsp.quantity) as total_in'))
            ->pluck('total_in', 'warehouse_id');

        // Get stock out data for this product grouped by warehouse
        $stockOutData = DB::table('warehouse_product_out_products as wpop')
            ->join('warehouse_product_outs as wpo', 'wpop.ware_house_product_out_id', '=', 'wpo.id')
            ->where('wpop.product_id', $this->id)
            ->where('wpop.status', 'active')
            ->where('wpo.status', 'active')
            ->groupBy('wpo.warehouse_id')
            ->select('wpo.warehouse_id', DB::raw('SUM(wpop.quantity) as total_out'))
            ->pluck('total_out', 'warehouse_id');
        
        $warehouseStockDetails = [];
        $totalStock = 0;
        
        foreach ($warehouses as $warehouse) {
            $stockIn = $stockInData->get($warehouse->id, 0);
            $stockOut = $stockOutData->get($warehouse->id, 0);
            $remainingStock = $stockIn - $stockOut;
            $totalStock += $remainingStock;
            
            $warehouseStockDetails[] = [
                'warehouse_id' => $warehouse->id,
                'warehouse_name' => $warehouse->name,
                'stock_in' => $stockIn,
                'stock_out' => $stockOut,
                'remaining_stock' => max(0, $remainingStock) // Ensure no negative stock
            ];
        }
        
        return [
            'total_stock' => max(0, $totalStock),
            'warehouse_details' => $warehouseStockDetails
        ];
    }

    /**
     * Static method to get warehouse stock data for multiple products efficiently
     */
    public static function getWarehouseStockDataForProducts($productIds)
    {
        // Get all warehouses
        $warehouses = self::$WareHouseModel::active()->get(['id', 'name'])->keyBy('id');
        
        // Get stock in data for all products grouped by product and warehouse
        $stockInData = DB::table('ware_house_product_stock_products as whpsp')
            ->join('ware_house_product_stocks as whps', 'whpsp.ware_house_product_stock_id', '=', 'whps.id')
            ->whereIn('whpsp.product_id', $productIds)
            ->where('whpsp.status', 'active')
            ->where('whps.status', 'active')
            ->groupBy('whpsp.product_id', 'whps.warehouse_id')
            ->select('whpsp.product_id', 'whps.warehouse_id', DB::raw('SUM(whpsp.quantity) as total_in'))
            ->get()
            ->groupBy('product_id');

        // Get stock out data for all products grouped by product and warehouse
        $stockOutData = DB::table('warehouse_product_out_products as wpop')
            ->join('warehouse_product_outs as wpo', 'wpop.ware_house_product_out_id', '=', 'wpo.id')
            ->whereIn('wpop.product_id', $productIds)
            ->where('wpop.status', 'active')
            ->where('wpo.status', 'active')
            ->groupBy('wpop.product_id', 'wpo.warehouse_id')
            ->select('wpop.product_id', 'wpo.warehouse_id', DB::raw('SUM(wpop.quantity) as total_out'))
            ->get()
            ->groupBy('product_id');
        
        $result = [];
        
        foreach ($productIds as $productId) {
            $productStockIn = $stockInData->get($productId, collect())->keyBy('warehouse_id');
            $productStockOut = $stockOutData->get($productId, collect())->keyBy('warehouse_id');
            
            $warehouseStockDetails = [];
            $totalStock = 0;
            
            foreach ($warehouses as $warehouse) {
                $stockIn = $productStockIn->get($warehouse->id)->total_in ?? 0;
                $stockOut = $productStockOut->get($warehouse->id)->total_out ?? 0;
                $remainingStock = $stockIn - $stockOut;
                $totalStock += $remainingStock;
                
                $warehouseStockDetails[] = [
                    'warehouse_id' => $warehouse->id,
                    'warehouse_name' => $warehouse->name,
                    'stock_in' => $stockIn,
                    'stock_out' => $stockOut,
                    'remaining_stock' => max(0, $remainingStock)
                ];
            }
            
            $result[$productId] = [
                'total_stock' => max(0, $totalStock),
                'warehouse_details' => $warehouseStockDetails
            ];
        }
        
        return $result;
    }
}
