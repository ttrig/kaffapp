<?php

use Illuminate\Support\Facades\Route;

Route::get('device/{device}', 'ApiController@getDevice')->name('get-device');
Route::post('data', 'ApiController@postData')->name('post-data')->middleware('auth:api');
