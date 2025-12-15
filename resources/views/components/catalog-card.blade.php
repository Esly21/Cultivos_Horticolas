@props(['title', 'items', 'routeStore', 'routeDestroy', 'displayKey' => 'nombre', 'fieldName' => 'nombre' ])
@php 
    $primaryKey = $attributes->get('primary-key', 'id');
@endphp

<div class="bg-white p-6 rounded-lg shadow-sm border">
    <h2 class="text-xl font-bold mb-4 text-gray-800">{{ $title }}</h2>
    
    <form action="{{ route($routeStore) }}" method="POST" class="flex gap-2 mb-4">
        @csrf
        <input type="text" name="{{ $fieldName }}" placeholder="Nuevo elemento..." class="flex-1 border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500" required>
        <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-lg font-semibold hover:bg-green-700 transition-colors">
            <i data-lucide="plus" class="w-5 h-5"></i>
        </button>
    </form>

    <div class="space-y-2 max-h-48 overflow-y-auto pr-1 custom-scrollbar">
        @forelse($items as $item)
            <div class="flex justify-between items-center p-3 border rounded-lg bg-gray-50 hover:bg-white transition-colors">
                <span class="font-medium text-gray-700">{{ $item->$displayKey }}</span>
                <form action="{{ route($routeDestroy, $item->{$primaryKey}) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este elemento?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        @empty
            <p class="text-center text-gray-400 text-sm py-4">No hay registros.</p>
        @endforelse
    </div>
</div>