<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegionsSeeder extends Seeder
{
    public function run()
    {
        $url = 'https://raw.githubusercontent.com/kodewilayah/permendagri-72-2019/main/dist/base.csv';
        $response = Http::get($url);

        if ($response->successful()) {
            $rows = array_map('str_getcsv', explode("\n", $response->body()));
            $chunks = array_chunk($rows, 1000); // Process in chunks to handle large data
            foreach ($chunks as $chunk) {
                $this->command->info('Processing chunk of ' . count($chunk) . ' rows');
                Log::info('Processing chunk of ' . count($chunk) . ' rows');
                $data = [];
                foreach ($chunk as $row) {
                    $this->command->info('Processing row: ' . implode(',', $row));
                    Log::info('Processing row: ' . implode(',', $row));
                    if (count($row) < 2) {
                        $this->command->info('Skipping empty or invalid row');
                        Log::info('Skipping empty or invalid row');
                        continue;
                    }

                    $kode = $row[0];
                    $nama = $row[1];

                    // Determine level and parent_kode based on code length
                    if (strlen($kode) == 2) {
                        $tingkat = 'provinsi';
                        $parent_kode = null;
                    } elseif (strlen($kode) == 5) {
                        $tingkat = 'kabupaten_kota';
                        $parent_kode = substr($kode, 0, 2);
                    } elseif (strlen($kode) == 8) {
                        $tingkat = 'kecamatan';
                        $parent_kode = substr($kode, 0, 5);
                    } elseif (strlen($kode) == 13) {
                        $tingkat = 'desa';
                        $parent_kode = substr($kode, 0, 8);
                    } else {
                        $this->command->info('Skipping invalid row with code: ' . $kode);
                        Log::info('Skipping invalid row with code: ' . $kode);
                        continue;
                    }

                    $data[] = [
                        'kode' => $kode,
                        'nama' => $nama,
                        'parent_kode' => $parent_kode,
                        'tingkat' => $tingkat,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Insert data in batches for efficiency
                DB::table('regions')->insert($data);
            }
        } else {
            throw new \Exception('Gagal mengambil data CSV wilayah');
        }
    }
}