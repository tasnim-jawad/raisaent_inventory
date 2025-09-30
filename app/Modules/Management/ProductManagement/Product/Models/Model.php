<?php

namespace App\Modules\Management\ProductManagement\Product\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use SoftDeletes;
    protected $table = "products";
    protected $guarded = [];

    protected $appends = ['total_stock_quantity'];

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
        $quantity = self::$WareHouseProductStockProductModel::where('product_id', $this->id)->sum('quantity');
        return $quantity;
    }
}
