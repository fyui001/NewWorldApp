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

Route::get('/csrf_token', \App\Http\Api\Common\Action\GetCsrfTokenAction::class);

/* Users */
Route::group([
    'prefix' => 'users',
], function() {
    Route::post('/login', 'User\Action\IndexController@login')->name('api.users.login');
    Route::post('/register', 'User\Action\IndexController@register')->name('api.users.register');
    Route::post('/definitive_registers', 'User\Action\IndexController@definitiveRegister')->name('api.users.definitive_register');
});

Route:: group([
    'middleware' => 'auth:api',
], function() {
    /* Users */
    Route::group([
        'prefix' => 'users'
    ], function() {
        Route::get('/', 'User\Action\IndexController@show')->name('api.users.show');

        /* Medication Histories */
        Route::group([
            'prefix' => 'medication_histories'
        ], function() {
            Route::get('/', 'User\Action\MedicationHistoriesController@index')->name('api.users.medication_histories');
            Route::post('/create', 'MedicationHistoryController@create')->name('api.medication_histories.create');
        });
    });

    /* Drugs */
    Route::group([
        'prefix' => 'drugs'
    ], function() {
        Route::get('/', 'DrugController@index')->name('api.drugs.index');
        Route::get('/{drugId}', 'DrugController@show')->name('api.drugs.show');
        Route::get('/show/name', 'DrugController@showName')->name('api.drugs.show.name');
        Route::post('/create', 'DrugController@create')->name('api.drugs.create');
    });

});
