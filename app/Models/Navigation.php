<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $connection = 'mysql';
    protected $table = 'navigation';
    protected $guarded = ['id'];

}