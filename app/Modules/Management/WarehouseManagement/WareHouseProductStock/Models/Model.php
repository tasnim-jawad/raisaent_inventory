<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use SoftDeletes;
    protected $table = "ware_house_product_stocks";
    protected $guarded = [];

    protected static $WareHouseProductStockProductModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\WareHouseProductStockProductModel::class;

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

     public function warehouse()
    {
        return $this->belongsTo(\App\Modules\Management\WarehouseManagement\WareHouse\Models\Model::class, 'warehouse_id');
    }

    public function purcahase_order(){
        return $this->belongsTo(\App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\Model::class, 'purchase_order_id');
    }

    public function ware_house_product_stock_products()
    {
        return $this->hasMany(self::$WareHouseProductStockProductModel, 'ware_house_product_stock_id');
    }
}
