<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'product_code',
      'product_name',
      'category_id',
      'unit',
      'reorder_level',
      'has_serial_no'
    ];

    public function category()
    {
        return $this->belongsTo('App\Categories');
    }

    public function receiving()
    {
        return $this->belongsToMany('App\StocksReceiving', 'products_rr','product_id','rr_id')
            ->withPivot('quantity','cost','amount')
            ->withTimestamps();
    }


}
