<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Navigation extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'navigation';
    protected $guarded = ['id'];

    /**
     * 获取关联的课件记录详情
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child()
    {
        return $this->hasMany('App\Models\NavigationChild', 'navigation_id', 'id')
            ->select('navigation_id', 'child_id', 'title');
    }

}