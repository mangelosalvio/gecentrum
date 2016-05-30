<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use SoftDeletes;
    protected $fillable = [
      'customer_code',
      'customer_name',
      'address',
      'contact_person',
      'email_address',
      'contact_no'
    ];
}
