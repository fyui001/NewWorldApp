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
   Route::post('/login', 'Api\UserController@login')->name('api.users.login');
   Route::post('/register', 'Api\UserController@register')->name('api.users.register');
   Route::get('/', 'Api\UserController@show')->name('api.users.show');
});

/* Drugs */
Route::prefix('drugs')->middleware('auth:api')->group(function() {
   Route::get('/', 'Api\DrugController@index')->name('api.drugs.index');
   Route::get('/show', 'Api\DrugController@show')->name('api.drugs.show');
   Route::post('/create', 'Api\DrugController@create')->name('api.drugs.create');
});

/* Medication Histories */
Route::prefix('medication_histories')->middleware('auth:api')->group(function() {
    Route::post('/create', 'Api\MedicationHistoryController@create')->name('api.medication_histories.create');
});
