<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class Navigation extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'navigation';
    protected $guarded = ['id'];

    /**
     * @return $this
     */
    public function child()
    {
        return $this->hasMany('App\Models\NavigationChild', 'navigation_id', 'id')
            ->select('navigation_id', 'child_id', 'title');
    }

    /**
     * @return $this
     */
    public function headPic()
    {
        return $this->hasMany('App\Models\HeadPicture', 'navigation_id', 'id')
            ->select('navigation_id', 'img_url');
    }


}