<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Características - SmartGarden</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="antialiased">
        <div class="bg-white">
            <header class="absolute inset-x-0 top-0 z-50">
                <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                    <div class="flex lg:flex-1">
                        <a href="/" class="-m-1.5 p-1.5 flex items-center gap-3">
                            <img class="h-10 w-auto rounded-lg" src="{{ asset('images/Logo.jpg') }}" alt="SmartGarden Logo">
                            <span class="font-bold text-xl text-gray-800">SmartGarden</span>
                        </a>
                    </div>
                    <div class="flex lg:flex-1 lg:justify-end gap-x-6">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900">Dashboard</a>
                       
                           
                        @endauth
                    </div>
                </nav>
            </header>

            <div id="features" class="bg-gray-50 py-16 sm:py-24 pt-40">
                {{-- CAMBIO AQUÍ: Se añadió 'mx-auto' y 'max-w-7xl' --}}
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="text-center mx-auto max-w-2xl">
                        <h2 class="text-base font-semibold leading-7 text-green-600">Características</h2>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                            Todo lo que necesitas para tus cultivos
                        </p>
                    </div>
                    {{-- CAMBIO AQUÍ: Se añadió 'mx-auto' y 'max-w-4xl' --}}
                    <div class="mx-auto mt-16 max-w-4xl sm:mt-20 lg:mt-24">
                        <dl class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-2 lg:gap-y-16">
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-green-600">
                                        <i data-lucide="smartphone" class="w-6 h-6 text-white"></i>
                                    </div>
                                    Monitoreo en tiempo real
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Sensores que registran temperatura, humedad, y luminosidad las 24 horas del día, accesibles desde cualquier lugar.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-green-600">
                                        <i data-lucide="bell-ring" class="w-6 h-6 text-white"></i>
                                    </div>
                                    Alertas automáticas
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Recibe notificaciones instantáneas cuando los parámetros de tus cultivos salgan de su rango óptimo.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-green-600">
                                        <i data-lucide="area-chart" class="w-6 h-6 text-white"></i>
                                    </div>
                                    Histórico de datos
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Analiza el crecimiento de tus cultivos con gráficos y reportes    semanales.</dd>
                            </div>
                            <div class="relative pl-16">
                                <dt class="text-base font-semibold leading-7 text-gray-900">
                                    <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-green-600">
                                        <i data-lucide="database" class="w-6 h-6 text-white"></i>
                                    </div>
                                    Gestión de catálogos
                                </dt>
                                <dd class="mt-2 text-base leading-7 text-gray-600">Administra fácilmente tu catálogo de cultivos, tipos, estados de siembra y más, todo desde un solo lugar.</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-green-700">
                <div class="text-center py-16 px-6 sm:py-20 lg:px-8">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        <span class="block">¿Listo para comenzar?</span>
                        <span class="block">Regístrate hoy mismo.</span>
                    </h2>
                    <p class="mt-4 text-lg leading-6 text-green-200">
                        Optimiza el crecimiento de tus plantas con nuestra tecnología.
                    </p>
                    <a href="{{ route('register') }}" class="mt-8 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-white px-5 py-3 text-base font-medium text-green-600 hover:bg-green-50 sm:w-auto">
                        Crear cuenta gratis
                    </a>
                </div>
            </div>
        <script>
            lucide.createIcons();
        </script>
    </body>
</html>