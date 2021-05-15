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

/* Users */
Route::prefix('users')->group(function() {
   Route::post('/login', 'Api\UserController@login')->name('users.login');
    Route::post('/register', 'Api\UserController@register')->name('users.register');
   Route::get('/', 'Api\UserController@show')->name('users.show');
});
