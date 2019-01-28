<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class OrderRepo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'OrderRepo';
    }
}
