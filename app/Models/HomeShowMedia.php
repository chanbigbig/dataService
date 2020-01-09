<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeShowMedia extends Model
{
    protected $connection = 'mysql';
    protected $table = 'home_show_media';
    protected $guarded = ['id'];
}
