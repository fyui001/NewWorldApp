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

Route::redirect('/', '/auth/login');

/* Top Page */
Route::get('/top', 'Admin\HomeController@index')->name('top_page');

/* Auth */
Route::prefix('auth')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('auth.login');
    Route::post('/login', 'Auth\LoginController@login')->name('auth.login.post');
    Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');
});

/* Admin Users */
Route::prefix('admin_users')->group(function() {
    Route::get('/','Admin\AdminUserController@index')->name('admin_users.index');
    Route::get('/create','Admin\AdminUserController@create')->name('admin_users.create');
    Route::post('/','Admin\AdminUserController@store')->name('admin_users.store');
    Route::get('/{adminUser}/edit','Admin\AdminUserController@edit')->where('user', '[0-9]+')->name('admin_users.edit');
    Route::put('/{adminUser}','Admin\AdminUserController@update')->where('user', '[0-9]+')->name('admin_users.update');
    Route::delete('/{adminUser}','Admin\AdminUserController@destroy')->where('user', '[0-9]+')->name('admin_users.destroy');
    Route::get('/api_token', 'Admin\AdminUserController@apiToken')->name('admin_users.api_token');
    Route::post('/api_token/update', 'Admin\AdminUserController@updateApiToken')->name('admin_users.api_token.update');
});

/* Drugs */
Route::prefix('drugs')->group(function() {
   Route::get('/', 'Admin\DrugController@index')->name('drugs.index');
   Route::get('/create', 'Admin\DrugController@create')->name('drugs.create');
   Route::post('/', 'Admin\DrugController@store')->name('drugs.store');
   Route::get('/edit/{drug}', 'Admin\DrugController@edit')->name('drugs.edit');
   Route::post('/update/{drug}', 'Admin\DrugController@update')->name('drugs.update');
   Route::post('/{drug}', 'Admin\DrugController@delete')->name('drugs.delete');
});

Route::prefix('medication_histories')->group(function(){
   Route::get('/', 'Admin\MedicationHistoryController@index')->name('medication_histories.index');
   Route::get('/edit/{medicationHistory}', 'Admin\MedicationHistoryController@edit')->name('medication_histories.edit');
   Route::post('/update/{medicationHistory}', 'Admin\MedicationHistoryController@update')->name('medication_histories.update');
});
