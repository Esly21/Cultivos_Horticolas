@props(['siembra', 'tiposSuelo'])

<form action="{{ route('evaluaciones.store') }}" method="POST" class="space-y-6">
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-4">
            <p class="font-bold">Algo salió mal:</p>
            <ul class="mt-1 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @csrf
    <input type="hidden" name="siembra_id" value="{{ $siembra->id }}">

    <div class="bg-white p-6 rounded-lg border shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Datos de Cosecha</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block font-medium text-sm text-gray-700">Fecha de Cosecha Real</label>
                <input type="date" name="fecha_cosecha_real" required
                       class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                <p class="text-xs text-gray-500 mt-1">Se calcularán los días desde el {{ $siembra->fecha_inicio->format('d/m/Y') }}</p>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Tipo de Suelo</label>
                <select name="tipo_suelo_id" required class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                    <option value="">Seleccionar...</option>
                    @foreach($tiposSuelo as $suelo)
                        <option value="{{ $suelo->id }}">{{ $suelo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Cantidad Cosechada (Kg)</label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="number" step="0.01" name="cantidad_cosechada" required
                           class="block w-full rounded-md border-gray-300 pl-3 pr-12 focus:border-green-500 focus:ring focus:ring-green-200" placeholder="0.00">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <span class="text-gray-500 sm:text-sm">kg</span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Calidad del Producto</label>
                <select name="calidad" required class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                    <option value="">Seleccionar...</option>
                    <option value="Excelente">Excelente (Premium)</option>
                    <option value="Buena">Buena (Estándar)</option>
                    <option value="Regular">Regular (Segunda)</option>
                    <option value="Mala">Mala (Descarte)</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Tamaño Promedio</label>
                <select name="tamano_promedio" required class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                    <option value="">Seleccionar...</option>
                    <option value="Grande">Grande</option>
                    <option value="Mediano">Mediano</option>
                    <option value="Pequeño">Pequeño</option>
                    <option value="Mixto">Mixto</option>
                </select>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Tipo de Cosecha</label>
                <select name="tipo_cosecha" required class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200">
                    <option value="Manual">Manual</option>
                    <option value="Mecanizada">Mecanizada</option>
                    <option value="Mixta">Mixta</option>
                </select>
            </div>
        </div>

        <div class="mt-4">
            <label class="block font-medium text-sm text-gray-700">Observaciones Adicionales</label>
            <textarea name="observaciones" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200"></textarea>
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <button type="button" @click="showEvaluacionModal = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300">Cancelar</button>
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700">Guardar Evaluación</button>
    </div>
</form>