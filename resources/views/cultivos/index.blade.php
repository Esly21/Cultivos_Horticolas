<x-app-layout>
    <div class="p-6 lg:p-8" x-data="{ showModal: false }">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de Cultivos</h1>
                <p class="text-gray-500 mt-1">Administra el catálogo de cultivos disponibles</p>
            </div>
            <button @click="showModal = true" class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-semibold">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Nuevo Cultivo
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md" role="alert">
        <p class="font-bold">Por favor, corrige los siguientes errores:</p>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($cultivos as $cultivo)
                <x-cultivo-card :cultivo="$cultivo" />
            @empty
                <div class="col-span-full text-center text-gray-500 py-10 bg-white rounded-lg shadow-sm border">
                    <p class="font-semibold">No se encontraron cultivos.</p>
                    <p class="text-sm">¡Crea el primero para empezar!</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $cultivos->links() }}
        </div>

        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
             style="display: none;"
             @keydown.escape.window="showModal = false"
             @close-modal.window="showModal = false">
            
            <div @click.outside="showModal = false" class="w-full max-w-4xl max-h-[90vh] overflow-y-auto bg-gray-100 rounded-lg shadow-xl">
                <div class="p-6 border-b bg-white rounded-t-lg">
                    <h2 class="text-2xl font-bold text-gray-800">Nuevo Cultivo</h2>
                </div>
                <div class="p-6">
                    <x-cultivo-form  :tiposCultivo="$tiposCultivo" :tiposSiembra="$tiposSiembra" :periodos="$periodos" :rangos="$rangos" :dimensiones="$dimensiones"/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>