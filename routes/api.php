<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WilayahController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/wilayah/provinces', [WilayahController::class, 'provinces']);
Route::get('/wilayah/regencies/{province_id}', [WilayahController::class, 'regencies']);
Route::get('/wilayah/districts/{city_id}', [WilayahController::class, 'districts']);
