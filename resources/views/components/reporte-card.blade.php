@props(['bitacora'])

<div class="bg-white p-6 rounded-lg shadow-sm border">
    <div class="flex justify-between items-start mb-3">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <i data-lucide="file-text" class="w-5 h-5 text-blue-600"></i>
                <h3 class="font-semibold text-gray-800">
                    Reporte de Siembra #{{ $bitacora->siembra->id ?? 'N/A' }}
                </h3>
            </div>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>{{ $bitacora->fecha_seguimiento->format('d/m/Y') }}</span>
            </div>
        </div>
        {{-- Aquí puedes añadir lógica para las insignias --}}
        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-100 text-blue-800">
            Seguimiento Semanal
        </span>
    </div>

    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
        {{ $bitacora->observaciones }}
    </p>

    <div class="flex items-center gap-6 text-sm">
        <div class="flex items-center gap-2 text-red-600 font-medium">
            <i data-lucide="thermometer" class="w-4 h-4"></i>
            <span>{{ number_format($bitacora->temperatura_actual, 1) }}°C</span>
        </div>
        <div class="flex items-center gap-2 text-blue-600 font-medium">
            <i data-lucide="droplets" class="w-4 h-4"></i>
            <span>{{ number_format($bitacora->humedad_actual, 1) }}%</span>
        </div>
    </div>
</div>