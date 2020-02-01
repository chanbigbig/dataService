<?php

//use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['cors']], function ()
{
    Route::get('test', 'IndexController@test');

    Route::get('homepage', 'HomePageController@getHomepageData');

    Route::post('advise', 'HomePageController@advise');
    //顶部导航栏
    Route::get('navigation/list', 'NavigationController@getList');
    //底部导航栏
    Route::get('tabbar', 'TabbarController@getItem');
    //顶部图片
    Route::get('head/picture', 'HeadPictureController@getList');

    //项目介绍
    Route::get('course', 'CourseController@getItem');
    Route::get('course/list', 'CourseController@getList');

    //以为案例
    Route::get('historycourse', 'HistoryCourseController@getItem');
    Route::get('historycourse/list', 'HistoryCourseController@getList');

    //团队介绍
    Route::get('team', 'TeamController@getItem');
    Route::get('team/list', 'TeamController@getList');

    //研学须知
    Route::get('needknow', 'NeedKnowController@getItem');

    //合作
    Route::get('cooperation', 'CooperationController@getItem');


    //关于我们
    Route::get('about', 'AboutController@getItem');
});