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
    'prefix' => 'users',
], function() {
    Route::post('/login', 'Api\User\IndexController@login')->name('api.users.login');
    Route::post('/register', 'Api\User\IndexController@register')->name('api.users.register');
    Route::post('/definitive_registers', 'Api\User\IndexController@definitiveRegister')->name('api.users.definitive_register');
});

Route:: group([
    'middleware' => 'auth:api',
], function() {
    /* Users */
    Route::group([
        'prefix' => 'users'
    ], function() {
        Route::get('/', 'Api\User\IndexController@show')->name('api.users.show');

        /* Medication Histories */
        Route::group([
            'prefix' => 'medication_histories'
        ], function() {
            Route::get('/', 'Api\User\MedicationHistoriesController@index')->name('api.users.medication_histories');
            Route::post('/create', 'Api\MedicationHistoryController@create')->name('api.medication_histories.create');
        });
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

});
