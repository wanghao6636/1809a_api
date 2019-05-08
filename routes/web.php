<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



//API接口
Route::get('user', 'Api\UserController@user');

//Curl
Route::get('texturl', 'Api\UserController@texturl');

//加密
Route::get('base64Test', 'Api\UserController@base64Test');
//解密
Route::post('base64code', 'Api\UserController@base64code');

Route::post('testpost', 'Api\UserController@testpost');

//中间件
Route::get('request10time', 'Api\UserController@request10time')->Middleware('request10times');


//注册
Route::get('reg', 'User\NewController@reg');
//登录
Route::get('login', 'User\NewController@login');

//个人中心
Route::get('rddlogin', 'User\NewController@rddlogin')->Middleware('request10times','rdd.login');


//资源控制器
Route::resource('index', 'CsController');



