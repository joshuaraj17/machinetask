<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('optimize:clear');
    $exitCode = Artisan::call('cache:forget spatie.permission.cache');
    return '<h1>Clear Config cleared</h1>';
});


    Route::get('/', 'EmployeeController@index')->name('employee');
    Route::get('employee/create', 'EmployeeController@create')->name('employee.create');
    Route::post('employee/store', 'EmployeeController@store')->name('employee.store');
    Route::get('employee/edit/{id}', 'EmployeeController@edit')->name('employee.edit');
    Route::post('employee/update/{id}', 'EmployeeController@update')->name('employee.update');
    Route::post('employee/destroy', 'EmployeeController@destroy')->name('employee.destroy');


