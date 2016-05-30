<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RRDetail extends Model
{
    use SoftDeletes;

    protected $table = 'products_rr';
    protected $fillable = [
        'product_id',
        'po_detail_id',
        'document_no',
        'quantity',
        'cost',
        'amount',
        'date_received'
    ];

    public function RR()
    {
        return $this->belongsTo('App\StocksReceiving','rr_id');
    }

    public function serials()
    {
        return $this->hasMany('App\RRSerial','rr_detail_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Products','product_id');
    }
}
