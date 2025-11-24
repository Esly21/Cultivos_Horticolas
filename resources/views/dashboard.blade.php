<x-app-layout>
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Home Agrícola</h1>
            <p class="text-gray-500 mt-1">Bienvenido, {{ Auth::user()->name }}</p>
        </div>
        <div class="text-sm text-gray-500 flex items-center gap-2 mt-4 md:mt-0">
            <i data-lucide="calendar" class="w-4 h-4"></i>
            <span>{{ now()->locale('es')->translatedFormat('l, j \de F \de Y') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
    <x-stats-card 
        icon="leaf" 
        title="Siembras Activas" 
        :value="$stats['siembrasActivas']" 
        trend="En desarrollo" 
        color="green" 
    />
    <x-stats-card 
        icon="sprout" 
        title="Total Cultivos" 
        :value="$stats['totalCultivos']" 
        trend="Variedades" 
        color="emerald" 
    />
    <x-stats-card 
        icon="dollar-sign" 
        title="Inversión Total" 
        {{-- Se agregó el paréntesis de cierre aquí --}}
        :value="'$' . number_format($stats['inversionTotal'], 2)" 
        {{-- Se corrigió => por = aquí --}}
        trend="Capital invertido" 
        color="blue" 
    />
    <x-stats-card 
        icon="alert-triangle" 
        title="Alertas Pendientes" 
        :value="$stats['alertasPendientes']" 
        trend="Todo en orden" 
        :color="$stats['alertasPendientes'] > 0 ? 'yellow' : 'gray'" 
    />
    <x-stats-card 
        icon="bar-chart-3" 
        title="Total Siembras" 
        :value="$stats['totalSiembras']" 
        trend="Historial completo" 
        color="purple" 
    />
    <x-stats-card 
        icon="trending-up" 
        title="Ingresos Estimados" 
        {{-- También faltaba un paréntesis aquí --}}
        :value="'$' . number_format($stats['ingresosEstimados'], 2)" 
        trend="Proyección actual" 
        color="yellow" 
    />
</div>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border">
    <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
        <i data-lucide="leaf" class="text-green-600"></i>
        Siembras Recientes
    </h2>
    <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
        @forelse($siembrasRecientes as $siembra)
            @php
                // Lógica para determinar el estado de la cosecha
                $status = 'En desarrollo';
                $statusColor = 'bg-green-100 text-green-800'; // Verde por defecto
                $daysUntilHarvest = null;

                if ($siembra->fecha_cosecha_estimada) {
                    $harvestDate = \Carbon\Carbon::parse($siembra->fecha_cosecha_estimada);
                    $today = \Carbon\Carbon::today();
                    $daysUntilHarvest = $today->diffInDays($harvestDate, false); // false para obtener negativo si ya pasó

                    if ($daysUntilHarvest < 0) {
                        $status = 'Cosecha Atrasada';
                        $statusColor = 'bg-red-100 text-red-800'; // Rojo
                    } elseif ($daysUntilHarvest <= 7) {
                        $status = 'Próxima Cosecha';
                        $statusColor = 'bg-yellow-100 text-yellow-800'; // Amarillo
                    }
                }
            @endphp

            <div class="border rounded-lg p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
                {{-- Bloque para mostrar la imagen --}}
                <div class="flex-shrink-0">
                    @if($siembra->cultivo && $siembra->cultivo->imagen)
                        <img src="{{ asset('storage/' . $siembra->cultivo->imagen) }}" alt="{{ $siembra->cultivo->nombre_comun }}" class="w-16 h-16 object-cover rounded-lg shadow-sm">
                    @else
                        {{-- Placeholder si no hay imagen --}}
                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                            <i data-lucide="image-off" class="text-gray-400"></i>
                        </div>
                    @endif
                </div>
                {{-- Información de la siembra --}}
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-1">
                        <div>
                            <p class="font-semibold text-gray-800 truncate">{{ $siembra->cultivo->nombre_comun ?? 'Cultivo no especificado' }}</p>
                            <p class="text-xs text-gray-500 italic truncate">{{ $siembra->cultivo->nombre_cientifico ?? '' }}</p>
                        </div>
                         {{-- Insignia de Estado --}}
                         <span class="text-xs font-semibold px-2 py-1 rounded-full whitespace-nowrap {{ $statusColor }}">
                            {{ $status }}
                        </span>
                    </div>
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <div class="flex items-center gap-1">
                            <i data-lucide="calendar" class="w-3 h-3"></i>
                            <span>{{ $siembra->fecha_inicio->format('d/m/y') }}</span>
                        </div>
                        @if($siembra->inversion > 0)
                            <div class="flex items-center gap-1">
                                <i data-lucide="dollar-sign" class="w-3 h-3"></i>
                                <span>{{ number_format($siembra->inversion, 0) }}</span>
                            </div>
                        @endif
                    </div>
                    @if($siembra->fecha_cosecha_estimada)
                        <p class="text-xs text-gray-400 mt-2">Cosecha: {{ $siembra->fecha_cosecha_estimada->format('d/m/y') }}</p>
                    @endif
                </div>
                {{-- Botón Detalles (opcional) --}}
                {{-- <a href="#" class="ml-4 flex-shrink-0 inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                    <i data-lucide="external-link" class="w-3 h-3"></i>
                    Detalles
                </a> --}}
            </div>
        @empty
            <p class="text-gray-500">No hay siembras registradas.</p>
        @endforelse
    </div>
</div>
        <div class="space-y-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                 <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <i data-lucide="thermometer" class="text-blue-600"></i>
                    Monitoreo Ambiental
                </h2>
                {{-- Aquí iría el contenido de monitoreo --}}
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="text-orange-600"></i>
                    Alertas Recientes
                </h2>
                {{-- Aquí irían las alertas --}}
            </div>
        </div>
    </div>
</x-app-layout>