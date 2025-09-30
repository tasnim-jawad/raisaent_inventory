<?php

namespace App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use SoftDeletes;
    protected $table = "purchase_orders";
    protected $guarded = [];

    protected static $PurchaseOrderProductModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderProductModel::class;
    protected static $PurchaseOrderLogModel = \App\Modules\Management\PurchaseOrderManagement\PurchaseOrder\Models\PurchaseOrderLogModel::class;

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

    public function purchase_order_products()
    {
        return $this->belongsToMany(
            self::$PurchaseOrderProductModel,
            'purchase_order_has_purchase_order_products',
            'purchase_order_id',
            'purchase_order_products_id'
        );
    }

    public function purchase_order_logs()
    {
        return $this->hasMany(self::$PurchaseOrderLogModel, 'purchase_order_id');
    }

    public function suppliyer()
    {
        return $this->belongsTo(\App\Modules\Management\SuppliyerManagement\Suppliyer\Models\Model::class, 'suppliyer_id');
    }

    public function purchase_order_providing_history()
    {
        return $this->hasMany(\App\Modules\Management\PurchaseOrderManagement\PurchaseOrderCollection\Models\Model::class, 'purchase_order_id');
    }
}
