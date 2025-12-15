<x-app-layout>
    {{-- MODIFICACIÓN: Se quitaron 'max-w-7xl mx-auto' para que no se centre ni limite el ancho --}}
    <div class="p-6 lg:p-8" 
         x-data="{ 
            showUserModal: false, 
            activeUser: { name: '', email: '', siembras: [], siembras_count: 0 } 
         }">

        {{-- Encabezado --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Gestión de Usuarios</h1>
                <p class="text-gray-500 mt-1">Supervisa la actividad y el acceso de los usuarios.</p>
            </div>
            <div class="text-sm text-gray-500 flex items-center gap-2 mt-4 md:mt-0">
                <i data-lucide="calendar" class="w-4 h-4"></i>
                <span>{{ now()->locale('es')->translatedFormat('l, j \de F \de Y') }}</span>
            </div>
        </div>

        {{-- Tarjetas de Resumen --}}
        @php
            $totalUsuarios = $usuarios->count();
            $admins = $usuarios->where('id_tipo_usuario', 1)->count();
            $totalSiembrasGlobal = $usuarios->sum('siembras_count'); 
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-l-4 border-l-blue-500 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Usuarios</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsuarios }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-full"><i data-lucide="users" class="w-6 h-6 text-blue-600"></i></div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-l-4 border-l-purple-500 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Administradores</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $admins }}</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-full"><i data-lucide="shield-check" class="w-6 h-6 text-purple-600"></i></div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border border-l-4 border-l-green-500 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Actividad Global</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalSiembrasGlobal }}</p>
                    <p class="text-xs text-green-600 mt-1">Siembras creadas</p>
                </div>
                <div class="p-3 bg-green-50 rounded-full"><i data-lucide="activity" class="w-6 h-6 text-green-600"></i></div>
            </div>
        </div>

        {{-- Mensajes --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabla de Usuarios --}}
        <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
            <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
                <h2 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                    <i data-lucide="list" class="text-gray-500"></i> Listado de Cuentas
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3">Usuario</th>
                            <th class="px-6 py-3">Rol</th>
                            <th class="px-6 py-3">Resumen Actividad</th>
                            <th class="px-6 py-3">Registro</th>
                            <th class="px-6 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($usuarios as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->id_tipo_usuario == 1)
                                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded border border-purple-200">Admin</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-200">Usuario</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded">
                                            {{ $user->siembras_count }} Siembras
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button 
                                            @click="activeUser = {{ $user }}; showUserModal = true"
                                            class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition-colors" 
                                            title="Ver Actividad">
                                            <i data-lucide="folder-open" class="w-4 h-4"></i>
                                        </button>

                                        @if(auth()->user()->id !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');" class="inline-block">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors" title="Eliminar">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- MODAL DE DETALLE DE USUARIO --}}
        <div x-show="showUserModal" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50" style="display: none;">
            <div @click.outside="showUserModal = false" class="bg-white rounded-lg shadow-xl w-full max-w-2xl overflow-hidden">
                
                <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                            <span x-text="activeUser.name ? activeUser.name.substring(0, 2).toUpperCase() : ''"></span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800" x-text="activeUser.name"></h2>
                            <p class="text-sm text-gray-500" x-text="activeUser.email"></p>
                        </div>
                    </div>
                    <button @click="showUserModal = false"><i data-lucide="x" class="w-6 h-6 text-gray-400"></i></button>
                </div>

                <div class="p-6">
                    <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                        <i data-lucide="leaf" class="text-green-600 w-5 h-5"></i> Historial de Siembras
                    </h3>

                    <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                        <template x-if="activeUser.siembras && activeUser.siembras.length > 0">
                            <template x-for="siembra in activeUser.siembras" :key="siembra.id">
                                <div class="flex justify-between items-center p-3 border rounded-lg bg-gray-50">
                                    <div>
                                        <p class="font-bold text-gray-800" x-text="siembra.cultivo ? siembra.cultivo.nombre_comun : 'Cultivo #' + siembra.cultivo_id"></p>
                                        <p class="text-xs text-gray-500">
                                            Inicio: <span x-text="new Date(siembra.fecha_inicio).toLocaleDateString()"></span>
                                        </p>
                                    </div>
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-800">
                                        Registrada
                                    </span>
                                </div>
                            </template>
                        </template>

                        <template x-if="!activeUser.siembras || activeUser.siembras.length === 0">
                            <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed">
                                <p class="text-gray-500 text-sm">Este usuario no ha registrado ninguna siembra.</p>
                            </div>
                        </template>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-6 pt-6 border-t">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-800" x-text="activeUser.siembras_count"></span>
                            <span class="text-xs text-gray-500 uppercase tracking-wide">Total Siembras</span>
                        </div>
                        <div class="text-center border-l">
                            <span class="block text-2xl font-bold text-gray-800" x-text="new Date(activeUser.created_at).toLocaleDateString()"></span>
                            <span class="text-xs text-gray-500 uppercase tracking-wide">Miembro Desde</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>