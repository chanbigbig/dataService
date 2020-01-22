<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NavigationChild extends Model
{
    protected $connection = 'mysql';
    protected $table = 'navigation_child';
    protected $guarded = ['id'];

    /**
     * 数据变更时，自动触发回调
     */
    public static function boot()
    {
        parent::boot();

        //当删除时触发
        self::deleted(function ($model)
        {
            if ($model->child_table && $model->child_id) {
                DB::table($model->child_table)
                    ->where('id', $model->child_id)
                    ->update(['is_show_homepage' => 0]);

            }
        });
    }
}