<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadPicture extends Model
{
    protected $connection = 'mysql';
    protected $table = 'head_picture';
    protected $guarded = ['id'];
}
