<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StocksReceiving extends Model
{
    use SoftDeletes;
    protected $table = 'rr';
    protected $fillable = [
        'date',
        'remarks',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Products','products_rr','rr_id','product_id')
            ->withPivot('quantity','cost','amount','id')
            ->withTimestamps()
            ->whereNull('products_rr.deleted_at');

    }

    public function details()
    {
        return $this->hasMany('App\RRDetail','rr_id');
    }

}
