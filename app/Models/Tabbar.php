<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabbar extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tabbar';
    protected $guarded = ['id'];
}
