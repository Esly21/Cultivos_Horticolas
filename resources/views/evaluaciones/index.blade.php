<x-app-layout>
    {{-- Contenedor principal con AlpineJS --}}
    <div x-data="evaluaciones()" x-init="init()" class="p-6 space-y-6">

        {{-- ================= ENCABEZADO ================= --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Evaluación de Rendimiento</h1>
                <p class="text-gray-500">Comparativa de ciclos de siembra</p>
            </div>
        </div>

        {{-- ================= TABS DE NAVEGACIÓN ================= --}}
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="cambiarTab('nueva')" 
                        :class="{'border-green-500 text-green-600': tab === 'nueva', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'nueva'}"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Nueva Evaluación
                </button>
                
                <button @click="cambiarTab('historial')" 
                        :class="{'border-green-500 text-green-600': tab === 'historial', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'historial'}"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Historial
                    <span class="bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs ml-2" x-text="historialData.length"></span>
                </button>
            </nav>
        </div>

        {{-- ================= CONTENIDO: NUEVA / VER EVALUACIÓN ================= --}}
        <div x-show="tab === 'nueva'" style="display: none;">
            
            {{-- Barra de acciones superior (Solo visible si hay datos) --}}
            <div class="flex justify-end mb-4" x-show="detalle.length > 0">
                
                {{-- A) Botón Guardar (Solo si NO estamos viendo una guardada) --}}
                <template x-if="!modoLectura">
                    <button @click="abrirModalGuardar()" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 font-semibold transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        Guardar Evaluación
                    </button>
                </template>
                
                {{-- B) Botones Ver Historial (PDF y Cerrar) --}}
                <template x-if="modoLectura">
                    <div class="flex gap-2">
                        {{-- Botón PDF --}}
                        <button @click="descargarPdf()" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 font-semibold transition" :disabled="generandoPdf">
                            <template x-if="!generandoPdf">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            </template>
                            <template x-if="generandoPdf">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </template>
                            <span x-text="generandoPdf ? 'Generando...' : 'Descargar PDF'"></span>
                        </button>

                        {{-- Botón Cerrar --}}
                        <button @click="limpiarYVolver()" class="flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded shadow hover:bg-gray-300 font-semibold transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            Cerrar Vista
                        </button>
                    </div>
                </template>
            </div>

            {{-- Alerta de "Modo Lectura" --}}
            <div x-show="modoLectura" class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Viendo evaluación guardada: <span class="font-bold" x-text="nombreLectura"></span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- PANEL IZQUIERDO: SELECCIÓN (Deshabilitado en modo lectura) --}}
                <div class="lg:col-span-3 bg-white p-6 rounded-lg shadow-sm border border-gray-100 h-fit" :class="{'opacity-75 pointer-events-none': modoLectura}">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Selección</h3>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">1. Cultivo</label>
                        <select x-model="cultivo" @change="reset()" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-green-500">
                            <option value="">-- Seleccionar --</option>
                            @foreach($cultivos as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre_comun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div x-show="cultivo" class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700">2. Siembras (mín. 2)</label>
                        <div class="max-h-80 overflow-y-auto space-y-2 pr-2 custom-scrollbar">
                            <template x-for="s in siembrasFiltradas()" :key="s.id">
                                <label class="flex items-start space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded-lg border border-transparent hover:border-gray-200 transition">
                                    <input type="checkbox" :value="s.id" x-model="siembras" @change="calcular()" class="mt-1 rounded text-green-600 focus:ring-green-500 h-4 w-4">
                                    <div class="text-sm">
                                        <span class="font-semibold text-gray-700 block">Siembra #<span x-text="s.id"></span></span>
                                        <span class="text-xs text-gray-400" x-text="formatDate(s.fecha_inicio)"></span>
                                    </div>
                                </label>
                            </template>
                            <div x-show="siembrasFiltradas().length === 0" class="text-sm text-gray-500 text-center py-4 bg-gray-50 rounded">
                                No hay siembras registradas.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PANEL DERECHO: RESULTADOS --}}
                <div class="lg:col-span-9 space-y-6">
                    {{-- Estado Vacío --}}
                    <div x-show="siembras.length < 2 && !modoLectura" class="bg-white p-12 rounded-lg shadow-sm border border-dashed border-gray-300 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Selecciona al menos 2 siembras</h3>
                        <p class="text-gray-500 mt-1">Para comparar el rendimiento, selecciona dos o más siembras.</p>
                    </div>

                    {{-- CONTENEDOR DE GRÁFICAS Y TABLAS --}}
                    <div x-show="detalle.length > 0">
                        {{-- KPIs --}}
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                            <template x-for="(val, key) in resumen" :key="key">
                                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4" 
                                     :class="{
                                        'border-l-blue-500': key.includes('inversion'),
                                        'border-l-green-500': key.includes('ingresos'),
                                        'border-l-yellow-500': key.includes('cantidad'),
                                        'border-l-red-500': key.includes('temperatura'),
                                        'border-l-cyan-500': key.includes('humedad')
                                     }">
                                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-wider" x-text="labels[key]"></p>
                                    <p class="text-lg md:text-xl font-bold text-gray-800 mt-1" x-text="val"></p>
                                </div>
                            </template>
                        </div>

                        {{-- Tabla --}}
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden mb-6">
                            <div class="px-6 py-4 border-b bg-gray-50">
                                <h3 class="font-bold text-gray-800">Detalle Comparativo</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-white text-gray-600 border-b uppercase text-xs font-semibold tracking-wider">
                                        <tr>
                                            <th class="px-6 py-3">Siembra</th>
                                            <th class="px-6 py-3">Inversión</th>
                                            <th class="px-6 py-3">Ingresos</th>
                                            <th class="px-6 py-3">Rentabilidad</th>
                                            <th class="px-6 py-3">Cantidad</th>
                                            <th class="px-6 py-3">Temp</th>
                                            <th class="px-6 py-3">Humedad</th>
                                            <th class="px-6 py-3">Calidad</th>
                                            <th class="px-6 py-3">Días</th>
                                            <th class="px-6 py-3 text-center">Análisis</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <template x-for="r in detalle" :key="r.siembra_id">
                                            <tr class="hover:bg-gray-50 transition-colors" :class="{'bg-green-50/50': Number(r.rentabilidad) === maxRentabilidad}">
                                                <td class="px-6 py-3 font-medium text-gray-900" x-text="r.label"></td>
                                                <td class="px-6 py-3 font-medium">$<span x-text="Number(r.inversion).toFixed(2)"></span></td>
                                                <td class="px-6 py-3 font-bold text-green-600">$<span x-text="Number(r.ingresos).toFixed(2)"></span></td>
                                                <td class="px-6 py-3 font-bold" :class="r.rentabilidad >= 0 ? 'text-purple-600' : 'text-red-500'">$<span x-text="Number(r.rentabilidad).toFixed(2)"></span></td>
                                                <td class="px-6 py-3"><span x-text="r.cantidad"></span> kg</td>
                                                <td class="px-6 py-3"><span x-text="r.temperatura"></span>°C</td>
                                                <td class="px-6 py-3"><span x-text="r.humedad"></span>%</td>
                                                <td class="px-6 py-3">
                                                    <span class="px-2 py-1 rounded-full text-xs font-bold border" :class="{'bg-green-50 text-green-700 border-green-200': r.calidad === 'Excelente', 'bg-blue-50 text-blue-700 border-blue-200': r.calidad === 'Buena', 'bg-yellow-50 text-yellow-700 border-yellow-200': r.calidad === 'Regular', 'bg-gray-50 text-gray-600 border-gray-200': r.calidad === 'N/A'}" x-text="r.calidad"></span>
                                                </td>
                                                <td class="px-6 py-3 text-gray-500" x-text="r.dias"></td>
                                                <td class="px-6 py-3 text-center">
                                                    <template x-if="Number(r.rentabilidad) === maxRentabilidad">
                                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                                            Mejor Opción
                                                        </span>
                                                    </template>
                                                    <template x-if="Number(r.rentabilidad) !== maxRentabilidad"><span class="text-xs text-gray-400">-</span></template>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Gráficas --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100"><canvas id="graficaIngresos"></canvas></div>
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100"><canvas id="graficaCantidad"></canvas></div>
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 md:col-span-2 h-80"><canvas id="graficaRentabilidad"></canvas></div>
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100"><canvas id="graficaTemperatura"></canvas></div>
                            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100"><canvas id="graficaHumedad"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= CONTENIDO: HISTORIAL ================= --}}
        <div x-show="tab === 'historial'" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="evaluacion in historialData" :key="evaluacion.id">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800" x-text="evaluacion.nombre"></h3>
                                    <p class="text-sm text-gray-500" x-text="evaluacion.cultivo ? evaluacion.cultivo.nombre_comun : 'Cultivo eliminado'"></p>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold" x-text="formatDate(evaluacion.created_at)"></span>
                            </div>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Siembras:</span>
                                    <span class="font-medium text-gray-900" x-text="evaluacion.siembras_ids.length"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Inversión Promedio:</span>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold">$<span x-text="Number(evaluacion.resultado.resumen.inversion_promedio).toFixed(2)"></span></span>
                            </div>

                            <button @click="verEvaluacion(evaluacion)" class="w-full mt-2 flex justify-center items-center gap-2 bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 font-medium transition text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Ver Detalles
                            </button>
                        </div>
                    </div>
                </template>
                
                {{-- Estado vacío del historial --}}
                <div x-show="historialData.length === 0" class="col-span-full text-center py-12 bg-white rounded-lg border border-dashed">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <h3 class="text-lg font-medium text-gray-900">No hay historial</h3>
                    <p class="text-gray-500">Guarda tu primera evaluación para verla aquí.</p>
                </div>
            </div>
        </div>

        {{-- ================= MODAL GUARDAR ================= --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm" x-transition.opacity>
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 overflow-hidden" @click.away="showModal = false">
                <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Guardar Evaluación</h3>
                    <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre de la Evaluación *</label>
                        <input type="text" x-model="form.nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Ej: Tomates Verano 2025">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notas (Opcional)</label>
                        <textarea x-model="form.notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Observaciones..."></textarea>
                    </div>
                    <div class="bg-blue-50 p-3 rounded text-sm text-blue-800">
                        <p><strong>Resumen a guardar:</strong></p>
                        <ul class="list-disc list-inside mt-1">
                            <li>Cultivo: <span class="font-bold" x-text="getCultivoName()"></span></li>
                            <li><span x-text="siembras.length"></span> siembras comparadas</li>
                        </ul>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                    <button @click="showModal = false" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancelar</button>
                    <button @click="guardar()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium flex items-center gap-2" :disabled="guardando">
                        <span x-show="guardando" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                        <span x-text="guardando ? 'Guardando...' : 'Confirmar Guardado'"></span>
                    </button>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function evaluaciones() {
            return {
                tab: 'nueva',
                cultivo: '',
                siembras: [],
                siembrasData: {!! json_encode($siembras) !!},
                cultivosData: {!! json_encode($cultivos) !!},
                historialData: {!! json_encode($evaluaciones) !!}, 
                
                resumen: {},
                detalle: [],
                charts: {},
                maxRentabilidad: -Infinity,
                
                // Modo Lectura y PDF
                modoLectura: false,
                nombreLectura: '',
                viewingId: null,      // ID de la evaluación actual
                generandoPdf: false,  // Estado de carga del PDF

                showModal: false,
                guardando: false,
                form: { nombre: '', notas: '' },
                labels: { inversion_promedio: 'Inv. Promedio', ingresos_promedio: 'Ing. Promedio', cantidad_promedio: 'Cant. Promedio', temperatura: 'Temp. Promedio', humedad: 'Hum. Promedio' },

                init() {},

                cambiarTab(nuevoTab) {
                    this.tab = nuevoTab;
                    if(nuevoTab === 'nueva' && !this.modoLectura) {
                        // Si volvemos a nueva y no estamos leyendo, se mantiene el estado
                    }
                },

                // Función para ver una evaluación guardada
                verEvaluacion(evaluacion) {
                    this.modoLectura = true;
                    this.nombreLectura = evaluacion.nombre;
                    this.viewingId = evaluacion.id; // GUARDAR EL ID
                    this.tab = 'nueva'; 
                    
                    this.cultivo = evaluacion.cultivo_id;
                    this.siembras = evaluacion.siembras_ids;
                    this.resumen = evaluacion.resultado.resumen;
                    this.detalle = evaluacion.resultado.detalle;
                    
                    if (this.detalle.length > 0) {
                        this.maxRentabilidad = Math.max(...this.detalle.map(item => Number(item.rentabilidad)));
                    }
                    this.$nextTick(() => { this.renderCharts(); });
                },

                limpiarYVolver() {
                    this.modoLectura = false;
                    this.nombreLectura = '';
                    this.viewingId = null;
                    this.reset();
                },

                // --- GENERACIÓN DE PDF ---
                async descargarPdf() {
                    if (!this.viewingId) return;
                    this.generandoPdf = true;

                    try {
                        // 1. Capturamos las gráficas como imágenes Base64
                        const chartsImages = {
                            ingresos: this.charts.ingresos?.toBase64Image() || null,
                            rentabilidad: this.charts.rentabilidad?.toBase64Image() || null,
                            cantidad: this.charts.cantidad?.toBase64Image() || null,
                            temperatura: this.charts.temperatura?.toBase64Image() || null,
                            humedad: this.charts.humedad?.toBase64Image() || null,
                        };
                        // 2. Enviamos al servidor
                        const url = '{{ route("evaluaciones.pdf", ":id") }}'.replace(':id', this.viewingId);
                        
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(chartsImages)
                        });

                        if (!response.ok) throw new Error('Error generando el PDF');

                        // 3. Convertimos la respuesta en un Blob para descargar
                        const blob = await response.blob();
                        const blobUrl = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = blobUrl;
                        a.download = `Reporte_${this.nombreLectura.replace(/\s+/g, '_')}.pdf`;
                        document.body.appendChild(a);
                        a.click();
                        a.remove(); 
                        window.URL.revokeObjectURL(blobUrl);

                    } catch (error) {
                        console.error(error);
                        alert('No se pudo generar el PDF. Revisa la consola para más detalles.');
                    } finally {
                        this.generandoPdf = false;
                    }
                },

                getCultivoName() {
                    const c = this.cultivosData.find(x => x.id == this.cultivo);
                    return c ? c.nombre_comun : 'Seleccionado';
                },
                formatDate(dateString) {
                    if(!dateString) return '';
                    return new Date(dateString).toLocaleDateString();
                },
                siembrasFiltradas() {
                    return this.siembrasData.filter(s => s.cultivo_id == this.cultivo);
                },
                reset() {
                    this.siembras = [];
                    this.detalle = [];
                    this.resumen = {};
                    this.maxRentabilidad = -Infinity;
                    this.destroyCharts();
                },
                async calcular() {
                    if (this.modoLectura) return; 
                    if (this.siembras.length < 2) { this.detalle = []; return; }
                    try {
                        const response = await fetch('{{ route("evaluaciones.calcular") }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ siembras: this.siembras })
                        });
                        if (!response.ok) throw new Error('Error');
                        const data = await response.json();
                        this.resumen = data.resumen;
                        this.detalle = data.detalle;
                        if (this.detalle.length > 0) {
                             this.maxRentabilidad = Math.max(...this.detalle.map(item => Number(item.rentabilidad)));
                        }
                        this.$nextTick(() => { this.renderCharts(); });
                    } catch (error) { console.error(error); }
                },
                abrirModalGuardar() {
                    this.form.nombre = ''; this.form.notas = ''; this.showModal = true;
                },
                async guardar() {
                    if (!this.form.nombre) { alert('Ingresa un nombre'); return; }
                    this.guardando = true;
                    try {
                        const payload = {
                            cultivo_id: this.cultivo, nombre: this.form.nombre, notas: this.form.notas,
                            siembras_ids: this.siembras, resultado: { resumen: this.resumen, detalle: this.detalle }
                        };
                        const response = await fetch('{{ route("evaluaciones.store") }}', {
                            method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify(payload)
                        });
                        if (!response.ok) throw new Error('Error');
                        window.location.reload(); 
                    } catch (error) { console.error(error); alert('Error al guardar'); this.guardando = false; }
                },
                renderCharts() {
                    this.destroyCharts();
                    const labels = this.detalle.map(x => x.label);
                    // Configuración de Gráficas
                    this.charts.ingresos = new Chart(document.getElementById('graficaIngresos'), { type: 'bar', data: { labels, datasets: [ { label: 'Inversión', data: this.detalle.map(x => x.inversion), backgroundColor: '#ef4444', borderRadius: 4 }, { label: 'Ingresos', data: this.detalle.map(x => x.ingresos), backgroundColor: '#10b981', borderRadius: 4 } ] }, options: { responsive: true, plugins: { title: { display: true, text: 'Económico' } }, scales: { y: { beginAtZero: true } } } });
                    this.charts.rentabilidad = new Chart(document.getElementById('graficaRentabilidad'), { type: 'bar', data: { labels, datasets: [{ label: 'Rentabilidad', data: this.detalle.map(x => x.rentabilidad), backgroundColor: '#8b5cf6', borderRadius: 4 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'Rentabilidad Neta' } }, scales: { y: { beginAtZero: true } } } });
                    this.charts.cantidad = new Chart(document.getElementById('graficaCantidad'), { type: 'line', data: { labels, datasets: [{ label: 'Cantidad (Kg)', data: this.detalle.map(x => x.cantidad), borderColor: '#eab308', backgroundColor: '#eab308', borderWidth: 2, tension: 0.1, fill: false }] }, options: { responsive: true, plugins: { title: { display: true, text: 'Producción' } }, scales: { y: { beginAtZero: true } } } });
                    this.charts.temperatura = new Chart(document.getElementById('graficaTemperatura'), { type: 'bar', data: { labels, datasets: [{ label: 'Temp (°C)', data: this.detalle.map(x => x.temperatura), backgroundColor: '#f87171', borderRadius: 4 }] }, options: { responsive: true, scales: { y: { beginAtZero: true } } } });
                    this.charts.humedad = new Chart(document.getElementById('graficaHumedad'), { type: 'bar', data: { labels, datasets: [{ label: 'Humedad (%)', data: this.detalle.map(x => x.humedad), backgroundColor: '#06b6d4', borderRadius: 4 }] }, options: { responsive: true, scales: { y: { beginAtZero: true } } } });
                },
                destroyCharts() { Object.values(this.charts).forEach(chart => chart && chart.destroy()); this.charts = {}; }
            }
        }
    </script>
    @endpush
</x-app-layout>