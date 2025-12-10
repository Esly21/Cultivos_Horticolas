<x-app-layout>
    <div class="p-6 lg:p-8" x-data="{ showModal: false }">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Evaluación de Rendimientos</h1>
                <p class="text-gray-500">Analiza la productividad según el tipo de suelo y técnica.</p>
            </div>
            <button @click="showModal = true" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-semibold inline-flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                Nueva Evaluación
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">Cultivo / Siembra</th>
                        <th class="px-6 py-3">Suelo / Técnica</th>
                        <th class="px-6 py-3">Ciclo (Días)</th>
                        <th class="px-6 py-3">Rendimiento</th>
                        <th class="px-6 py-3">Calidad</th>
                        <th class="px-6 py-3">Fecha Cosecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluaciones as $eval)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $eval->siembra->cultivo->nombre_comun }}</div>
                                <div class="text-xs">#{{ substr($eval->siembra_id, -6) }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                               {{ $eval->tipoSuelo->nombre }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $eval->dias_transcurridos }} días
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold">{{ $eval->cantidad_cosechada }} Kg</div>
                                <div class="text-xs text-gray-500">Tamaño: {{ $eval->tamano_promedio }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $color = match($eval->calidad->nombre) {
                                        'Buena'   => 'text-green-600',   // Verde
                                        'Regular' => 'text-yellow-600',  // Amarillo
                                        'Mala'    => 'text-red-600',     // Rojo
                                        default   => 'text-gray-600',
    };
                                @endphp
                                <span class="font-bold {{ $color }}">{{ $eval->calidad->nombre ?? 'Sin definir' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                {{ $eval->fecha_cosecha_real->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No hay evaluaciones registradas aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $evaluaciones->links() }}
        </div>

        <div x-show="showModal" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" style="display: none;">
            <div @click.outside="showModal = false" class="bg-white rounded-lg shadow-xl w-full max-w-2xl overflow-hidden">
                <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Registrar Resultados de Cosecha</h2>
                    <button @click="showModal = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>
                
                <form action="{{ route('evaluaciones.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Seleccionar Siembra a Evaluar
                            </label>
                            <select name="siembra_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                <option value="">-- Selecciona una siembra pendiente --</option>
                                @foreach($siembrasPendientes as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->cultivo->nombre_comun }} (Inició: {{ $s->fecha_inicio->format('d/m/Y') }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Tipo de suelo -->
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo de Suelo / Técnica
                            </label>
                            <select name="tipo_suelo_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                <option value="">Seleccionar...</option>
                                @foreach($tiposSuelo as $suelo)
                                <option value="{{ $suelo->id }}">{{ $suelo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Fecha -->
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha Real de Cosecha
                            </label>
                            <input type="date" name="fecha_cosecha_real" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                        </div>
                        <!-- Cantidad -->
                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Cantidad Obtenida (Kg)
                            </label>
                            <input type="number" name="cantidad_cosechada" step="0.01" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="0.00" required>
                        </div>

                        <!-- Calidad -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Calidad del Producto
                            </label>
                            <select name="calidad_id" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                <option value="">Seleccionar...</option>
                                @foreach($calidades as $calidad)
                                    <option value="{{ $calidad->id }}">{{ $calidad->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tamaño -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tamaño Promedio
                            </label>
                            <select name="tamano_promedio" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                <option value="Grande">Grande</option>
                                <option value="Mediano">Mediano</option>
                                <option value="Pequeño">Pequeño</option>
                                <option value="Mixto">Mixto</option>
                            </select>
                        </div>

                        <!-- Tipo de cosecha -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo de Cosecha
                            </label>
                            <select name="tipo_cosecha" class="w-full border-gray-300 rounded-lg shadow-sm" required>
                                <option value="Manual">Manual</option>
                                <option value="Mecanizada">Mecanizada</option>
                                <option value="Mixta">Mixta</option>
                            </select>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Observaciones
                            </label>
                            <textarea name="observaciones" 
                                    class="w-full border-gray-300 rounded-lg shadow-sm"
                                    rows="3"
                                    placeholder="Notas adicionales..."></textarea>
                        </div>

                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button type="button" @click="showModal = false" 
                                class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                            Cancelar
                        </button>

                        <button type="submit"class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">
                            Guardar Evaluación
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>