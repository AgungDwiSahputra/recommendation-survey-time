<?php

namespace App\Services;

use App\Models\Region;

class RegionService
{
    public function getProvinsi()
    {
        return Region::where('tingkat', 'provinsi')->get(['kode', 'nama']);
    }

    public function getKabupatenKota($provinsiKode)
    {
        return Region::where('tingkat', 'kabupaten_kota')
            ->where('parent_kode', $provinsiKode)
            ->get(['kode', 'nama']);
    }

    public function getKecamatan($kabupatenKotaKode)
    {
        return Region::where('tingkat', 'kecamatan')
            ->where('parent_kode', $kabupatenKotaKode)
            ->get(['kode', 'nama']);
    }

    public function getDesa($kecamatanKode)
    {
        return Region::where('tingkat', 'desa')
            ->where('parent_kode', $kecamatanKode)
            ->get(['kode', 'nama']);
    }
}