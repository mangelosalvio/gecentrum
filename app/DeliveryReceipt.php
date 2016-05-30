<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryReceipt extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'customer_id',
        'date',
        'salesman',
        'remarks'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customers');
    }

    public function products()
    {
        return $this->belongsToMany('App\Products','delivery_receipt_details','delivery_receipt_id','product_id')
            ->withPivot('quantity','price','amount','serial_no')
            ->withTimestamps()
            ->whereNull('delivery_receipt_details.deleted_at');
    }

    public function details()
    {
        return $this->hasMany('App\DeliveryReceiptDetail');
    }
}
