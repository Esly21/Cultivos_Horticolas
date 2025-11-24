<x-app-layout>
    {{-- Estilos especiales solo para la impresión --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printable-area, #printable-area * {
                visibility: visible;
            }
            #printable-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>

    <div class="p-6 lg:p-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Reportes y Bitácoras</h1>
                <p class="text-gray-500 mt-1">Documenta y analiza el progreso de tus cultivos.</p>
            </div>
            <button onclick="window.print()" class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 font-semibold">
                <i data-lucide="download" class="w-5 h-5"></i>
                Descargar Reportes
            </button>
        </div>

        <div id="printable-area">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center gap-4">
                    <i data-lucide="file-text" class="w-8 h-8 text-blue-500"></i>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
                        <p class="text-sm text-gray-600">Total Reportes</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center gap-4">
                    <i data-lucide="calendar-check" class="w-8 h-8 text-green-500"></i>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['thisWeek'] }}</p>
                        <p class="text-sm text-gray-600">Esta Semana</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center gap-4">
                    <i data-lucide="thermometer" class="w-8 h-8 text-red-500"></i>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['avgTemp'], 1) }}°C</p>
                        <p class="text-sm text-gray-600">Temp. Promedio</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center gap-4">
                    <i data-lucide="droplets" class="w-8 h-8 text-blue-500"></i>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['avgHumidity'], 1) }}%</p>
                        <p class="text-sm text-gray-600">Humedad Promedio</p>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('reportes.index') }}" class="mb-6">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar en observaciones..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>
            </form>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($bitacoras as $bitacora)
                    <x-reporte-card :bitacora="$bitacora" />
                @empty
                    <div class="lg:col-span-2 text-center text-gray-500 py-16 bg-white rounded-lg shadow-sm border">
                        <i data-lucide="file-x" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                        <h3 class="font-semibold text-lg text-gray-700">No hay reportes registrados</h3>
                        <p class="text-sm">Comienza documentando el progreso de tus cultivos.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-8 print-hidden">
            {{ $bitacoras->links() }}
        </div>
    </div>
</x-app-layout>