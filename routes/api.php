<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'auth:api'
],function(){
    Route::post('user/store', 'App\Http\Controllers\Api\UserController@store');
    Route::get('users', 'App\Http\Controllers\Api\UserController@lists');
    Route::get('user/{id}', 'App\Http\Controllers\Api\UserController@view');
    Route::put('user/delete/{id}', 'App\Http\Controllers\Api\UserController@delete');
    Route::put('user/update/{id}', 'App\Http\Controllers\Api\UserController@update');
}
);
