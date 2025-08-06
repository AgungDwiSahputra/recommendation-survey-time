<?php

use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\FetchAPIController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

// Region
Route::get('/wilayah/provinsi', [RegionController::class, 'getProvinsi']);
Route::get('/wilayah/kabupaten-kota', [RegionController::class, 'getKabupatenKota']);
Route::get('/wilayah/kecamatan', [RegionController::class, 'getKecamatan']);
Route::get('/wilayah/desa', [RegionController::class, 'getDesa']);

// Weather
Route::post('/weather/forecast', [WeatherController::class, 'getForecast']);