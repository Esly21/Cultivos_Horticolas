@props(['icon', 'title', 'unit', 'color', 'status' => 'optimal'])

@php
    $colorClasses = [
        'red' => ['bg' => 'bg-red-50', 'text' => 'text-red-600'],
        'blue' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
        'yellow' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600'],
        'purple' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-600'],
    ][$color] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-600'];

    $statusClasses = [
        'optimal' => 'bg-green-100 text-green-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'critical' => 'bg-red-100 text-red-800',
    ][$status] ?? 'bg-gray-100 text-gray-800';

    $statusText = [
        'optimal' => 'Óptimo',
        'warning' => 'Advertencia',
        'critical' => 'Crítico',
    ][$status] ?? 'Desconocido';
@endphp

<div class="bg-white p-4 rounded-lg shadow-sm border {{ $colorClasses['bg'] }} border-opacity-50">
    <div class="flex items-center justify-between mb-2">
        <div class="p-2 rounded-lg {{ $colorClasses['bg'] }}">
            <i data-lucide="{{ $icon }}" class="w-6 h-6 {{ $colorClasses['text'] }}"></i>
        </div>
        <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $statusClasses }}">
            {{ $statusText }}
        </span>
    </div>
    
    {{-- CORRECCIÓN AQUÍ: Se usa $slot en lugar de $value --}}
    <p class="text-2xl font-bold text-gray-800">
        {{ $slot }}<span class="text-lg">{{ $unit }}</span>
    </p>

    <p class="text-sm text-gray-600">{{ $title }}</p>
</div>