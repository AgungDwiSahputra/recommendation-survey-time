<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->string('kode', 13)->primary(); // Kode wilayah (2, 4, 7, atau 10 digit)
            $table->string('nama'); // Nama wilayah
            $table->string('parent_kode', 13)->nullable(); // Kode wilayah induk (null untuk provinsi)
            $table->string('tingkat'); // Tingkat: provinsi, kabupaten_kota, kecamatan, desa
            $table->timestamps();

            $table->index('parent_kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
