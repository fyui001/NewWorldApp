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
   Route::post('/login', 'UserController@login')->name('users.login');
   Route::get('/', 'UserController@show')->name('users.show');
});
