@props(['cultivos', 'estados'])

<form action="{{ route('siembras.store') }}" method="POST">
    @csrf
    <div class="space-y-6 bg-white p-8 rounded-lg shadow-inner">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="cultivo_id" class="block font-medium text-sm text-gray-700">Cultivo Asociado *</label>
                <select name="cultivo_id" id="cultivo_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                    <option value="">Seleccionar cultivo</option>
                    @foreach($cultivos as $cultivo)
                        <option value="{{ $cultivo->id }}">{{ $cultivo->nombre_comun }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="estado_siembra_id" class="block font-medium text-sm text-gray-700">Estado *</label>
                <select name="estado_siembra_id" id="estado_siembra_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                    <option value="">Seleccionar estado</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->estado }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="fecha_inicio" class="block font-medium text-sm text-gray-700">Fecha de Inicio *</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
            </div>
            <div>
                <label for="fecha_cosecha_estimada" class="block font-medium text-sm text-gray-700">Fecha de Cosecha (Estimada)</label>
                <input type="date" name="fecha_cosecha_estimada" id="fecha_cosecha_estimada" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">
            </div>
            <div class="md:col-span-2">
                <label for="inversion" class="block font-medium text-sm text-gray-700">Inversión ($)</label>
                <input type="number" step="0.01" name="inversion" id="inversion" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="0">
            </div>
            <div class="md:col-span-2">
                <label for="notas" class="block font-medium text-sm text-gray-700">Notas Adicionales</label>
                <textarea name="notas" id="notas" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" placeholder="Detalles sobre la siembra, ubicación, etc."></textarea>
            </div>
        </div>
    </div>
    <div class="flex justify-end gap-4 mt-6 bg-white p-4 rounded-lg shadow-inner">
        <button type="button" @click="$dispatch('close-modal')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold">Cancelar</button>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-semibold">Crear Siembra</button>
    </div>
</form>