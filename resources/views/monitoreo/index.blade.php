<x-app-layout>
    <div class="p-6 lg:p-8" x-data="dashboard()" x-init="init()">

        {{-- Cabecera y Filtros --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Monitoreo Ambiental</h1>
                <p class="text-gray-500 mt-1">Supervisa las condiciones de tus cultivos en tiempo real.</p>
            </div>
            <div class="flex items-center gap-3 mt-4 md:mt-0">
                <select x-model="siembraId" @change="fetchData(); fetchHistorico()" class="border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option disabled value="">Selecciona una siembra</option>
                    @foreach($siembras as $siembra)
                        <option value="{{ $siembra->id }}">Siembra  ({{ $siembra->cultivo->nombre_comun ?? '' }})</option>
                    @endforeach
                </select>
                <select x-model="filtroTiempo" @change="fetchHistorico()" class="border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="24">Últimas 24 horas</option>
                    <option value="72">Últimas 72 horas</option>
                    <option value="168">Últimos 7 días</option>
                </select>
            </div>
        </div>

        {{-- Métricas Generales --}}
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Métricas Generales</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-metric-card icon="thermometer" title="Temperatura" unit="°C" color="red">
                <span x-text="temperatura.toFixed(1)"></span>
            </x-metric-card>
            <x-metric-card icon="droplets" title="Humedad Amb." unit="%" color="blue">
                <span x-text="humedad.toFixed(1)"></span>
            </x-metric-card>
            <x-metric-card icon="sun" title="Luminosidad" unit=" lux" color="yellow">
                <span x-text="lux.toFixed(0)"></span>
            </x-metric-card>
            <x-metric-card icon="wind" title="pH del Suelo" unit="" color="purple">
                <span x-text="ph.toFixed(1)"></span>
            </x-metric-card>
        </div>

        {{-- Humedad del Suelo por Charolas --}}
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Humedad del Suelo (Charolas)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-metric-card icon="layers" title="Zona 1" unit="%" color="gray">
                <span x-text="charola1.toFixed(1)"></span>
            </x-metric-card>
            <x-metric-card icon="layers" title="Zona 2" unit="%" color="gray">
                <span x-text="charola2.toFixed(1)"></span>
            </x-metric-card>
            <x-metric-card icon="layers" title="Zona 3" unit="%" color="gray">
                <span x-text="charola3.toFixed(1)"></span>
            </x-metric-card>
            <x-metric-card icon="layers" title="Zona 4" unit="%" color="gray">
                <span x-text="charola4.toFixed(1)"></span>
            </x-metric-card>
        </div>

        {{-- Tendencias de Variables --}}
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm border">
                <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                    <i data-lucide="trending-up" class="text-blue-600"></i>
                    Tendencias de Variables
                </h2>
                <div class="h-80">
                    <canvas id="chartTendencias"></canvas>
                </div>
            </div>

            {{-- Estado de Sensores --}}
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <i data-lucide="activity" class="text-green-600"></i>
                        Estado de Sensores
                    </h2>
                    <div class="space-y-3">
                        <template x-if="sensores.length === 0">
                            <p class="text-gray-500 text-sm">No hay siembras activas.</p>
                        </template>
                        <template x-for="sensor in sensores" :key="sensor.id">
                            <div class="flex justify-between items-center p-3 border rounded-lg">
                                <span class="font-medium text-sm" x-text="sensor.nombre"></span>
                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-800">En línea</span>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Estado de Actuadores --}}
                <div class="bg-white p-6 rounded-lg shadow-sm border">
                    <h2 class="font-bold text-lg mb-4 flex items-center gap-2">
                        <i data-lucide="trello" class="text-indigo-600"></i>
                        Estado de Actuadores
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center p-3 border rounded-lg">
                            <span class="font-medium text-sm">Ventilador</span>
                            <span x-text="ventilador ? 'Encendido' : 'Apagado'" 
                                  :class="ventilador ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700'"
                                  class="text-xs font-semibold px-2 py-1 rounded-full"></span>
                        </div>
                        <div class="flex justify-between items-center p-3 border rounded-lg">
                            <span class="font-medium text-sm">Sistema de Riego</span>
                            <span x-text="riego ? 'Activado' : 'Detenido'" 
                                  :class="riego ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-700'"
                                  class="text-xs font-semibold px-2 py-1 rounded-full"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Lógica Alpine.js --}}
    <script>
        function dashboard() {
            return {
                siembraId: {{ $siembras->first()->id ?? 'null' }},
                filtroTiempo: '24', // horas
                temperatura: 0,
                humedad: 0,
                ph: 0,
                lux: 0,
                charola1: 0,
                charola2: 0,
                charola3: 0,
                charola4: 0,
                ventilador: false,
                riego: false,
                sensores: @json($siembras->map(fn($s) => [
                    'id' => $s->id, 
                    'nombre' => 'Sensor - ' . ($s->cultivo->nombre_comun ?? 'Siembra')
                ])),
                chartTendencias: null,

                init() {
                    if (this.siembraId) {
                        this.fetchData();
                        this.fetchHistorico();
                    }

                    setInterval(() => {
                        if (this.siembraId) {
                            this.fetchData();
                            this.fetchHistorico();
                        }
                    }, 10000);
                },

                fetchData() {
                    if (!this.siembraId) return;

                    fetch(`/monitoreo/latest/${this.siembraId}`)
                        .then(response => response.json())
                        .then(data => {
                            this.temperatura = parseFloat(data.temperatura) || 0;
                            this.humedad = parseFloat(data.humedad) || 0;
                            this.ph = parseFloat(data.ph_suelo) || 0;
                            this.lux = parseFloat(data.luminosidad_lux) || 0;

                            if (data.humedad_suelo && data.humedad_suelo.length === 4) {
                                this.charola1 = parseFloat(data.humedad_suelo[0]) || 0;
                                this.charola2 = parseFloat(data.humedad_suelo[1]) || 0;
                                this.charola3 = parseFloat(data.humedad_suelo[2]) || 0;
                                this.charola4 = parseFloat(data.humedad_suelo[3]) || 0;
                            }
                            this.ventilador = data.ventilador_activo || false;
                            this.riego = data.riego_activo || false;
                        })
                        .catch(console.error);
                },

                fetchHistorico() {
                    if (!this.siembraId) return;

                    fetch(`/monitoreo/historico/${this.siembraId}?hours=${this.filtroTiempo}`)
                        .then(res => res.json())
                        .then(data => {
                            const maxLabels = 20;
                            const sliceStep = Math.max(Math.floor(data.length / maxLabels), 1);
                            const filteredData = data.filter((_, i) => i % sliceStep === 0);

                            const labels = filteredData.map(d => new Date(d.fecha_hora).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
                            const temperaturas = filteredData.map(d => d.temperatura);
                            const humedades = filteredData.map(d => d.humedad);
                            const phs = filteredData.map(d => d.ph_suelo);

                            if (!this.chartTendencias) {
                                const ctx = document.getElementById('chartTendencias').getContext('2d');
                                this.chartTendencias = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: labels,
                                        datasets: [
                                            { label: 'Temperatura (°C)', data: temperaturas, borderColor: '#EF4444', fill: false, tension: 0.3, pointRadius: 2 },
                                            { label: 'Humedad (%)', data: humedades, borderColor: '#3B82F6', fill: false, tension: 0.3, pointRadius: 2 },
                                            { label: 'pH', data: phs, borderColor: '#8B5CF6', fill: false, tension: 0.3, pointRadius: 2 }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        interaction: { mode: 'nearest', axis: 'x', intersect: false },
                                        scales: { y: { beginAtZero: false, title: { display: true, text: 'Valor' } } }
                                    }
                                });
                            } else {
                                this.chartTendencias.data.labels = labels;
                                this.chartTendencias.data.datasets[0].data = temperaturas;
                                this.chartTendencias.data.datasets[1].data = humedades;
                                this.chartTendencias.data.datasets[2].data = phs;
                                this.chartTendencias.update();
                            }
                        })
                        .catch(console.error);
                },

            }
        }
    </script>
</x-app-layout>