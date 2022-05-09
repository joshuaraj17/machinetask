<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/testing', function () {
    
    echo  '<h1>Clear Config cleared</h1>';
});

Route::group(['prefix' => '/v1', 'namespace' => 'Api', 'as' => 'api.'], function () {
    Route::post('/login', 'V1\UserLoginController@login');  

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });    
});

