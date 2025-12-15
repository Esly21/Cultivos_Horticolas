<x-app-layout>
    <div class="p-6 lg:p-8" x-data="{ activeTab: 'catalogos' }">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Configuración del Sistema</h1>
            <p class="text-gray-500 mt-1">Personaliza y gestiona las opciones de la aplicación.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md shadow-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-md shadow-sm" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-64 flex-shrink-0">
                <nav class="space-y-2">
                    <button @click="activeTab = 'catalogos'" :class="{ 'bg-green-50 text-green-700 border-green-200': activeTab === 'catalogos', 'hover:bg-gray-50': activeTab !== 'catalogos' }" class="w-full flex items-center gap-3 px-4 py-3 text-left rounded-lg border transition-colors">
                        <i data-lucide="database" class="w-5 h-5"></i>
                        <span class="font-medium">Catálogos</span>
                    </button>
                    <button @click="activeTab = 'usuario'" :class="{ 'bg-green-50 text-green-700 border-green-200': activeTab === 'usuario', 'hover:bg-gray-50': activeTab !== 'usuario' }" class="w-full flex items-center gap-3 px-4 py-3 text-left rounded-lg border transition-colors">
                        <i data-lucide="user" class="w-5 h-5"></i>
                        <span class="font-medium">Usuario</span>
                    </button>
                </nav>
            </div>

            <div class="flex-1">
                
                <div x-show="activeTab === 'catalogos'" class="space-y-6">
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

                        {{-- 1. Tipos de Cultivo --}}
                        <x-catalog-card title="Tipos de Cultivo" :items="$tiposCultivo" route-store="tipos-cultivo.store" route-destroy="tipos-cultivo.destroy" />

                        {{-- 2. Estados de Siembra --}}
                        <x-catalog-card title="Estados de Siembra" :items="$estadosSiembra" display-key="estado" field-name="estado" route-store="estados-siembra.store" route-destroy="estados-siembra.destroy" />

                        {{-- 3. Tipos de Suelo --}}
                        <x-catalog-card title="Tipos de Suelo" :items="$tiposSuelo" route-store="tipos-suelo.store" route-destroy="tipos-suelo.destroy" />

                        {{-- 4. Periodos --}}
                        <x-catalog-card title="Periodos de Crecimiento" :items="$periodos" route-store="periodos.store" route-destroy="periodos.destroy"  primary-key="id_periodo" />

                        {{-- 5. Rangos --}}
                        <x-catalog-card title="Rangos" :items="$rangos" route-store="rangos.store" route-destroy="rangos.destroy" primary-key="id_rango" />

                        {{-- 6. Dimensiones (Especial porque tiene 3 campos) --}}
                        <div class="bg-white p-6 rounded-lg shadow-sm border">
                            <h2 class="text-xl font-bold mb-4 text-gray-800">Dimensiones</h2>
                            <form action="{{ route('dimensiones.store') }}" method="POST" class="flex flex-wrap gap-2 mb-4">
                                @csrf
                                <input type="number" step="0.01" name="largo" placeholder="Largo" class="flex-1 min-w-[80px] border-gray-300 rounded-lg shadow-sm text-sm" required>
                                <input type="number" step="0.01" name="ancho" placeholder="Ancho" class="flex-1 min-w-[80px] border-gray-300 rounded-lg shadow-sm text-sm" required>
                                <input type="number" step="0.01" name="altura" placeholder="Alto" class="flex-1 min-w-[80px] border-gray-300 rounded-lg shadow-sm text-sm" required>
                                <button type="submit" class="bg-green-600 text-white px-3 py-2 rounded-lg font-semibold hover:bg-blue-700">
                                    <i data-lucide="plus" class="w-5 h-5"></i>
                                </button>
                            </form>

                            <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                                @foreach($dimensiones as $dim)
                                    <div class="flex justify-between items-center p-3 border rounded-lg bg-gray-50">
                                        <span class="font-medium text-sm">
                                            {{ $dim->largo }} x {{ $dim->ancho }} x {{ $dim->altura }} cm
                                        </span>
                                        <form action="{{ route('dimensiones.destroy', $dim->id_dimension) }}" method="POST" onsubmit="return confirm('¿Eliminar?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 p-1"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    <x-catalog-card title="Tipos de Siembra" :items="$tiposSiembra" route-store="tipos-siembra.store" route-destroy="tipos-siembra.destroy" primary-key="id_tipo_siembra" />
                    </div>
                </div>

                <div x-show="activeTab === 'usuario'" class="bg-white p-6 rounded-lg shadow-sm border">
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Información del Usuario</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="font-medium text-sm text-gray-700">Nombre Completo</label>
                            <p class="mt-1 text-gray-900 font-medium p-2 bg-gray-50 rounded border">{{ $user->fullName }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-sm text-gray-700">Correo Electrónico</label>
                            <p class="mt-1 text-gray-900 font-medium p-2 bg-gray-50 rounded border">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-sm text-gray-700">Rol</label>
                            <p class="mt-1 text-gray-900 font-medium p-2 bg-gray-50 rounded border">{{ $user->tipoUsuario->nombre ?? 'Sin definir' }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 mt-4 text-blue-600 hover:text-blue-800 font-medium">
                            <i data-lucide="user-cog" class="w-4 h-4"></i>
                            Editar mi perfil
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>