<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advises extends Model
{
    protected $connection = 'mysql';
    protected $table = 'advises';
    protected $guarded = ['id'];
}
