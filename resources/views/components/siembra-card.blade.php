@props(['siembra'])

<div class="bg-white p-6 rounded-lg shadow-sm border transition-all hover:shadow-md hover:-translate-y-1">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h3 class="font-semibold text-gray-800 mb-1">
                Siembra de {{ $siembra->cultivo->nombre_comun ?? 'Cultivo Desconocido' }}
            </h3>
            <div class="flex items-center gap-2 text-sm text-gray-500">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>{{ $siembra->fecha_inicio->format('d/m/Y') }}</span>
            </div>
        </div>
        @if($siembra->estadoSiembra)
            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $siembra->estadoSiembra->id == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                {{ $siembra->estadoSiembra->estado }}
            </span>
        @endif
    </div>

    @if($siembra->notas)
        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
            {{ $siembra->notas }}
        </p>
    @endif

    @if($siembra->inversion > 0)
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
            <i data-lucide="dollar-sign" class="w-4 h-4"></i>
            <span>Inversión: ${{ number_format($siembra->inversion, 2) }}</span>
        </div>
    @endif

    <div class="flex justify-end gap-2 border-t pt-4">
        
        {{-- BOTÓN EDITAR (VUELVE A USAR ALPINE.JS) --}}
        <button 
            type="button"
           @click.prevent="editingSiembra = {{ $siembra->toJson() }}; showEditModal = true"
            class="inline-flex items-center justify-center gap-1 px-3 py-1.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
            <i data-lucide="edit" class="w-4 h-4"></i>
            Editar
        </button>

        <form action="{{ route('siembras.destroy', $siembra) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta siembra?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center justify-center gap-1 px-3 py-1.5 text-sm font-semibold text-red-600 bg-red-50 border border-red-200 rounded-md shadow-sm hover:bg-red-100">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
                Eliminar
            </button>
        </form>
    </div>
</div>