<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryReceiptDetail extends Model
{
    protected $fillable = [
      'delivery_receipt_id',
      'product_id',
      'quantity',
      'price',
      'amount',
      'serial_no'
    ];

    public function DeliveryReceipt()
    {
        return $this->belongsTo('App\DeliveryReceipt');
    }

    public function product()
    {
        return $this->belongsTo('App\Products');
    }

    public function SalesReturnDetail()
    {
        return $this->hasMany('App\SalesReturnDetail');
    }
}
