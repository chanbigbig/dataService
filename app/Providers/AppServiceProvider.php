<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Schema;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        define('REQUEST_MOBILE_FAILED', '请求失败，请检查设备是否在线');


        error_reporting(E_ALL ^ E_NOTICE);
        Schema::defaultStringLength(191);
        DB::enableQueryLog();
        Horizon::auth(function (Request $request)
        {
            if (env('APP_ENV') == 'local' || !Auth::guard('admin')->guest()) {
                return true;
            }
            return false;
        });

        if (env('APP_ENV') == 'local') {
            DB::listen(function ($query)
            {
                $sql = str_replace("?", "'%s'", $query->sql);
                $sql = vsprintf($sql, $query->bindings);
                $sql = str_replace("\\", "", $sql);
                Log::info($sql);
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            /*
            * Ide Helper
            */
            $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');

            //批量注册
            foreach (glob(base_path('app/Repositories/') . '*.php') as $filename) {
                $class = trim(basename($filename), '.php');

                $this->app->singleton($class, function () use ($class)
                {
                    return app('App\Repositories\\' . $class);
                });
            }
        }

    }
}
