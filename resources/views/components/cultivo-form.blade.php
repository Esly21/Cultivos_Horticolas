@props(['tiposCultivo'])
<form action="{{ route('cultivos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div class="bg-white p-8 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Información Básica</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nombre_cientifico" class="block font-medium text-sm text-gray-700">Nombre Científico *</label>
                <input type="text" name="nombre_cientifico" id="nombre_cientifico" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" placeholder="Ej: Solanum lycopersicum" required>
            </div>
            <div>
                <label for="nombre_comun" class="block font-medium text-sm text-gray-700">Nombre Común *</label>
                <input type="text" name="nombre_comun" id="nombre_comun" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" placeholder="Ej: Tomate" required>
            </div>
        </div>
        <div class="mt-4">
            <label for="descripcion" class="block font-medium text-sm text-gray-700">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" placeholder="Descripción del cultivo..."></textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            <div>
                <label for="id_tipo_cultivo" class="block font-medium text-sm text-gray-700">Tipo de Cultivo *</label>
                <select name="id_tipo_cultivo" id="id_tipo_cultivo" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                    <option value="">Seleccionar tipo</option>
                    @foreach($tiposCultivo as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="imagen" class="block font-medium text-sm text-gray-700">Imagen del Cultivo</label>
                <input type="file" name="imagen" id="imagen" class="block mt-1 w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-green-50 file:text-green-700
                    hover:file:bg-green-100">
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Parámetros de Cultivo</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="tiempo_cosecha" class="block font-medium text-sm text-gray-700">Tiempo de Cosecha (días)</label>
                <input type="number" name="tiempo_cosecha" id="tiempo_cosecha" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="0">
            </div>
            <div>
                <label for="tiempo_riego" class="block font-medium text-sm text-gray-700">Tiempo de Riego (días)</label>
                <input type="number" name="tiempo_riego" id="tiempo_riego" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="0">
            </div>
            <div>
                <label for="profundidad_semilla" class="block font-medium text-sm text-gray-700">Profundidad de Siembra (cm)</label>
                <input type="number" step="0.1" name="profundidad_semilla" id="profundidad_semilla" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="0">
            </div>
            <div>
                <label for="cantidad_de_plantas" class="block font-medium text-sm text-gray-700">Cantidad de Plantas</label>
                <input type="number" name="cantidad_de_plantas" id="cantidad_de_plantas" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="0">
            </div>
            <div>
                <label for="costo" class="block font-medium text-sm text-gray-700">Costo Estimado</label>
                <input type="number" step="0.01" name="costo" id="costo" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="0">
            </div>
            <div class="flex items-center pt-6">
                <input type="checkbox" name="iluminacion" id="iluminacion" value="1" class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                <label for="iluminacion" class="ml-2 block text-sm text-gray-900">Requiere Iluminación Especial</label>
            </div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubicación</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="sector" class="block font-medium text-sm text-gray-700">Sector</label>
                <input type="text" name="sector" id="sector" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" placeholder="Ej: Sector A">
            </div>
            <div>
                <label for="parcela" class="block font-medium text-sm text-gray-700">Parcela</label>
                <input type="text" name="parcela" id="parcela" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" placeholder="Ej: Parcela 1">
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-4 mt-6 bg-white p-4 rounded-lg">
        <button type="button" @click="$dispatch('close-modal')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-semibold">Cancelar</button>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-semibold">Crear Cultivo</button>
    </div>
</form>