<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesReturn extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'date',
        'remarks'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Products','sales_return_details','sales_return_id','product_id')
            ->withPivot('quantity','price','amount','id')
            ->withTimestamps()
            ->whereNull('sales_return_details.deleted_at');
    }

    public function details()
    {
        return $this->hasMany('App\SalesReturnDetail');
    }
}
