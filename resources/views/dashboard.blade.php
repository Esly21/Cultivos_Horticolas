<x-app-layout>
    {{-- Cabecera y Tarjetas de Estadísticas (se mantienen igual) --}}
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
        <x-stats-card icon="leaf" title="Siembras Activas" :value="$stats['siembrasActivas']" trend="En desarrollo" color="green" />
        <x-stats-card icon="sprout" title="Total Cultivos" :value="$stats['totalCultivos']" trend="Variedades" color="emerald" />
        <x-stats-card icon="dollar-sign" title="Inversión Total" :value="'$' . number_format($stats['inversionTotal'], 2)" trend="Capital invertido" color="blue" />
        <x-stats-card icon="alert-triangle" title="Alertas Pendientes" :value="$stats['alertasPendientes']" trend="Todo en orden" :color="$stats['alertasPendientes'] > 0 ? 'yellow' : 'gray'" />
        <x-stats-card icon="bar-chart-3" title="Total Siembras" :value="$stats['totalSiembras']" trend="Historial completo" color="purple" />
        <x-stats-card icon="trending-up" title="Ingresos Estimados" :value="'$' . number_format($stats['ingresosEstimados'], 2)" trend="Proyección actual" color="yellow" />
    </div>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="grid lg:grid-cols-3 gap-8">
        
        {{-- COLUMNA IZQUIERDA (2/3): SIEMBRAS --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Tarjeta de Siembras Recientes --}}
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <i data-lucide="leaf" class="text-green-600"></i>
                    Siembras Recientes
                </h2>
                <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                    @forelse($siembrasRecientes as $siembra)
                        @php
                            $status = 'En desarrollo';
                            $statusColor = 'bg-green-100 text-green-800';
                            $daysUntilHarvest = null;

                            if ($siembra->fecha_cosecha_estimada) {
                                $harvestDate = \Carbon\Carbon::parse($siembra->fecha_cosecha_estimada);
                                $today = \Carbon\Carbon::today();
                                $daysUntilHarvest = $today->diffInDays($harvestDate, false);

                                if ($daysUntilHarvest < 0) {
                                    $status = 'Cosecha Atrasada';
                                    $statusColor = 'bg-red-100 text-red-800';
                                } elseif ($daysUntilHarvest <= 7) {
                                    $status = 'Próxima Cosecha';
                                    $statusColor = 'bg-yellow-100 text-yellow-800';
                                }
                            }
                        @endphp

                        <div class="border rounded-lg p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
                            <div class="flex-shrink-0">
                                @if($siembra->cultivo && $siembra->cultivo->imagen)
                                    <img src="{{ asset('storage/' . $siembra->cultivo->imagen) }}" alt="{{ $siembra->cultivo->nombre_comun }}" class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i data-lucide="image-off" class="text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start mb-1">
                                    <div>
                                        <p class="font-semibold text-gray-800 truncate">{{ $siembra->cultivo->nombre_comun ?? 'Cultivo no especificado' }}</p>
                                        <p class="text-xs text-gray-500 italic truncate">{{ $siembra->cultivo->nombre_cientifico ?? '' }}</p>
                                    </div>
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
                        </div>
                    @empty
                        <p class="text-gray-500">No hay siembras registradas.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA (1/3): MONITOREO Y ALERTAS --}}
        <div class="space-y-8">
            
            {{-- 1. Monitoreo Ambiental --}}
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-lg flex items-center gap-2">
                        <i data-lucide="thermometer" class="text-blue-600"></i>
                        Monitoreo Ambiental
                    </h2>
                    <span class="text-xs text-gray-500">
                        {{ $ultimoMonitoreo->fecha_hora ? $ultimoMonitoreo->fecha_hora->diffForHumans() : 'Sin datos' }}
                    </span>
                    <a href="{{ route('monitoreo.index') }}" class="btn-swipe">
                        Ver detalles
                    </a>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-red-50 rounded-lg border border-red-100">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="thermometer" class="w-4 h-4 text-red-500"></i>
                            <span class="text-xs text-gray-600">Temp.</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($ultimoMonitoreo->temperatura, 1) }}°C</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-100">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="droplets" class="w-4 h-4 text-blue-500"></i>
                            <span class="text-xs text-gray-600">Humedad</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($ultimoMonitoreo->humedad, 1) }}%</p>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-100">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="sun" class="w-4 h-4 text-yellow-600"></i>
                            <span class="text-xs text-gray-600">Luz</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800">{{ number_format($ultimoMonitoreo->luminosidad_lux, 0) }} lux</p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg border border-green-100">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="droplet" class="w-4 h-4 text-green-600"></i>
                            <span class="text-xs text-gray-600">Charola 1</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800">
                            {{ number_format($ultimoMonitoreo->humedad_charola1, 0) }}%
                        </p>
                    </div>

                    {{-- Humedad Charola 2 --}}
                    <div class="p-3 bg-green-50 rounded-lg border border-green-100">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="droplet" class="w-4 h-4 text-green-600"></i>
                            <span class="text-xs text-gray-600">Charola 2</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800">
                            {{ number_format($ultimoMonitoreo->humedad_charola2, 0) }}%
                        </p>
                    </div>

                    {{-- Humedad Charola 3 --}}
                    <div class="p-3 bg-green-50 rounded-lg border border-green-100">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="droplet" class="w-4 h-4 text-green-600"></i>
                            <span class="text-xs text-gray-600">Charola 3</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800">
                            {{ number_format($ultimoMonitoreo->humedad_charola3, 0) }}%
                        </p>
                    </div>

                    {{-- Humedad Charola 4 --}}
                    <div class="p-3 bg-green-50 rounded-lg border border-green-100">
                        <div class="flex items-center gap-2 mb-1">
                            <i data-lucide="droplet" class="w-4 h-4 text-green-600"></i>
                            <span class="text-xs text-gray-600">Charola 4</span>
                        </div>
                        <p class="text-xl font-bold text-gray-800">
                            {{ number_format($ultimoMonitoreo->humedad_charola4, 0) }}%
                        </p>
                    </div>
                </div>
            </div>

            {{-- 2. Alertas Recientes (AHORA EN LA COLUMNA DERECHA) --}}
            <div class="bg-white p-6 rounded-lg shadow-sm border">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-bold text-lg flex items-center gap-2">
                        <i data-lucide="alert-triangle" class="text-orange-600"></i>
                        Alertas Recientes
                    </h2>
                    <a href="{{ route('alertas.index') }}" class="btn-swipe">
                        Ver todas
                    </a>
                </div>
                
                <div class="space-y-3">
                    @forelse($alertasRecientes as $alerta)
                        <div class="border-b last:border-b-0 py-2">
                            <div class="flex justify-between items-start gap-2">
                                <p class="font-semibold text-sm text-gray-800 line-clamp-2">{{ $alerta->mensaje }}</p>
                                @if($alerta->severidad == 'critical')
                                    <span class="bg-red-100 text-red-800 text-[10px] px-1.5 py-0.5 rounded font-bold">Crítica</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                {{ $alerta->fecha->diffForHumans() }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500 text-sm">
                            <p>No hay alertas recientes.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>