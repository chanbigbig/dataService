<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NavigationChild extends Model
{
    protected $connection = 'mysql';
    protected $table = 'navigation_child';
    protected $guarded = ['id'];

}