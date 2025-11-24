<x-app-layout>
    <div class="p-6 lg:p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Centro de Alertas</h1>
            <p class="text-gray-500 mt-1">Gestiona todas las notificaciones del sistema.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center gap-4">
                <i data-lucide="bell-ring" class="w-8 h-8 text-blue-500"></i>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['pendientes'] }}</p>
                    <p class="text-sm text-gray-600">Alertas Pendientes</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center gap-4">
                <i data-lucide="siren" class="w-8 h-8 text-red-500"></i>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['criticas'] }}</p>
                    <p class="text-sm text-gray-600">Críticas Activas</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center gap-4">
                <i data-lucide="alert-triangle" class="w-8 h-8 text-yellow-500"></i>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['advertencias'] }}</p>
                    <p class="text-sm text-gray-600">Advertencias Activas</p>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-sm border flex items-center gap-4">
                <i data-lucide="check-circle" class="w-8 h-8 text-green-500"></i>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['resueltas'] }}</p>
                    <p class="text-sm text-gray-600">Resueltas</p>
                </div>
            </div>
        </div>

        <form method="GET" action="{{ route('alertas.index') }}" class="mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por título o mensaje..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>
                <select name="severidad" onchange="this.form.submit()" class="border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="all">Todas las severidades</option>
                    <option value="critical" @selected(request('severidad') == 'critical')>Críticas</option>
                    <option value="warning" @selected(request('severidad') == 'warning')>Advertencias</option>
                    <option value="info" @selected(request('severidad') == 'info')>Informativas</option>
                </select>
                {{-- Filtro adicional de la imagen --}}
                <select name="estado_alerta" onchange="this.form.submit()" class="border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="pendientes">Pendientes</option>
                    <option value="resueltas">Resueltas</option>
                </select>
            </div>
        </form>

        <div class="space-y-4">
            @forelse($alertas as $alerta)
                <x-alerta-card :alerta="$alerta" />
            @empty
                {{-- Mensaje de "No hay alertas" actualizado --}}
                <div class="text-center text-gray-500 py-16 bg-white rounded-lg shadow-sm border">
                    <i data-lucide="bell-off" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                    <h3 class="font-semibold text-lg text-gray-700">No hay alertas</h3>
                    <p class="text-sm">Todo está en orden.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $alertas->links() }}
        </div>
    </div>
</x-app-layout>