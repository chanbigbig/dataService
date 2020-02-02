<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NeedKnow extends Model
{
    protected $connection = 'mysql';
    protected $table = 'need_know';
    protected $guarded = ['id'];

    protected $navigationId = 5;

    public function getNavigationId()
    {
        return $this->navigationId;
    }

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
                    'child_table' => 'need_know',
                    'child_id' => $model->id
                ], [
                    'navigation_id' => self::getNavigationId(),
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
                    ->where('child_table', 'need_know')
                    ->where('child_id', $model->id)
                    ->delete();
            }
            //开启
            if ($model->is_show_homepage == 1) {
                NavigationChild::firstOrCreate([
                    'child_table' => 'need_know',
                    'child_id' => $model->id
                ], [
                    'navigation_id' => self::getNavigationId(),
                    'title' => $model->title,
                ]);
            }

        });

        self::deleted(function ($model)
        {
            NavigationChild::query()
                ->where('child_table', 'need_know')
                ->where('child_id', $model->id)
                ->delete();
        });
    }
}
