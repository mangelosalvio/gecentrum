<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouses extends Model
{
    use SoftDeletes;
    protected $fillable = [
      'warehouse_code',
      'warehouse_name',
      'is_main_warehouse'
    ];

    public function scopeMainWarehouse($query)
    {
        return $query->whereIsMainWarehouse(1);
    }
}
