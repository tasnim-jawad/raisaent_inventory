<?php

namespace App\Modules\Management\SalesOrderManagement\SalesOrder\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use SoftDeletes;
    protected $table = "sales_orders";
    protected $guarded = [];

    protected static $SalesOrderProductModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderProductModel::class;
    protected static $SalesOrderLogModel = \App\Modules\Management\SalesOrderManagement\SalesOrder\Models\SalesOrderLogModel::class;

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

    public function sales_order_products()
    {
        return $this->belongsToMany(
            self::$SalesOrderProductModel,
            'sales_order_has_sales_order_products',
            'sales_order_id',
            'sales_order_product_id'
        );
    }

    public function sales_order_logs()
    {
        return $this->hasMany(self::$SalesOrderLogModel, 'sales_order_id');
    }

    public function customer()
    {
        return $this->belongsTo(\App\Modules\Management\CustomerManagement\Customer\Models\Model::class, 'customer_id');
    }

    public function sales_collection_histories()
    {
        return $this->hasMany(\App\Modules\Management\SalesOrderManagement\SalesOrderCollectionHistory\Models\Model::class, 'sales_order_id');
    }
}
