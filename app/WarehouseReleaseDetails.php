<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WarehouseReleaseDetails extends Model
{
    use SoftDeletes;

    public function WarehouseRelease()
    {
        return $this->belongsTo('App\WarehouseReleases','warehouse_release_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Products','product_id');
    }
}
