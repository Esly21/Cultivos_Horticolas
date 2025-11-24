@props(['icon', 'title', 'value', 'trend', 'color'])

@php
    // Clases de Tailwind para el icono (fondo claro)
    $colorClasses = [
        'green' => 'bg-green-100 text-green-700',
        'emerald' => 'bg-emerald-100 text-emerald-700',
        'blue' => 'bg-blue-100 text-blue-700',
        'gray' => 'bg-gray-200 text-gray-700',
        'purple' => 'bg-purple-100 text-purple-700',
        'yellow' => 'bg-yellow-100 text-yellow-700',
        'red' => 'bg-red-100 text-red-700',
    ][$color] ?? 'bg-gray-100 text-gray-700';

    // Colores HEX (fuertes) para la animación de hover
    $colorHex = [
        'green' => '#07c082ff', // green-500
        'emerald' => '#059669', // emerald-600
        'blue' => '#3B82F6', // blue-500
        'gray' => '#6B7280', // gray-500
        'purple' => '#8B5CF6', // purple-500
        'yellow' => '#F59E0B', // yellow-500
        'red' => '#EF4444', // red-500
    ][$color] ?? '#6B7280'; // Default to gray-500
@endphp

{{-- Se define la variable CSS '--card-color' en la etiqueta principal --}}
<a href="#" class="stats-card bg-white p-4 rounded-lg shadow-sm border transition-all" 
   style="--card-color: {{ $colorHex }};">
    
    {{-- EL DIV .go-corner HA SIDO ELIMINADO --}}
    
    <div class="flex justify-between items-center mb-1">
        <h3>{{ $title }}</h3>
        <div class="icon-container p-2 rounded-lg {{ $colorClasses }} transition-opacity">
            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
        </div>
    </div>
    <p class="value">{{ $value }}</p>
    <p class="small">{{ $trend }}</p>
</a>