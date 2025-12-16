<x-app-layout>
    <div class="p-6 space-y-6" x-data="{ showModal: false }">
        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Evaluación de Rendimientos</h1>
                <p class="text-gray-600">Analiza la productividad según el tipo de suelo y técnica.</p>
            </div>
            <button @click="showModal = true" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center shadow-sm transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nueva Evaluación
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <div class="bg-white p-6 rounded-xl border shadow-sm flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Evaluaciones</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalEvaluaciones ?? 0 }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Registradas</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl border shadow-sm flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Rendimiento Promedio</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($promedioRendimiento ?? 0, 1) }} <span class="text-lg font-normal text-gray-500">kg</span></h3>
                    <p class="text-sm text-gray-500 mt-1">Por cosecha</p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border shadow-sm flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Calidad "Buena"</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $mejorCalidadCount ?? 0 }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Cosechas</p>
                </div>
                <div class="p-3 bg-yellow-50 rounded-lg text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border shadow-sm flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500">Ingresos Totales</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($totalIngresos, 2) }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Acumulado</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            
        </div>
        <div class="flex justify-between items-center mt-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Lista de Evaluaciones</h2>
                <p class="text-gray-600">Revisa y gestiona las evaluaciones de rendimiento registradas.</p>
    </div>
            
        </div>

        <div class="relative">
            <form method="GET" action="{{ route('evaluaciones.index') }}">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Buscar por cultivo o tipo de suelo..."
                    class="pl-10 w-full rounded-md border border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent shadow-sm"
                />
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cultivo / Siembra</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Suelo / Técnica</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rendimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Calidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ingresos</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($evaluaciones as $eval)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $eval->siembra->cultivo->nombre_comun ?? 'Cultivo eliminado' }}</div>
                            <div class="text-xs text-gray-500">#{{ substr($eval->siembra_id, -6) }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $eval->tipoSuelo->nombre ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-sm">{{ number_format($eval->cantidad_cosechada, 2) }} Kg</div>
                            <div class="text-xs text-gray-500">Ciclo: {{ $eval->dias_transcurridos }} días</div>
                        </td>
                        <td class="px-6 py-4">
                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ ($eval->calidad->nombre ?? '') === 'Buena' ? 'bg-green-100 text-green-800' : 
                                   (($eval->calidad->nombre ?? '') === 'Regular' ? 'bg-yellow-100 text-yellow-800' : 
                                   (($eval->calidad->nombre ?? '') === 'Mala' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ $eval->calidad->nombre ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $eval->fecha_cosecha_real->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <form action="{{ route('evaluaciones.destroy', $eval->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta evaluación?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Eliminar">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                            ${{ number_format($eval->ingresos_estimados, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No hay evaluaciones registradas. ¡Crea una nueva!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $evaluaciones->links() }}
        </div>

        <div x-show="showModal" 
             style="display: none;" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div @click.outside="showModal = false" 
                 class="bg-white rounded-lg shadow-xl w-full max-w-2xl overflow-hidden m-4 transform transition-all max-h-[90vh] overflow-y-auto"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50 sticky top-0 z-10">
                    <h3 class="text-lg font-bold text-gray-900">Registrar Resultados de Cosecha</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Cerrar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form action="{{ route('evaluaciones.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Seleccionar Siembra a Evaluar *
                            </label>
                            <select name="siembra_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500" required>
                                <option value="">Selecciona una siembra pendiente </option>
                                @foreach($siembrasPendientes as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->cultivo->nombre_comun ?? 'Cultivo' }} (Inició: {{ $s->fecha_inicio ? \Carbon\Carbon::parse($s->fecha_inicio)->format('d/m/Y') : 'Sin fecha' }})
                                </option>
                                @endforeach
                            </select>
                            @if($siembrasPendientes->isEmpty())
                                <p class="text-xs text-red-500 mt-1">No tienes siembras pendientes de evaluar.</p>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo de Suelo / Técnica *
                            </label>
                            <select name="tipo_suelo_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500" required>
                                <option value="">Seleccionar...</option>
                                @foreach($tiposSuelo as $suelo)
                                <option value="{{ $suelo->id }}">{{ $suelo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha Real de Cosecha *
                            </label>
                            <input type="date" name="fecha_cosecha_real" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Cantidad Obtenida (Kg) *
                            </label>
                            <input type="number" name="cantidad_cosechada" step="0.01" min="0" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="0.00" required>
                        </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ingresos Estimados ($) *</label>
                                <div class="relative rounded-md shadow-sm">

                            </div>
                                <input type="number" name="ingresos_estimados" step="0.01" min="0" 
                                    class="block w-full rounded-md border-gray-300 pl-7 pr-3 focus:border-green-500 focus:ring-green-500 sm:text-sm" 
                                    placeholder="0.00" required>
                            </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Calidad del Producto *
                            </label>
                            <select name="calidad_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500" required>
                                <option value="">Seleccionar...</option>
                                @foreach($calidades as $calidad)
                                    <option value="{{ $calidad->id }}">{{ $calidad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tamaño Promedio *
                            </label>
                            <select name="tamano_promedio" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500" required>
                                <option value="Grande">Grande</option>
                                <option value="Mediano">Mediano</option>
                                <option value="Pequeño">Pequeño</option>
                                <option value="Mixto">Mixto</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo de Cosecha *
                            </label>
                            <select name="tipo_cosecha" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500" required>
                                <option value="Manual">Manual</option>
                                <option value="Mecanizada">Mecanizada</option>
                                <option value="Mixta">Mixta</option>
                            </select>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Observaciones
                            </label>
                            <textarea name="observaciones" 
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500"
                                    rows="3"
                                    placeholder="Notas adicionales sobre el rendimiento..."></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t bg-gray-50 -mx-6 -mb-6 p-6 mt-6">
                        <button type="button" @click="showModal = false" 
                                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 font-medium shadow-sm transition-colors">
                            Cancelar
                        </button>

                        <button type="submit" class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 font-medium shadow-sm transition-colors">
                            Guardar Evaluación
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>