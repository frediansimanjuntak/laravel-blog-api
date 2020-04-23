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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function() {
    //login
    Route::post('login', 'Api\UserController@login');

    //register
    Route::post('register', 'Api\UserController@register');

    //activity
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('my-account', 'Api\UserController@my_account');
    });

    Route::apiResource('articles', 'Api\ArticleController');
});
