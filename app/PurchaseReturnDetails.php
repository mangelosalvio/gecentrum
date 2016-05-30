<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReturnDetails extends Model
{
    use SoftDeletes;
    protected $table = 'purchase_return_details';

    public function PurchaseReturn()
    {
        return $this->belongsTo('App\PurchaseReturns','purchase_return_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Products','product_id');
    }
}
