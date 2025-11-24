@props(['active', 'icon', 'title', 'description'])

@php
// Define las clases de estilo según si el enlace está activo o no
$classes = ($active ?? false)
            ? 'flex items-start gap-3 px-4 py-3 rounded-lg bg-green-50 text-green-700' // Estilo activo
            : 'flex items-start gap-3 px-4 py-3 rounded-lg text-gray-600 hover:bg-gray-100'; // Estilo normal

$iconClasses = ($active ?? false) ? 'text-green-600' : 'text-gray-500';
$titleClasses = ($active ?? false) ? 'text-green-800 font-semibold' : 'text-gray-700 font-medium';
$descriptionClasses = ($active ?? false) ? 'text-green-700' : 'text-gray-500';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{-- Icono a la izquierda --}}
    <i data-lucide="{{ $icon }}" class="w-5 h-5 mt-0.5 flex-shrink-0 {{ $iconClasses }}"></i>
    
    {{-- Contenedor para las dos líneas de texto --}}
    <div class="flex-1">
        <span class="{{ $titleClasses }}">{{ $title }}</span>
        <p class="text-xs {{ $descriptionClasses }}">{{ $description }}</p>
    </div>
    
    {{-- Espacio para contenido extra, como la insignia de notificación --}}
    {{ $slot }}
</a>