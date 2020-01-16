<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $connection = 'mysql';
    protected $table = 'navigation';
    protected $guarded = ['id'];

    /**
     * 获取关联的课件记录详情
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child()
    {
        return $this->hasMany('App\Models\NavigationChild', 'navigation_id', 'id');
    }

}