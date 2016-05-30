<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhysicalCountDetails extends Model
{
    use SoftDeletes;
    protected $table = 'physical_count_details';

    public function PhysicalCounts()
    {
        return $this->belongsTo('App\PhysicalCounts','physical_count_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Products','product_id');
    }
}
