<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FootPicture extends Model
{
    protected $connection = 'mysql';
    protected $table = 'foot_picture';
    protected $guarded = ['id'];
}
