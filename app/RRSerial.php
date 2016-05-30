<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class RRSerial extends Model
{
    use SoftDeletes;
    protected $table = 'rr_serial';
    protected $fillable = [
      'serial_no',
    ];
    protected $appends = [
      'sales'
    ];

    public function detail()
    {
        return $this->belongsTo('App\RRDetail','rr_detail_id');
    }

    public function getSalesAttribute()
    {
        $serial_no = $this->attributes['serial_no'];
        $DR = DeliveryReceipt::whereHas('details', function($query) use ($serial_no){
            $query->whereSerialNo($serial_no);
        })->first();


        return $DR;
    }
}
