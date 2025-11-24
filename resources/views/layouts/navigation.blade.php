<aside class="w-64 min-h-screen bg-white border-r flex flex-col">
    <div class="p-6 border-b">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-lg flex items-center justify-center">
            <i data-lucide="leaf" class="text-white"></i>
        </div>
        <div>
            {{-- TAMAÑO DE TEXTO AUMENTADO AQUÍ --}}
            <h1 class="font-bold text-gray-800 text-xl">SmartGarden</h1>
            <p class="text-sm text-green-500">Gestión Inteligente</p>
        </div>
    </a>
</div>

    <nav class="flex-1 p-4 space-y-2">
        <x-nav-link 
            :href="route('dashboard')" 
            :active="request()->routeIs('dashboard')" 
            icon="layout-dashboard" 
            title="Dashboard" 
            description="Vista general" />

        <x-nav-link 
            :href="route('cultivos.index')" 
            :active="request()->routeIs('cultivos.*')" 
            icon="sprout" 
            title="Cultivos" 
            description="Gestión de cultivos" />

        <x-nav-link 
            :href="route('siembras.index')" 
            :active="request()->routeIs('siembras.*')" 
            icon="leaf" 
            title="Siembras" 
            description="Control de siembras" />

        <x-nav-link 
            :href="route('monitoreo.index')" 
            :active="request()->routeIs('monitoreo.*')" 
            icon="bar-chart-3" 
            title="Monitoreo" 
            description="Variables ambientales" />

        <x-nav-link 
            :href="route('alertas.index')" 
            :active="request()->routeIs('alertas.*')" 
            icon="bell" 
            title="Alertas" 
            description="Notificaciones">
            {{-- La insignia de notificación se pasa como contenido del slot 
            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full"></span>--}}
        </x-nav-link>

        <x-nav-link 
            :href="route('reportes.index')" 
            :active="request()->routeIs('reportes.*')" 
            icon="file-text" 
            title="Reportes" 
            description="Bitácoras y reportes" />
            <x-nav-link 
            :href="route('configuracion.index')" 
            :active="request()->routeIs('configuracion.*')" 
            icon="settings" 
            title="Configuración" 
            description="Ajustes del sistema" />
    </nav>

    <div class="p-4 border-t">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 group p-2 rounded-lg hover:bg-gray-50">
            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center group-hover:bg-green-100">
                <i data-lucide="user" class="text-gray-600 group-hover:text-green-700"></i>
            </div>
            <div>
                <p class="font-semibold text-sm text-gray-800 group-hover:text-green-700">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">Ir a mi perfil</p>
            </div>
        </a>
        
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); this.closest('form').submit();"
                    class="text-xs text-red-500 hover:underline ml-1">
                Cerrar Sesión
            </a>
        </form>
    </div>
</aside>