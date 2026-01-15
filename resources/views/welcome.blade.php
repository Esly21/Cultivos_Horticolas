<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SmartGarden - Tecnología Agrícola</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="antialiased bg-gray-50">
<div
    class="min-h-screen flex flex-col"
    x-data="{
        showModal: false,
        modalContent: 'login',
        scrolled: false
    }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
>

{{-- ================= HEADER (GLASSMORPHISM) ================= --}}
<header
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
    :class="{
        'bg-white/90 backdrop-blur-md shadow-sm py-4': scrolled,
        'bg-transparent py-6': !scrolled
    }"
>
    <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 lg:px-8">
        <div class="flex lg:flex-1">
            <a href="/" class="-m-1.5 p-1.5 flex items-center gap-3 group">
                <div class="relative overflow-hidden rounded-lg shadow-lg group-hover:shadow-green-500/50 transition-shadow">
                    <img class="h-10 w-auto" src="{{ asset('images/Logo.jpg') }}" alt="SmartGarden">
                </div>
                <span class="font-bold text-xl tracking-tight transition-colors"
                      :class="{ 'text-gray-900': scrolled, 'text-white': !scrolled }">
                    SmartGarden
                </span>
            </a>
        </div>

        <div class="flex lg:flex-1 lg:justify-end gap-x-6">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="text-sm font-medium px-4 py-2 rounded-full transition-all"
                   :class="{
                       'text-gray-900 hover:bg-gray-100': scrolled,
                       'text-white bg-white/10 hover:bg-white/20 backdrop-blur-sm': !scrolled
                   }">
                    Ir al Dashboard
                </a>
            @else
                <button
                    @click="$dispatch('open-modal','login')"
                    class="text-sm font-medium px-5 py-2 rounded-lg transition-all"
                    :class="{
                        'text-gray-900 hover:text-green-600': scrolled,
                        'text-white hover:text-green-300': !scrolled
                    }">
                    Iniciar sesión
                </button>

                <button
                    @click="$dispatch('open-modal','register')"
                    class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-lg shadow-green-600/30 transition-all hover:scale-105">
                    Registrarse
                </button>
            @endauth
        </div>
    </nav>
</header>

{{-- ================= HERO (CINEMÁTICO) ================= --}}
<main
    class="relative isolate flex-grow min-h-screen flex items-center justify-center"
    x-data="{
        slides: [
            '{{ asset('images/carrusel1/1.jpg') }}',
            '{{ asset('images/carrusel2/2.jpg') }}',
            '{{ asset('images/carrusel3/3.jpg') }}',
            '{{ asset('images/carrusel4/4.jpg') }}'
        ],
        active: 0,
        init() {
            setInterval(() => {
                this.active = (this.active + 1) % this.slides.length
            }, 6000)
        }
    }"
    x-init="init()"
>

    <div class="absolute inset-0 -z-10 overflow-hidden">
        <template x-for="(img, i) in slides" :key="i">
            <div x-show="active === i"
                 x-transition:enter="transition ease-out duration-1000"
                 x-transition:enter-start="opacity-0 scale-105"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-1000"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">
                <img :src="img" class="w-full h-full object-cover">
            </div>
        </template>

        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/70 via-slate-900/40 to-slate-900/90"></div>
    </div>

    <div class="relative z-10 text-center px-6 max-w-4xl mx-auto mt-16 text-white">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-green-300 text-xs font-semibold uppercase tracking-wider mb-6">
            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
            Tecnología Agrícola 4.0
        </div>

        <h1 class="text-5xl md:text-7xl font-bold tracking-tight leading-tight">
            El futuro de tus <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-emerald-500">
                cultivos está aquí
            </span>
        </h1>

        <p class="mt-6 text-lg md:text-xl text-gray-200 max-w-2xl mx-auto">
            Optimiza recursos, monitorea variables ambientales en tiempo real y toma decisiones basadas en datos.
        </p>

        <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
            <button
                @click="$dispatch('open-modal','login')"
                class="inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 shadow-xl shadow-green-900/20 transition">
                Comenzar Gratis
            </button>

            <a href="#features"
               class="inline-flex items-center justify-center px-8 py-3.5 text-base font-medium text-white bg-white/10 border border-white/20 rounded-lg hover:bg-white/20 backdrop-blur-sm">
                Ver características
            </a>
        </div>
    </div>
</main>

{{-- ================= FEATURES ================= --}}
<section id="features" class="bg-white py-24 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-sm font-bold tracking-widest text-green-600 uppercase">Solución Integral</h2>
            <p class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                Inteligencia aplicada al campo
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ([
                ['icon'=>'smartphone','title'=>'Monitoreo Remoto','desc'=>'Accede a los datos desde cualquier lugar'],
                ['icon'=>'bell-ring','title'=>'Alertas Inteligentes','desc'=>'Notificaciones automáticas'],
                ['icon'=>'area-chart','title'=>'Análisis de Datos','desc'=>'Históricos y gráficas'],
                ['icon'=>'database','title'=>'Gestión Centralizada','desc'=>'Control total de cultivos']
            ] as $f)
                <div class="group bg-white p-8 rounded-2xl shadow-sm border hover:shadow-xl hover:-translate-y-1 transition">
                    <i data-lucide="{{ $f['icon'] }}" class="w-10 h-10 text-green-600 mb-4"></i>
                    <h3 class="text-xl font-bold">{{ $f['title'] }}</h3>
                    <p class="text-gray-500 text-sm mt-2">{{ $f['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= CTA ================= --}}
<section class="relative py-24 bg-slate-900 text-center text-white">
    <h2 class="text-3xl font-bold">Lleva tu producción al siguiente nivel</h2>
    <p class="mt-4 text-slate-300">Regístrate gratis y comienza hoy</p>

    <button
        @click="$dispatch('open-modal','register')"
        class="mt-8 px-8 py-4 bg-green-500 hover:bg-green-400 text-slate-900 font-bold rounded-lg shadow-lg transition">
        Crear Cuenta Gratuita
    </button>
</section>

{{-- ================= FOOTER ================= --}}
<footer class="bg-white border-t py-12 text-center text-sm text-gray-400">
    SmartGarden © {{ date('Y') }}
</footer>

{{-- ================= MODAL LOGIN / REGISTER ================= --}}
<div
    x-show="showModal"
    x-cloak
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
    @keydown.escape.window="showModal = false"
    @open-modal.window="
        modalContent = $event.detail;
        showModal = true
    "
>
    <div
        @click.outside="showModal = false"
        class="bg-white rounded-xl shadow-2xl w-full max-w-md p-8 relative"
    >
        <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400">
            <i data-lucide="x"></i>
        </button>

        <img src="{{ asset('images/Logo.jpg') }}" class="h-16 mx-auto mb-6 rounded shadow">

        <div x-show="modalContent === 'login'">
            @include('auth.partials.login-form')
        </div>

        <div x-show="modalContent === 'register'">
            @include('auth.partials.register-form')
        </div>
    </div>
</div>

</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
