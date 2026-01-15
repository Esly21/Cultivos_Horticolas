<x-app-layout>
    {{-- 1. Se actualiza x-data para controlar AMBOS modales --}}
    <div class="p-6 lg:p-8" 
         x-data="{ 
            showModal: false, 
            showEditModal: false, 
            editingSiembra: {} 
         }"
         @open-edit-modal.window="editingSiembra = $event.detail; showEditModal = true">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de Siembras</h1>
                <p class="text-gray-500 mt-1">Controla el ciclo completo de tus siembras.</p>
            </div>
            <button @click="showModal = true" class="mt-4 md:mt-0 inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-semibold">
                <i data-lucide="plus" class="w-5 h-5"></i>
                Nueva Siembra
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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($siembras as $siembra)
                <x-siembra-card :siembra="$siembra" />
            @empty
                <div class="col-span-full text-center text-gray-500 py-10 bg-white rounded-lg shadow-sm border">
                    <i data-lucide="leaf" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                    <h3 class="font-semibold">No se encontraron siembras</h3>
                    <p class="text-sm">Comienza registrando tu primera siembra.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $siembras->links() }}
        </div>

        <div x-show="showModal" 
             x-transition
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
             style="display: none;"
             @keydown.escape.window="showModal = false"
             @close-modal.window="showModal = false">
            
            <div @click.outside="showModal = false" class="w-full max-w-lg bg-gray-100 rounded-lg shadow-xl">
                <div class="p-6 border-b bg-white rounded-t-lg flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Nueva Siembra</h2>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>
                <x-siembra-form :cultivos="$cultivos" :estados="$estados" />
            </div>
        </div>
         {{-- MODAL DE EDICIÓN (AHORA CON x-show, COMO EL DE CREAR) --}}
        <div x-show="showEditModal" 
     x-transition
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
     style="display: none;"
     @keydown.escape.window="showEditModal = false"
     @close-modal.window="showEditModal = false">
    
    <div @click.outside="showEditModal = false" class="w-full max-w-lg bg-gray-100 rounded-lg shadow-xl">
        <div class="p-6 border-b bg-white rounded-t-lg flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Editar Siembra</h2>
            <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        {{-- FORMULARIO INTEGRADO (SIN DEBUG, CON ACTION DINÁMICO) --}}
        <form x-bind:action="'{{ route('siembras.update', ':id') }}'.replace(':id', editingSiembra.id)" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6 bg-white p-8 rounded-lg shadow-inner">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit_cultivo_id" class="block font-medium text-sm text-gray-700">Cultivo Asociado *</label>
                        <select name="cultivo_id" id="edit_cultivo_id" x-model="editingSiembra.cultivo_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            <option value="">Seleccionar cultivo</option>
                            @foreach($cultivos as $cultivo)
                                <option value="{{ $cultivo->id }}">{{ $cultivo->nombre_comun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_estado_siembra_id" class="block font-medium text-sm text-gray-700">Estado *</label>
                        <select name="estado_siembra_id" id="edit_estado_siembra_id" x-model="editingSiembra.estado_siembra_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                            <option value="">Seleccionar estado</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_fecha_inicio" class="block font-medium text-sm text-gray-700">Fecha de Inicio *</label>
                        <input type="date" name="fecha_inicio" id="edit_fecha_inicio" :value="editingSiembra.fecha_inicio ? editingSiembra.fecha_inicio.split('T')[0] : ''" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                    </div>
                    <div>
                        <label for="edit_fecha_cosecha_estimada" class="block font-medium text-sm text-gray-700">Fecha de Cosecha (Estimada)</label>
                        <input type="date" name="fecha_cosecha_estimada" id="edit_fecha_cosecha_estimada" :value="editingSiembra.fecha_cosecha_estimada ? editingSiembra.fecha_cosecha_estimada.split('T')[0] : ''" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
                    </div>
                    <div class="md:col-span-2">
                        <label for="edit_inversion" class="block font-medium text-sm text-gray-700">Inversión ($)</label>
                        <input type="number" step="0.01" name="inversion" id="edit_inversion" x-model="editingSiembra.inversion" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="0">
                    </div>
                    <div class="md:col-span-2">
                        <label for="edit_notas" class="block font-medium text-sm text-gray-700">Notas Adicionales</label>
                        <textarea name="notas" id="edit_notas" x-model="editingSiembra.notas" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" placeholder="Detalles sobre la siembra, ubicación, etc."></textarea>
                    </div>
                </div>
            </div>
            <div class="flex justify-end gap-4 mt-6 bg-white p-4 rounded-lg shadow-inner">
                <button type="button" @click="$dispatch('close-modal')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold">Cancelar</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-semibold">Actualizar Siembra</button>
            </div>
        </form>
    </div>
</div>
    </div>
</x-app-layout>