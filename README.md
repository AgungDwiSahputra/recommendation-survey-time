# Recommendation Survey Time

Web app ini membantu teknisi IT menentukan waktu terbaik untuk kunjungan maintenance ke cabang Bank XYZ pada hari tertentu, berdasarkan jadwal dan kebutuhan, agar proses lebih efisien dan terorganisir tanpa mengganggu operasional layanan. Aplikasi ini menggunakan prakiraan cuaca dari API BMKG untuk menyarankan slot waktu yang optimal untuk kegiatan outdoor seperti kunjungan maintenance.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Tentang Proyek

Aplikasi ini dibangun menggunakan **Laravel** sebagai framework backend, **Tailwind CSS** dan **Flowbite** untuk antarmuka pengguna yang modern dan responsif, serta **SQLite** sebagai database lokal. Aplikasi ini memungkinkan pengguna untuk:
- Menginput lokasi (kecamatan/desa), dan tanggal kegiatan.
- Mendapatkan saran slot waktu berdasarkan prakiraan cuaca dari API BMKG (misalnya, waktu dengan cuaca cerah atau berawan).

Fitur utama:
- Form input untuk menjadwalkan kegiatan.
- Integrasi dengan API BMKG untuk prakiraan cuaca 3 hari.
- Filtering slot waktu yang mendukung kegiatan outdoor.
- Antarmuka pengguna yang ramah dengan Tailwind CSS dan Flowbite.

## Prasyarat

Sebelum menjalankan aplikasi, pastikan Anda telah menginstal perangkat lunak berikut:
- **PHP** >= 8.0
- **Composer** (untuk mengelola dependensi Laravel)
- **Node.js** dan **NPM** (untuk mengelola Tailwind CSS dan Flowbite)
- **SQLite** (pastikan ekstensi SQLite diaktifkan di PHP)
- Akses ke internet untuk mengambil data dari API BMKG
- Git (opsional, untuk mengelola kode sumber)

## Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di mesin lokal Anda:

1. **Clone Repository** (jika menggunakan Git):
   ```bash
   git clone https://github.com/AgungDwiSahputra/recommendation-survey-time
   cd recommendation-survey-time
   ```

2. **Instal Dependensi PHP**:
   Jalankan perintah berikut untuk menginstal dependensi Laravel:
   ```bash
   composer install
   ```

3. **Instal Dependensi Frontend**:
   Instal Tailwind CSS dan Flowbite menggunakan NPM:
   ```bash
   npm install
   ```

4. **Konfigurasi File Lingkungan**:
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan pastikan pengaturan database diatur ke SQLite:
   ```env
   DB_CONNECTION=sqlite
   ```
   Pastikan file `database/database.sqlite` sudah ada. Jika belum, buat file kosong pada folder `database` dengan nama `database.sqlite`

5. **Generate Kunci Aplikasi**:
   Jalankan perintah untuk menghasilkan kunci aplikasi Laravel:
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Migrasi Database**:
   Jalankan migrasi untuk membuat tabel di database SQLite:
   ```bash
   php artisan migrate
   ```

7. **Jalankan Seeder (Opsional)**:
   Jika Anda telah membuat seeder untuk data awal, jalankan:
   ```bash
   php artisan db:seed
   ```

8. **Kompilasi Aset Frontend**:
   Kompilasi Tailwind CSS dan aset lainnya:
   ```bash
   npm run dev
   ```
   Untuk mode produksi, gunakan:
   ```bash
   npm run build
   ```

9. **Jalankan Server Lokal**:
   Jalankan server pengembangan Laravel:
   ```bash
   php artisan serve
   ```
   Aplikasi akan tersedia di `http://localhost:8000`.

10. **Akses API BMKG**:
    Pastikan Anda memiliki akses ke API BMKG ([https://data.bmkg.go.id/prakiraan-cuaca/](https://data.bmkg.go.id/prakiraan-cuaca/)). Jika API memerlukan kunci atau konfigurasi khusus, tambahkan ke file `.env` (misalnya, `BMKG_API_KEY=your_api_key`).

## Penggunaan

1. Buka aplikasi di browser (misalnya, `http://localhost:8000`).
2. Masukkan lokasi (kecamatan/desa), dan tanggal melalui form yang tersedia.
3. Aplikasi akan menampilkan saran slot waktu berdasarkan prakiraan cuaca.
4. Pilih slot waktu yang diinginkan, dan data akan disimpan ke database SQLite.

## Asumsi yang Dibuat

- **API BMKG**: Aplikasi mengasumsikan API BMKG dapat diakses tanpa autentikasi atau menggunakan kunci API sederhana. Jika API tidak tersedia, Anda dapat menggunakan mock data (misalnya, file JSON lokal) untuk simulasi.
- **Slot Waktu**: Slot waktu dibatasi pada rentang tertentu (misalnya, pagi: 08:00-12:00, siang: 12:00-16:00, sore: 16:00-20:00).
- **Kondisi Cuaca**: Hanya cuaca "Cerah" dan "Berawan" yang dianggap mendukung kegiatan outdoor.
- **SQLite**: Database SQLite digunakan untuk kemudahan pengembangan dan tidak memerlukan server database terpisah.
- **Tailwind CSS dan Flowbite**: Digunakan untuk mempercepat pengembangan UI yang responsif dan modern.

## Kontribusi

Terima kasih telah mempertimbangkan untuk berkontribusi pada proyek ini! Panduan kontribusi dapat ditemukan di [dokumentasi Laravel](https://laravel.com/docs/contributions).

## Kode Etik

Untuk memastikan komunitas yang ramah, silakan tinjau dan patuhi [Kode Etik](https://laravel.com/docs/contributions#code-of-conduct).

## Kerentanan Keamanan

Jika Anda menemukan kerentanan keamanan dalam aplikasi, silakan kirim email ke [taylor@laravel.com](mailto:taylor@laravel.com). Semua kerentanan akan segera ditangani.

## Lisensi

Aplikasi ini menggunakan Laravel framework yang dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).
