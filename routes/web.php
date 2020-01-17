<?php

use Illuminate\Support\Facades\Route;

Route::get('', IndexController::class)->name('home');
Route::get('device/{device}', DeviceController::class)->name('device.show');
