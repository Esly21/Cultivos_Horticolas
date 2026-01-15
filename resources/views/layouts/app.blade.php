<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartGarden') }}</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>

    {{-- Chart.js (NECESARIO PARA LAS GRÁFICAS) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Alpine.js --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-50">
        <div class="flex">
            {{-- Sidebar / navegación --}}
            @include('layouts.navigation')

            {{-- Contenido principal --}}
            <main class="flex-1 p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Inicializar iconos --}}
    <script>
        lucide.createIcons();
    </script>

    {{-- Scripts inyectados desde vistas --}}
    @stack('scripts')

</body>
</html>
