<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $connection = 'mysql';
    protected $table = 'course';
    protected $guarded = ['id'];
}
