<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    use SoftDeletes;
    protected $fillable = [
      'supplier_code',
      'supplier_name',
      'address',
      'contact_person',
      'email_address',
      'contact_no'
    ];
}
