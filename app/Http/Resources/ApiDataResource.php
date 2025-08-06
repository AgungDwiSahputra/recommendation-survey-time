<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiDataResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'data' => $this->resource, // Sesuaikan dengan struktur data API
            'fetched_at' => now()->toDateTimeString(),
        ];
    }
}