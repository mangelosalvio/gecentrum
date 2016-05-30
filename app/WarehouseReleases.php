<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseReleases extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'date',
        'customer_id',
        'remarks',
        'status',
        'from_warehouse_id',
        'to_warehouse_id',
        'released_by'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Products','warehouse_release_details','warehouse_release_id','product_id')
            ->withPivot('quantity','id')
            ->withTimestamps()
            ->whereNull('warehouse_release_details.deleted_at');
    }

    public function details()
    {
        return $this->hasMany('App\WarehouseReleaseDetails','warehouse_release_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customers','customer_id');
    }

    public function fromWarehouse()
    {
        return $this->belongsTo('App\Warehouses','from_warehouse_id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo('App\Warehouses','to_warehouse_id');
    }

}
