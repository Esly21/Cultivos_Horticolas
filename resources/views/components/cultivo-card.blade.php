@props(['cultivo'])

<div class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300 border">
    {{-- LÓGICA PARA MOSTRAR LA IMAGEN SUBIDA --}}
    @if($cultivo->imagen)
        {{-- Si el cultivo tiene una imagen, la muestra desde la carpeta de almacenamiento --}}
        <img src="{{ asset('storage/' . $cultivo->imagen) }}" alt="Imagen de {{ $cultivo->nombre_comun }}" class="w-full h-40 object-cover">
    @else
        {{-- Si no tiene imagen, muestra una por defecto --}}
        <img src="https://via.placeholder.com/400x300.png/EBF4EC?text=Cultivo" alt="Imagen no disponible" class="w-full h-40 object-cover">
    @endif
    
    <div class="p-4">
        <div class="flex justify-between items-start">
            <div class="flex-1 min-w-0">
                <h3 class="font-bold text-lg text-gray-800 truncate" title="{{ $cultivo->nombre_comun }}">{{ $cultivo->nombre_comun }}</h3>
                <p class="text-sm text-gray-500 italic truncate" title="{{ $cultivo->nombre_cientifico }}">{{ $cultivo->nombre_cientifico }}</p>
            </div>
            <div class="flex items-center space-x-1 flex-shrink-0 ml-2">
                <a href="{{ route('cultivos.edit', $cultivo) }}" class="p-1 text-blue-500 rounded-full hover:bg-blue-100 hover:text-blue-700" title="Editar">
                    <i data-lucide="file-pen-line" class="w-4 h-4"></i>
                </a>
                <form action="{{ route('cultivos.destroy', $cultivo) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este cultivo?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-1 text-red-500 rounded-full hover:bg-red-100 hover:text-red-700" title="Eliminar">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>

        <p class="text-xs text-gray-600 mt-2 h-8 line-clamp-2">
            {{ $cultivo->descripcion ?? 'Sin descripción.' }}
        </p>
        
        <div class="mt-4 pt-4 border-t text-sm text-gray-700 space-y-2">
            <div class="flex items-center gap-2">
                <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i>
                <span>Cosecha: {{ $cultivo->tiempo_cosecha ?? 'N/A' }} días</span>
            </div>
            <div class="flex items-center gap-2">
                <i data-lucide="droplets" class="w-4 h-4 text-gray-400"></i>
                <span>Riego: c/{{ $cultivo->tiempo_riego ?? 'N/A' }} días</span>
            </div>
        </div>
    </div>
</div>