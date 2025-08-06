<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recommendation Survey Time</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-100 via-white to-blue-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 px-4">
        <div class="w-full max-w-3xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                <h1 class="text-2xl font-bold text-blue-700 dark:text-blue-400 mb-6 text-center flex items-center justify-center gap-2">
                    <svg class="w-8 h-8 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 15a4 4 0 0 0 4 4h10a4 4 0 0 0 4-4V7a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v8z"/></svg>
                    Rekomendasi Waktu Kunjungan Maintenance
                </h1>
                <form id="wilayah-form" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="provinsi" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Provinsi</label>
                            <select id="provinsi" name="provinsi" class="flowbite-select w-full">
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>
                        <div>
                            <label for="kabupaten_kota" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Kabupaten/Kota</label>
                            <select id="kabupaten_kota" name="kabupaten_kota" class="flowbite-select w-full" disabled>
                                <option value="">Pilih Kabupaten/Kota</option>
                            </select>
                        </div>
                        <div>
                            <label for="kecamatan" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Kecamatan</label>
                            <select id="kecamatan" name="kecamatan" class="flowbite-select w-full" disabled>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div>
                            <label for="desa" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Desa/Kelurahan</label>
                            <select id="desa" name="desa" class="flowbite-select w-full" disabled>
                                <option value="">Pilih Desa/Kelurahan</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="datetime" class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal dan Waktu</label>
                        <input type="datetime-local" id="datetime" name="datetime" class="flowbite-input w-full" />
                    </div>
                    <button type="submit" class="hover:cursor-pointer w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow transition duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m-4-5V3"/></svg>
                        Cari Prakiraan Cuaca
                    </button>
                </form>
                <div id="forecast-table" class="mt-8"></div>
                <div id="weather-result" class="mt-8"></div>
            </div>
        </div>
    </div>

    <script>
        // Utility: fetch data with error handling
        async function fetchData(url) {
            const response = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });
            if (!response.ok) throw new Error('Gagal mengambil data');
            return response.json();
        }

        // Utility: populate select element
        function populateSelect(id, items, valueKey = 'kode', textKey = 'nama', placeholder = null) {
            const select = document.getElementById(id);
            select.innerHTML = `<option value="">${placeholder || 'Pilih ' + id.replace('_', ' ')}</option>`;
            items.forEach(item => {
                select.innerHTML += `<option value="${item[valueKey]}">${item[textKey]}</option>`;
            });
            select.disabled = items.length === 0;
        }

        // Cascading selects logic
        async function handleSelectChange(parentId, childId, apiUrl, paramKey) {
            const parentValue = document.getElementById(parentId).value;
            const childSelect = document.getElementById(childId);
            childSelect.disabled = true;
            childSelect.innerHTML = `<option value="">Pilih ${childId.replace('_', ' ')}</option>`;
            if (childId === 'kecamatan') document.getElementById('desa').innerHTML = `<option value="">Pilih Desa/Kelurahan</option>`;
            if (parentValue) {
                const data = await fetchData(`${apiUrl}?${paramKey}=${parentValue}`);
                populateSelect(childId, data);
            }
        }

        document.getElementById('provinsi').addEventListener('change', () =>
            handleSelectChange('provinsi', 'kabupaten_kota', '/api/wilayah/kabupaten-kota', 'provinsi_kode')
        );
        document.getElementById('kabupaten_kota').addEventListener('change', () =>
            handleSelectChange('kabupaten_kota', 'kecamatan', '/api/wilayah/kecamatan', 'kabupaten_kota_kode')
        );
        document.getElementById('kecamatan').addEventListener('change', () =>
            handleSelectChange('kecamatan', 'desa', '/api/wilayah/desa', 'kecamatan_kode')
        );

        // Weather result card
        function weatherCard(data) {
            return `
                <div class="max-w-lg mx-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="flex flex-col md:flex-row items-center">
                        <img class="h-24 w-24 object-contain m-4" src="${data.image}" alt="${data.weather_desc}">
                        <div class="p-4 flex-1">
                            <div class="text-blue-700 dark:text-blue-400 font-bold text-lg mb-2">${data.weather_desc} <span class="text-xs text-gray-500">(${data.weather_desc_en})</span></div>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div><span class="font-semibold">Suhu:</span> ${data.t}°C</div>
                                <div><span class="font-semibold">Kelembapan:</span> ${data.hu}%</div>
                                <div><span class="font-semibold">Angin:</span> ${data.ws} km/jam</div>
                                <div><span class="font-semibold">Arah:</span> ${data.wd} → ${data.wd_to}</div>
                                <div><span class="font-semibold">Awan:</span> ${data.tcc}%</div>
                                <div><span class="font-semibold">Jarak Pandang:</span> ${data.vs_text}</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Recommendations list
        function recommendationsList(recs) {
            if (!recs.length) {
                return `<div class="mt-6 text-red-600 font-semibold text-center">Tidak ditemukan waktu yang direkomendasikan untuk kunjungan maintenance pada periode ini.</div>`;
            }
            return `
                <div class="mt-6">
                    <h3 class="text-lg font-bold mb-2 text-green-700 dark:text-green-400">Rekomendasi Waktu Kunjungan Maintenance:</h3>
                    <ul class="list-disc pl-6 space-y-2">
                        ${recs.map(rec => `
                            <li>
                                <span class="font-semibold">${rec.waktu}</span> - ${rec.cuaca}, Suhu: ${rec.suhu}°C, Kelembapan: ${rec.kelembapan}%, Angin: ${rec.angin} km/jam, Jarak Pandang: ${rec.jarak_pandang}
                            </li>
                        `).join('')}
                    </ul>
                </div>
            `;
        }

        // Form submit handler
        document.getElementById('wilayah-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const desaKode = document.getElementById('desa').value;
            const datetimeInput = document.getElementById('datetime').value;
            const weatherResult = document.getElementById('weather-result');
            const forecastTable = document.getElementById('forecast-table');
            weatherResult.innerHTML = '';
            forecastTable.innerHTML = '';

            if (!desaKode) {
                weatherResult.innerHTML = `<div class="text-red-600 font-semibold text-center">Pilih desa/kelurahan terlebih dahulu.</div>`;
                return;
            }
            if (!datetimeInput) {
                weatherResult.innerHTML = `<div class="text-red-600 font-semibold text-center">Pilih tanggal dan waktu terlebih dahulu.</div>`;
                return;
            }

            try {
                const response = await fetch('/api/weather/forecast', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ kode_wilayah: desaKode }),
                });
                const result = await response.json();
                if (!response.ok) throw new Error(result.error || 'Terjadi kesalahan');

                const forecast = result.data.forecast || [];

                // Find closest forecast to selected datetime
                const selectedDate = new Date(datetimeInput);
                const closest = forecast.reduce((prev, curr) => {
                    const prevDiff = Math.abs(selectedDate - new Date(prev.datetime));
                    const currDiff = Math.abs(selectedDate - new Date(curr.datetime));
                    return currDiff < prevDiff ? curr : prev;
                }, forecast[0]);
                weatherResult.innerHTML = weatherCard(closest);

                // Recommendations
                // Find recommended times for maintenance survey
                const recommendations = forecast.filter(item =>
                    ['Cerah', 'Cerah Berawan', 'Berawan'].includes(item.weather_desc) &&
                    item.t >= 22 && item.t <= 32 &&
                    item.hu < 80 &&
                    item.ws < 20
                ).map(item => ({
                    waktu: item.local_datetime,
                    cuaca: item.weather_desc,
                    suhu: item.t,
                    kelembapan: item.hu,
                    angin: item.ws,
                    jarak_pandang: item.vs_text
                }));
                weatherResult.innerHTML += recommendationsList(recommendations);

            } catch (err) {
                weatherResult.innerHTML = `<div class="text-red-600 font-semibold text-center">Error: ${err.message}</div>`;
            }
        });

        // Initial load: populate provinsi
        (async () => {
            const data = await fetchData('/api/wilayah/provinsi');
            populateSelect('provinsi', data, 'kode', 'nama', 'Pilih Provinsi');
        })();
    </script>
</body>

</html>
