<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PODetails extends Model
{
    use SoftDeletes;
    protected $table = 'po_products';


    public function PO()
    {
        return $this->belongsTo('App\PO','po_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Products','product_id');
    }
}
