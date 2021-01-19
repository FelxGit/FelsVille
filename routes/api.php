<?php

use Illuminate\Http\Request;

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

Route::get('products', 'ProductController@index');              
Route::get('products/{product}', 'ProductController@show');
Route::post('upload-file', 'ProductController@uploadFile');
Route::get('cart-local','CartController@localIndex');
Route::get('cart-local/{product_id}/{quantity}', 'CartController@localStore');
Route::put('cart-local/{cart_id}', 'CartController@localUpdate');
Route::get('cart-local/{cart_id}', 'CartController@localDestroy');

Route::group(['middleware' => 'auth:api'], function(){  // or if user has token

    Route::apiResource('cart','CartController')->except(['show']);
    Route::get('users','UserController@index');
    Route::get('users/{user}','UserController@show');
    Route::patch('users/{user}','UserController@update');

    Route::resource('products', 'ProductController')->except(['index','show']);
    Route::patch('products/{product}/units/add','ProductController@updateUnits');

    Route::resource('orders', 'OrderController');
    Route::patch('orders/{order}/deliver','OrderController@deliverOrder');
});



