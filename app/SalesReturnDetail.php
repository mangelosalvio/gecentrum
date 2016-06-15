<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesReturnDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'delivery_receipt_detail_id',
        'product_id',
        'quantity',
        'price',
        'amount',
        'serial_no'
    ];

    public function SalesReturn()
    {
        return $this->belongsTo('App\SalesReturn');
    }

    public function DeliveryReceiptDetail()
    {
        return $this->belongsTo('App\DeliveryReceiptDetail');
    }

    public function product()
    {
        return $this->belongsTo('App\Products');
    }

}
