@props(['active', 'icon', 'title', 'description'])

@php
    // Clases base comunes para todos los enlaces
    $baseClasses = 'flex items-start gap-3 px-4 py-3 rounded-lg transition-all duration-200 group';

    if ($active) {
        // ESTILO ACTIVO (SELECCIONADO)
        // Usa la clase personalizada .nav-link-active para el borde brillante
        // y ajusta el color del texto.
        $classes = $baseClasses . ' nav-link-active text-green-800';
        
        // Colores para elementos internos cuando está ACTIVO
        $iconClasses = 'text-green-700 relative z-10';
        $titleClasses = 'font-bold relative z-10';
        $descClasses = 'text-green-600 relative z-10';
    } else {
        // ESTILO INACTIVO (NORMAL)
        $classes = $baseClasses . ' text-gray-600 hover:bg-green-50 hover:text-green-700 border border-transparent';
        
        // Colores para elementos internos cuando está INACTIVO
        $iconClasses = 'text-gray-500 group-hover:text-green-600';
        $titleClasses = 'font-medium';
        $descClasses = 'text-gray-400 group-hover:text-green-500';
    }
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    
    {{-- Icono --}}
    @if($icon)
        <i data-lucide="{{ $icon }}" class="w-5 h-5 mt-0.5 flex-shrink-0 {{ $iconClasses }}"></i>
    @endif
    
    {{-- Textos --}}
    <div class="flex-1 text-left relative z-10">
        <span class="block text-sm {{ $titleClasses }}">
            {{ $title ?? $slot }}
        </span>
        @if(isset($description))
            <p class="text-xs {{ $descClasses }} leading-tight mt-0.5">
                {{ $description }}
            </p>
        @endif
    </div>
    
    {{-- Slot para extras --}}
    <div class="relative z-10">
        {{ $slot }}
    </div>
</a>