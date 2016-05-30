<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhysicalCounts extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'date',
        'remarks',
        'status',
        'warehouse_id'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Products','physical_count_details','physical_count_id','product_id')
            ->withPivot('quantity','id')
            ->withTimestamps();
    }

    public function details()
    {
        return $this->hasMany('App\PhysicalCountDetails','physical_count_id');
    }

    public function warehouse(){
        return $this->belongsTo('App\Warehouses');
    }
}
