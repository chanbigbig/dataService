<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $connection = 'mysql';
    protected $table = 'team';
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
                    'child_table' => 'team',
                    'child_id' => $model->id
                ], [
                    'navigation_id' => 4,
                    'title' => $model->name,
                ]);
            }
        });

        //当更新时触发
        self::updated(function ($model)
        {
            //关闭
            if ($model->is_show_homepage == 0) {
                NavigationChild::query()
                    ->where('child_table', 'team')
                    ->where('child_id', $model->id)
                    ->delete();
            }
            //开启
            if ($model->is_show_homepage == 1) {
                NavigationChild::firstOrCreate([
                    'child_table' => 'team',
                    'child_id' => $model->id
                ], [
                    'navigation_id' => 4,
                    'title' => $model->name,
                ]);
            }

        });

        self::deleted(function ($model)
        {
            NavigationChild::query()
                ->where('child_table', 'team')
                ->where('child_id', $model->id)
                ->delete();
        });
    }
}
