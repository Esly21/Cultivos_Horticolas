<x-app-layout>
    <div class="p-6 space-y-6">

        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">
                Histórico de Evaluaciones
            </h1>

            <a href="{{ route('evaluaciones.index') }}"
               class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200">
                Volver
            </a>
        </div>

        <div class="bg-white rounded-lg shadow border overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3">Cultivo</th>
                        <th class="px-4 py-3">Siembras</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($evaluaciones as $e)
                        <tr>
                            <td class="px-4 py-2 font-semibold">
                                {{ $e->nombre }}
                            </td>

                            <td class="px-4 py-2 text-center">
                                {{ $e->cultivo->nombre_comun ?? '—' }}
                            </td>

                            <td class="px-4 py-2 text-center">
                                {{ count($e->resultado['detalle'] ?? []) }}
                            </td>

                            <td class="px-4 py-2 text-center text-gray-500">
                                {{ $e->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-4 py-2 text-center">
                                <a href="#"
                                   class="text-green-600 font-semibold hover:underline">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                No hay evaluaciones guardadas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            {{ $evaluaciones->links() }}
        </div>

    </div>
</x-app-layout>
