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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('/products','ProductController');

Route::group(['prefix'=>'product'],function(){
    Route::apiResource('/{product}/reviews','ReviewController');
});


// ############# Laravel Authorization #############

Route::group(['middleware' => ['cors', 'json.response']], function () {
    // public routes
    Route::post('/login', 'Auth\ApiAuthController@login')->name('login.api');
    Route::post('/register','Auth\ApiAuthController@register')->name('register.api');


});

Route::group(['middleware' => ['auth:api']],function(){
    Route::post('/logout', 'Auth\ApiAuthController@logout')->name('logout.api');
});
