<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <link rel="icon" href="{{ asset('images/icon-app.png') }}" type="image/png">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div x-data="{
        darkMode: localStorage.getItem('dark-mode') === 'true',
        toggleTheme() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('dark-mode', this.darkMode);
            document.documentElement.classList.toggle('dark');
        }
    }">
        @include('layouts.navigation')



        <!-- Page Heading -->
        {{-- @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset --}}
        <div class="flex min-h-screen">
            @php
                $isAdmin = Auth::check() && Auth::user()->role === 'admin';
            @endphp

            @if ($isAdmin)
                @include('layouts.sidebar')
            @endif

            <!-- Page Content -->
            <main class="flex-1 w-full flex flex-col {{ $isAdmin ? 'md:ml-64' : '' }}">

                <div class="flex-grow">
                    {{ $slot }}
                </div>

                @include('layouts.footer')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <script>
        window.initWilayahDropdown = function(provinceSelectorId, citySelectorId, districtSelectorId = null,
            selectedValues = {}) {

            const provEl = document.getElementById(provinceSelectorId);
            const cityEl = document.getElementById(citySelectorId);
            const distEl = districtSelectorId ? document.getElementById(districtSelectorId) : null;

            if (!provEl) return;

            async function fetchData(url) {
                try {
                    const response = await fetch(url);
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return await response.json();
                } catch (error) {
                    console.error("Gagal mengambil data wilayah:", error);
                    return [];
                }
            }

            async function loadProvinces() {
                const data = await fetchData('/api/wilayah/provinces');

                provEl.innerHTML = '<option value="">Pilih Provinsi</option>';

                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.name;
                    if (selectedValues.prov && item.id == selectedValues.prov) opt.selected = true;
                    provEl.appendChild(opt);
                });

                if (selectedValues.prov) {
                    loadCities(selectedValues.prov);
                }
            }

            async function loadCities(provId) {
                cityEl.innerHTML = '<option>Loading...</option>';
                cityEl.disabled = true;

                const data = await fetchData(`/api/wilayah/regencies/${provId}`);

                cityEl.innerHTML = '<option value="">Pilih Kota/Kab</option>';

                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.name;
                    if (selectedValues.city && item.id == selectedValues.city) opt.selected = true;
                    cityEl.appendChild(opt);
                });

                cityEl.disabled = false;

                if (selectedValues.city && distEl) {
                    loadDistricts(selectedValues.city);
                }
            }

            async function loadDistricts(cityId) {
                if (!distEl) return;

                distEl.innerHTML = '<option>Loading...</option>';
                distEl.disabled = true;

                const data = await fetchData(`/api/wilayah/districts/${cityId}`);

                distEl.innerHTML = '<option value="">Pilih Kecamatan</option>';

                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id;
                    opt.textContent = item.name;
                    if (selectedValues.dist && item.id == selectedValues.dist) opt.selected = true;
                    distEl.appendChild(opt);
                });

                distEl.disabled = false;
            }

            provEl.addEventListener('change', function() {
                if (this.value) {
                    loadCities(this.value);
                    if (distEl) {
                        distEl.innerHTML = '<option value="">Pilih Kecamatan</option>';
                        distEl.disabled = true;
                    }
                } else {
                    cityEl.innerHTML = '<option value="">Pilih Kota/Kab</option>';
                    cityEl.disabled = true;
                }
            });

            if (distEl) {
                cityEl.addEventListener('change', function() {
                    if (this.value) loadDistricts(this.value);
                    else {
                        distEl.innerHTML = '<option value="">Pilih Kecamatan</option>';
                        distEl.disabled = true;
                    }
                });
            }
            loadProvinces();
        };
    </script>
    @stack('scripts')
</body>

</html>
