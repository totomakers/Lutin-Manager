<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['uses'=>'OrderController@importFile']);

//==============
//Orders routing
//==============

Route::group(['as' => 'orders', 'prefix' => 'orders'], function () //plurial is always better for routes
{
    Route::get('/',                     ['as' => '::viewAll', /*'middleware' => 'auth.rank:0',*/ 'uses' => 'OrderController@viewAll']);
    Route::post('/{id}/validate',       ['as' => '::validate', 'middleware' => 'auth.rank:0', 'uses' => 'OrderController@validate'])->where('id', '[0-9]+');
});

//==============
//Items routing
//==============
Route::group(['as' => 'items', 'prefix' => 'items'], function()
{
    Route::get('/',                     ['as' => '::viewAll', 'middleware' => 'auth.rank:1', 'uses' => 'ItemController@viewAll']);
    Route::put('/{id}',                 ['as' => '::update',  'middleware' => 'auth.rank:1', 'uses' => 'ItemController@update'])->where('id', '[0-9]+');
    Route::delete('/{id}',              ['as' => '::delete',  'middleware' => 'auth.rank:1', 'uses' => 'ItemController@delete'])->where('id', '[0-9]+');
    Route::post('/',                    ['as' => '::create',  'middleware' => 'auth.rank:1', 'uses' => 'ItemController@create']);
});

//==============
//Users routing
//==============
Route::group(['as' => 'users', 'prefix' => 'users'], function()
{
    Route::get('/',                     ['as' => '::viewAll', 'middleware' => 'auth.rank:1', 'uses' => 'UserController@viewAll']);
    Route::put('/{id}',                 ['as' => '::update',  'middleware' => 'auth.rank:1', 'uses' => 'UserController@update'])->where('id', '[0-9]+');
    Route::delete('/{id}',              ['as' => '::delete',  'middleware' => 'auth.rank:1', 'uses' => 'UserController@delete'])->where('id', '[0-9]+');
    Route::post('/',                    ['as' => '::create',  'middleware' => 'auth.rank:1', 'uses' => 'UserController@create']);
});


//==============
//Auth routing
//==============
Route::group(['as' => 'auth', 'prefix' => 'auth'], function()
{
    Route::get('/',                     ['as' => '::viewLogin', 'uses' => 'AuthController@viewLogin']);
    Route::get('/logout',               ['as' => '::logout',    'uses' => 'AuthController@logout']);
    Route::post('/login',               ['as' => '::login',     'uses' => 'AuthController@login']);
});
