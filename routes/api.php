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
Route::group([
    'prefix' => 'users'
], function() {
    Route::post('/login', 'Api\UserController@login')->name('api.users.login');
    Route::post('/register', 'Api\UserController@register')->name('api.users.register');
    Route::get('/definitive_registers', 'Api\UserController@definitiveRegister')->name('api.users.definitive_register');
});

Route:: group([
    'middleware' => 'auth:api',
], function() {
    Route::group([
        'prefix' => 'users'
    ], function() {
        Route::get('/', 'Api\UserController@show')->name('api.users.show');
    });

    /* Drugs */
    Route::group([
        'prefix' => 'drugs'
    ], function() {
        Route::get('/', 'Api\DrugController@index')->name('api.drugs.index');
        Route::get('/{drugId}', 'Api\DrugController@show')->name('api.drugs.show');
        Route::get('/show/name', 'Api\DrugController@showName')->name('api.drugs.show.name');
        Route::post('/create', 'Api\DrugController@create')->name('api.drugs.create');
    });

    /* Medication Histories */
    Route::group([
        'prefix' => 'medication_histories'
    ], function() {
        Route::post('/create', 'Api\MedicationHistoryController@create')->name('api.medication_histories.create');
    });
});
