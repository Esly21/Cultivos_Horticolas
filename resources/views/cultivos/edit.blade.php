<x-app-layout>
    <div class="p-6 lg:p-8">
        {{-- Bloque para Mostrar Errores de Validación --}}
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
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="w-full max-w-4xl max-h-[90vh] overflow-y-auto bg-gray-100 rounded-lg shadow-xl">
        <div class="p-6 border-b bg-white rounded-t-lg flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Editar Cultivo: {{ $cultivo->nombre_comun }}</h2>
            <a href="{{ route('cultivos.index') }}" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </a>
        </div>
        <div class="p-6">
            <x-cultivo-edit-form :cultivo="$cultivo" :tiposCultivo="$tiposCultivo" :tiposSiembra="$tiposSiembra" :periodos="$periodos" :rangos="$rangos" :dimensiones="$dimensiones" />
        </div>
    </div>
</div>
    </div>
</div>
</x-app-layout>