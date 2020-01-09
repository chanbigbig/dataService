<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHistory extends Model
{
    protected $connection = 'mysql';
    protected $table = 'home_history';
    protected $guarded = ['id'];
}
