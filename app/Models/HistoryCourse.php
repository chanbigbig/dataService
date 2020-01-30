<?php

namespace App\Models;

use function foo\func;
use Illuminate\Database\Eloquent\Model;

class HistoryCourse extends Model
{
    protected $connection = 'mysql';
    protected $table = 'history_course';
    protected $guarded = ['id'];

    /**
     * 数据变更时，自动触发回调
     */
    public static function boot()
    {
        parent::boot();

        self::created(function ($model)
        {
            if ($model->is_show_homepage == 1) {
                NavigationChild::firstOrCreate([
                    'child_table' => 'course',
                    'child_id' => $model->id
                ], [
                    'navigation_id' => 3,
                    'title' => $model->title,
                ]);
            }
        });

        //当更新时触发
        self::updated(function ($model)
        {
            //关闭
            if ($model->is_show_homepage == 0) {
                NavigationChild::query()
                    ->where('child_table', 'history_course')
                    ->where('child_id', $model->id)
                    ->delete();
            }
            //开启
            if ($model->is_show_homepage == 1) {
                NavigationChild::firstOrCreate([
                    'child_table' => 'history_course',
                    'child_id' => $model->id
                ], [
                    'navigation_id' => 3,
                    'title' => $model->title,
                ]);
            }

        });

        self::deleted(function ($model)
        {
            NavigationChild::query()
                ->where('child_table', 'history_course')
                ->where('child_id', $model->id)
                ->delete();
        });
    }
}
