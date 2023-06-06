<?php

use App\Employee;
use Illuminate\Support\Facades\Route;

// Employee
use App\Http\Controllers\EmployeeController;
// use App\Http\Controllers\Admin\ProvinsiController;

Route::get('/', 'HomeController@index')->name('dashboard');

// DASHBOARD
Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

//INStansi 
Route::get('/instansi/data', 'DataController@instansi')->name('instansi.data');
Route::get('/instansi', 'InstansiController@index')->name('instansi.index');
Route::get('/instansi/create', 'InstansiController@create')->name('instansi.create');
// Route::get('/instansi', 'instansiController@data')->name('instansi.data');
Route::post('/instansi', 'InstansiController@store')->name('instansi.store');
Route::get('/instansi/{instansi}/edit', 'InstansiController@edit')->name('instansi.edit');
Route::put('/instansi', 'InstansiController@update')->name('instansi.update');
Route::delete('/instansi', 'InstansiController@destroy')->name('instansi.destroy');




