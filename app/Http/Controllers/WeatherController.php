<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use App\Http\Resources\WeatherForecastResource;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    protected $bmkgService;

    public function __construct(ApiService $bmkgService)
    {
        $this->bmkgService = $bmkgService;
    }

    public function getForecast(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'kode_wilayah' => 'required|string',
        ]);

        try {
            $data = $this->bmkgService->getWeatherForecast($request->kode_wilayah);
            return new WeatherForecastResource($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}