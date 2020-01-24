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

    $router->resource('course', 'CourseController');

    $router->resource('homehistory', 'HomeHistoryController');

    $router->resource('homebespock', 'HomeBespockController');

    $router->resource('homemedia', 'HomeShowMediaController');
});
