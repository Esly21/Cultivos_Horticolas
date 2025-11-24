<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SmartGarden - Cultivos Inteligentes</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="antialiased">
        <div class="bg-white min-h-screen flex flex-col"
             x-data="{
                {{-- Lógica del Modal (para login/registro) --}}
                showModal: false,
                @if($errors->has('email') || $errors->has('password'))
                    modalContent: 'login',
                    showModal: true
                @elseif($errors->any())
                    modalContent: 'register',
                    showModal: true
                @else
                    modalContent: 'login',
                    showModal: false
                @endif
             }">

            <header class="absolute inset-x-0 top-0 z-50">
                <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
                    <div class="flex lg:flex-1">
                        <a href="/" class="-m-1.5 p-1.5 flex items-center gap-3">
                            <img class="h-10 w-auto rounded-lg" src="{{ asset('images/Logo.jpg') }}" alt="SmartGarden Logo">
                            <span class="font-bold text-xl text-white">SmartGarden</span>
                        </a>
                    </div>
                    <div class="flex lg:flex-1 lg:justify-end gap-x-6">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-semibold leading-6 text-gray-900">Dashboard</a>
                        @endauth
                    </div>
                </nav>
            </header>

            <main class="relative isolate flex-grow" 
                  x-data="{
                      {{-- Lógica del Carrusel --}}
                      slides: [
                          '{{ asset('images/carrusel1/1.jpg') }}',
                          '{{ asset('images/carrusel2/2.jpg') }}',
                          '{{ asset('images/carrusel3/3.jpg') }}',
                          '{{ asset('images/carrusel4/4.jpg') }}'
                      ],
                      activeSlide: 0,
                      autoplay() { setInterval(() => { this.next() }, 5000); },
                      next() { this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1; },
                      prev() { this.activeSlide = (this.activeSlide === 0) ? this.slides.length - 1 : this.activeSlide - 1; }
                  }"
                  x-init="autoplay()">
                
                <div class="absolute inset-0 -z-10 overflow-hidden pt-14">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index"
                             x-transition:enter="transition-opacity ease-out duration-1000"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition-opacity ease-in duration-1000"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute inset-0">
                            <img :src="slide" class="w-full h-full object-cover" alt="Fondo de cultivo">
                            <div class="absolute inset-0 bg-black/40"></div> 
                        </div>
                    </template>
                </div>
                
                <button @click="prev()" class="absolute left-4 top-1/2 z-20 -translate-y-1/2 rounded-full p-2 bg-white/30 text-white hover:bg-white/50">
                    <i data-lucide="chevron-left"></i>
                </button>
                <button @click="next()" class="absolute right-4 top-1/2 z-20 -translate-y-1/2 rounded-full p-2 bg-white/30 text-white hover:bg-white/50">
                    <i data-lucide="chevron-right"></i>
                </button>

                <div class="relative z-10 py-24 sm:py-32" x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl 
                                   transition-all ease-out duration-1000"
                            :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'">
                            Controla tus <span class="text-green-400">cultivos hortícolas</span>
                        </h1>
                        <p class="mt-6 text-lg leading-8 text-gray-200 
                                  transition-all ease-out duration-1000 delay-300"
                           :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'">
                            Sistema inteligente para monitoreo y gestión de cultivos en tiempo real.
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6 
                                    transition-all ease-out duration-1000 delay-500"
                             :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-5'">
                            <button @click="$dispatch('open-modal', 'login')" class="rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
                                Comenzar ahora
                            </button>
                            <a href="{{ route('features') }}" class="text-sm font-semibold leading-6 text-white">Saber más <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                </div>
                
                <div class="absolute bottom-10 left-0 right-0 z-20 flex justify-center gap-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" class="w-3 h-3 rounded-full" :class="activeSlide === index ? 'bg-white' : 'bg-white/50'"></button>
                    </template>
                </div>
            </main>

            {{-- EL SEGUNDO BLOQUE <main> HA SIDO ELIMINADO --}}

            <div class="bg-green-700">
                <div class="text-center py-16 px-6 sm:py-20 lg:px-8">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        <span class="block">¿Listo para comenzar?</span>
                        <span class="block">Regístrate hoy mismo.</span>
                    </h2>
                    <p class="mt-4 text-lg leading-6 text-green-200">
                        Optimiza el crecimiento de tus plantas con nuestra tecnología.
                    </p>
                    <button @click="$dispatch('open-modal', 'register')" class="mt-8 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-white px-5 py-3 text-base font-medium text-green-600 hover:bg-green-50 sm:w-auto">
                        Crear cuenta gratis
                    </button>
                </div>
            </div>

            {{-- ESTRUCTURA DEL MODAL --}}
            <div x-show="showModal"
                 x-transition
                 class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center p-4 z-50"
                 style="display: none;"
                 @keydown.escape.window="showModal = false"
                 @open-modal.window="modalContent = $event.detail; showModal = true">
                
                <div @click.outside="showModal = false" 
                     class="w-full max-w-md bg-white rounded-lg shadow-xl p-8 relative">
                    
                    <button @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>

                    <img class="w-20 h-20 mx-auto rounded-lg shadow-md mb-4" src="{{ asset('images/Logo.jpg') }}" alt="Logo">

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