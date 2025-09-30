<?php

namespace App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class WareHouseProductStockProductModel extends EloquentModel
{
    use SoftDeletes;
    protected $table = "ware_house_product_stock_products";
    protected $guarded = [];
    protected static $WareHouseProductStockModel = \App\Modules\Management\WarehouseManagement\WareHouseProductStock\Models\Model::class;
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


    /**
     * Get the warehouse product stock that owns the WareHouseProductStockProductModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function warehouse_product_stock(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(
            self::$WareHouseProductStockModel,
            'id',
            'ware_house_product_stock_id'
        );
    }
}
