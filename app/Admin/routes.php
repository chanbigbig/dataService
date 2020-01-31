<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router)
{

    $router->get('/', 'HomeController@index');

    $router->resource('orders', 'OrderController');

    $router->resource('navigation', 'NavigationController');

    $router->resource('navigationbaby', 'NavigationChildController');

    $router->resource('headpicture', 'HeadPictureController');
    //项目介绍
    $router->resource('course', 'CourseController');
    //以往案例
    $router->resource('history/course', 'HistoryCourseController');
    //团队介绍
    $router->resource('team', 'TeamController');
    //研学须知
    $router->resource('needknow', 'NeedKnowController');
    //合作
    $router->resource('cooperation', 'CooperationController');
    //关于我们
    $router->resource('about', 'AboutController');

    //底部导航栏
    $router->resource('tabbar', 'TabbarController');
    //加入我们
    $router->resource('advise', 'AdviseController');

    //首页管理
    $router->resource('homehistory', 'HomeHistoryController');
    $router->resource('homebespock', 'HomeBespockController');
    $router->resource('homemedia', 'HomeShowMediaController');
});
