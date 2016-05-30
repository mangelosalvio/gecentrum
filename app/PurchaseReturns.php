<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReturns extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'date',
        'supplier_id',
        'remarks',
        'status',
        'warehouse_id',
        'invoice_no'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Products','purchase_return_details','purchase_return_id','product_id')
            ->withPivot('quantity','cost','amount','id')
            ->withTimestamps()
            ->whereNull('purchase_return_details.deleted_at');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Suppliers');
    }

    public function details()
    {
        return $this->hasMany('App\PurchaseReturnDetails','purchase_return_id');
    }

    public function warehouse(){
        return $this->belongsTo('App\Warehouses');
    }
}
