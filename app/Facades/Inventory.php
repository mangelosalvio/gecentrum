<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Inventory extends Facade
{
    protected static function getFacadeAccessor(){ return 'Inventory'; }
}