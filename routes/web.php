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
Route::get('/top', 'HomeController@index')->name('top_page');

/* Auth */
Route::prefix('auth')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm')->name('auth.login');
    Route::post('/login', 'Auth\LoginController@login')->name('auth.login.post');
    Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');
});

/* Admin Users */
Route::prefix('admin_users')->group(function() {
    Route::get('/','AdminUserController@index')->name('admin_users.index');
    Route::get('/create','AdminUserController@create')->name('admin_users.create');
    Route::post('/','AdminUserController@store')->name('admin_users.store');
    Route::get('/{adminUser}/edit','AdminUserController@edit')->where('user', '[0-9]+')->name('admin_users.edit');
    Route::put('/{adminUser}','AdminUserController@update')->where('user', '[0-9]+')->name('admin_users.update');
    Route::delete('/{adminUser}','AdminUserController@destroy')->where('user', '[0-9]+')->name('admin_users.destroy');
});

/* Drugs */
Route::prefix('drugs')->group(function() {
   Route::get('/', 'DrugController@index')->name('drugs.index');
   Route::get('/create', 'DrugController@create')->name('drugs.create');
   Route::post('/', 'DrugController@store')->name('drugs.store');
   Route::get('/edit/{drug}', 'DrugController@edit')->name('drugs.edit');
   Route::post('/update/{drug}', 'DrugController@update')->name('drugs.update');
});

Route::prefix('medication_histories')->group(function(){
   Route::get('/', 'MedicationHistoryController@index')->name('medication_histories.index');
   Route::get('/edit/{medicationHistory}', 'MedicationHistoryController@edit')->name('medication_histories.edit');
   Route::post('/update/{medicationHistory}', 'MedicationHistoryController@update')->name('medication_histories.update');
});
