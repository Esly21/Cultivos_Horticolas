<x-app-layout>
    <div class="p-6 lg:p-8" x-data="{ activeTab: 'general' }">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Configuración del Sistema</h1>
            <p class="text-gray-500 mt-1">Personaliza y gestiona las opciones de la aplicación.</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-64 flex-shrink-0">
                <nav class="space-y-2">
                    <button @click="activeTab = 'general'" :class="{ 'bg-green-50 text-green-700 border-green-200': activeTab === 'general', 'hover:bg-gray-50': activeTab !== 'general' }" class="w-full flex items-center gap-3 px-4 py-3 text-left rounded-lg border transition-colors">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        <span class="font-medium">General</span>
                    </button>
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
                <div x-show="activeTab === 'general'" class="bg-white p-6 rounded-lg shadow-sm border">
                    <h2 class="text-xl font-bold mb-4">Configuración General</h2>
                    <p class="text-gray-500">Esta sección es un ejemplo y no guarda cambios.</p>
                </div>

                <div x-show="activeTab === 'catalogos'" class="space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm border">
                        <h2 class="text-xl font-bold mb-4">Tipos de Cultivo</h2>
                        <form action="{{ route('tipos-cultivo.store') }}" method="POST" class="flex gap-2 mb-4">
                            @csrf
                            <input type="text" name="nombre" placeholder="Nuevo tipo de cultivo..." class="flex-1 border-gray-300 rounded-lg shadow-sm" required>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold">Agregar</button>
                        </form>
                        <div class="space-y-2">
                            @foreach($tiposCultivo as $tipo)
                                <div class="flex justify-between items-center p-3 border rounded-lg">
                                    <span class="font-medium">{{ $tipo->nombre }}</span>
                                    <form action="{{ route('tipos-cultivo.destroy', $tipo) }}" method="POST" onsubmit="return confirm('¿Eliminar este elemento?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-sm border">
                        <h2 class="text-xl font-bold mb-4">Estados de Siembra</h2>
                         <form action="{{ route('estados-siembra.store') }}" method="POST" class="flex gap-2 mb-4">
                            @csrf
                            <input type="text" name="estado" placeholder="Nuevo estado de siembra..." class="flex-1 border-gray-300 rounded-lg shadow-sm" required>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold">Agregar</button>
                        </form>
                        <div class="space-y-2">
                            @foreach($estadosSiembra as $estado)
                                <div class="flex justify-between items-center p-3 border rounded-lg">
                                    <span class="font-medium">{{ $estado->estado }}</span>
                                    <form action="{{ route('estados-siembra.destroy', $estado) }}" method="POST" onsubmit="return confirm('¿Eliminar este elemento?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div x-show="activeTab === 'usuario'" class="bg-white p-6 rounded-lg shadow-sm border">
                    <h2 class="text-xl font-bold mb-4">Información del Usuario</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="font-medium text-sm text-gray-700">Nombre Completo</label>
                            <p class="mt-1 text-gray-800">{{ $user->fullName }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-sm text-gray-700">Correo Electrónico</label>
                            <p class="mt-1 text-gray-800">{{ $user->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="inline-block mt-4 text-blue-600 hover:underline">Ir a mi perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>