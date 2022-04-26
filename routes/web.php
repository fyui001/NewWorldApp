<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/admin/auth/login');

Route::group(['prefix' => 'admin'], function() {
    /* Top Page */
    Route::get('/top', 'Admin\HomeController@index')->name('admin.top_page');

    /* Auth */
    Route::group(['prefix' => 'auth'], function() {
        Route::get('/login', 'Auth\LoginController@showLoginForm')->name('admin.auth.login');
        Route::post('/login', 'Auth\LoginController@login')->name('admin.auth.login.post');
        Route::get('/logout', 'Auth\LoginController@logout')->name('admin.auth.logout');
    });
    /* Admin Users */
    Route::group([
        'prefix' => 'admin_users',
        'middleware' => 'auth:web'
    ], function() {
        Route::get('/','Admin\AdminUserController@index')->name('admin.admin_users.index');
        Route::get('/create','Admin\AdminUserController@create')->name('admin.admin_users.create');
        Route::post('/','Admin\AdminUserController@store')->name('admin.admin_users.store');
        Route::get('/{adminUser}/edit','Admin\AdminUserController@edit')->where('user', '[0-9]+')->name('admin.admin_users.edit');
        Route::put('/{adminUser}','Admin\AdminUserController@update')->where('user', '[0-9]+')->name('admin.admin_users.update');
        Route::delete('/{adminUser}','Admin\AdminUserController@destroy')->where('user', '[0-9]+')->name('admin.admin_users.destroy');
    });

    /* Drugs */
    Route::group([
        'prefix' => 'drugs',
        'middleware' => 'auth:web'
    ], function() {
        Route::get('/', 'Admin\DrugController@index')->name('admin.drugs.index');
        Route::get('/create', 'Admin\DrugController@create')->name('admin.drugs.create');
        Route::post('/', 'Admin\DrugController@store')->name('admin.drugs.store');
        Route::get('/edit/{drug}', 'Admin\DrugController@edit')->name('admin.drugs.edit');
        Route::post('/update/{drug}', 'Admin\DrugController@update')->name('admin.drugs.update');
        Route::post('/{drug}', 'Admin\DrugController@delete')->name('admin.drugs.delete');
    });

    Route::group([
        'prefix' => 'medication_histories',
        'middleware' => 'auth:web'
    ], function(){
        Route::get('/', 'Admin\MedicationHistoryController@index')->name('admin.medication_histories.index');
        Route::get('/edit/{medicationHistory}', 'Admin\MedicationHistoryController@edit')->name('admin.medication_histories.edit');
        Route::post('/update/{medicationHistory}', 'Admin\MedicationHistoryController@update')->name('admin.medication_histories.update');
    });
});
