<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBespockContent extends Model
{
    protected $connection = 'mysql';
    protected $table = 'home_bespock_content';
    protected $guarded = ['id'];
}
