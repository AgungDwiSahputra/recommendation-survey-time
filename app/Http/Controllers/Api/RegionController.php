<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RegionService;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    protected $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    public function getProvinsi()
    {
        return response()->json($this->regionService->getProvinsi());
    }

    public function getKabupatenKota(Request $request)
    {
        $request->validate(['provinsi_kode' => 'required|string']);
        return response()->json($this->regionService->getKabupatenKota($request->provinsi_kode));
    }

    public function getKecamatan(Request $request)
    {
        $request->validate(['kabupaten_kota_kode' => 'required|string']);
        return response()->json($this->regionService->getKecamatan($request->kabupaten_kota_kode));
    }

    public function getDesa(Request $request)
    {
        $request->validate(['kecamatan_kode' => 'required|string']);
        return response()->json($this->regionService->getDesa($request->kecamatan_kode));
    }
}
