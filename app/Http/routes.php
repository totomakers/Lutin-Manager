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


//==============
//Orders routing
//==============

Route::group(['as' => 'orders', 'prefix' => 'orders'], function () //plurial is always better for routes
{
    Route::get('/',                     ['as' => '::viewAll',  'middleware' => 'auth.rank:0', 'uses' => 'OrderController@viewAll']);
    Route::post('/',                    ['as' => '::import',  'middleware' => 'auth.rank:1', 'uses' => 'OrderController@importFile']);
    Route::post('/{id}/validate',       ['as' => '::validate', 'middleware' => 'auth.rank:0', 'uses' => 'OrderController@validateOrder'])->where('id', '[0-9]+');
    Route::get('/{id}/deliverynote',    ['as' => '::delivery','middleware' => 'auth.rank:0', 'uses' => 'OrderController@deliveryNote'])->where('id', '[0-9]+');
    Route::get('/deliverynotes',        ['as' => '::deliveryNotes',  'middleware' => 'auth.rank:1', 'uses' => 'OrderController@viewOld']);
});

//==============
//Items routing
//==============
Route::group(['as' => 'items', 'prefix' => 'items'], function()
{
    Route::get('/',                     ['as' => '::viewAll', 'middleware' => 'auth.rank:1', 'uses' => 'ItemController@viewAll']);
    Route::get('/edit/{id}',            ['as' => '::edit',    'middleware' => 'auth.rank:1', 'uses' => 'ItemController@viewUpdate'])->where('id', '[0-9]+');
    Route::post('/{id}',                ['as' => '::update',  'middleware' => 'auth.rank:1', 'uses' => 'ItemController@update'])->where('id', '[0-9]+');
    Route::delete('/delete/{id}',       ['as' => '::delete',  'middleware' => 'auth.rank:1', 'uses' => 'ItemController@delete'])->where('id', '[0-9]+');
    Route::post('/',                    ['as' => '::create',  'middleware' => 'auth.rank:1', 'uses' => 'ItemController@create']);
});

//==============
//Users routing
//==============
Route::group(['as' => 'users', 'prefix' => 'users'], function()
{
    Route::get('/',                     ['as' => '::viewAll',       'middleware' => 'auth.rank:1', 'uses' => 'UserController@viewAll']);
    Route::get('/edit/{id}',            ['as' => '::edit',          'middleware' => 'auth.rank:1', 'uses' => 'UserController@viewUpdate'])->where('id', '[0-9]+');
    Route::delete('/delete/{id}',       ['as' => '::delete',        'middleware' => 'auth.rank:1', 'uses' => 'UserController@delete'])->where('id', '[0-9]+');
    Route::post('/{id}',                ['as' => '::update',        'middleware' => 'auth.rank:1', 'uses' => 'UserController@update'])->where('id', '[0-9]+');
    Route::post('/',                    ['as' => '::create',        'middleware' => 'auth.rank:1', 'uses' => 'UserController@create']);
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

//============
//Keep me last

Route::any('{all}', function($uri)
{
    return Redirect::to('auth')->with(['error' => true , 'messages' => [ 'Ooops ! Cette page aété mangé par le Grinch !' ]]);
    
})->where('all', '.*');
