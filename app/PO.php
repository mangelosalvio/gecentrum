<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PO extends Model
{
    use SoftDeletes;

    public $table = 'po';

    protected $fillable = [
        'date',
        'supplier_id',
        'remarks',
        'status'
    ];

    protected $appends = [
      'po_status'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Products','po_products','po_id','product_id')
            ->withPivot('quantity','cost','amount','id')
            ->withTimestamps()
            ->whereNull('po_products.deleted_at');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Suppliers');
    }

    public function details()
    {
        return $this->hasMany('App\PODetails','po_id');
    }

    public function getPoStatusAttribute(){

        /**
         * return pending for the moment
         */
        return "Pending";

        if ( $this->status == 'X' ) {
            return "Closed";
        }

        if ( StocksReceiving::wherePoId($this->id)->count() <= 0 ) {
            return "Pending";
        }

        /**
         * Check if completed
         */
        $Details = $this->details;
        if ( count( $Details ) > 0 ) {
            foreach ($Details as $Detail) {
                if ( $Detail['quantity'] > $this->receivedQty($this->id, $Detail['product_id']) ) {
                    return "Partial";
                };
            }
        }

        return "Completed";
    }

    public function receivedQty($po_id, $product_id)
    {
        return DB::table('rr')
            ->join('products_rr', 'rr.id', '=', 'products_rr.rr_id')
            ->wherePoId($po_id)
            ->whereProductId($product_id)
            ->whereNull('products_rr.deleted_at')
            ->sum('quantity');

    }
}
