<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeatherForecastResource extends JsonResource
{
    public function toArray($request)
    {
        // Sesuaikan dengan struktur respons API BMKG
        return [
            'location' => $this->resource['data'][0]['lokasi'] ?? null,
            'forecast' => $this->resource['data'][0]['cuaca'][0] ?? [],
            'fetched_at' => now()->toDateTimeString(),
        ];
    }
}