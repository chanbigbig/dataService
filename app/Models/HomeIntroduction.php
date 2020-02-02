<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeIntroduction extends Model
{
    protected $connection = 'mysql';
    protected $table = 'home_introduction';
    protected $guarded = ['id'];

}
