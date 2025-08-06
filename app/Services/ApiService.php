<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.external_api.base_url'); // Ambil dari config
    }

    public function getWeatherForecast(string $kodeWilayah)
    {
        Log::info('Mengambil prakiraan cuaca untuk kode wilayah: ' . $kodeWilayah);
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get("{$this->baseUrl}/publik/prakiraan-cuaca", [
                'adm4' => $kodeWilayah,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception('Gagal mengambil data prakiraan cuaca: ' . $response->status());
        } catch (RequestException $e) {
            Log::error('Error API BMKG: ' . $e->getMessage());
            throw new \Exception('Gagal terhubung ke API BMKG: ' . $e->getMessage());
        }
    }
}