<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $connection = 'mysql';
    protected $table = 'course';
    protected $guarded = ['id'];

    /**
     * 数据变更时，自动触发回调
     */
    public static function boot()
    {
        parent::boot();

        //当更新时触发
        self::updated(function ($model)
        {
            //关闭
            if ($model->is_show_homepage == 0) {
                NavigationChild::query()
                    ->where('child_table', 'course')
                    ->where('child_id', $model->id)
                    ->delete();
            }
            //开启
            if ($model->is_show_homepage == 1) {
                NavigationChild::firstOrCreate([
                    'child_table' => 'course',
                    'child_id' => $model->id
                ], [
                    'navigation_id' => 2,
                    'title' => $model->title,
                ]);
            }

        });
    }
}
