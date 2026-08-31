<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ? $title . ' - ' : '' }}{{ config('app.name', 'Mupaka Shamba Letu') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Leaflet Map CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] { display: none !important; }
            .leaflet-control-attribution {
                font-size: 9px !important;
                background: rgba(255, 255, 255, 0.8) !important;
            }
            .custom-pin {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 14px;
                height: 14px;
                border-radius: 50%;
                border: 2px solid #ffffff;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.4);
                cursor: pointer;
                transition: transform 0.2s ease;
            }
            .custom-pin:hover {
                transform: scale(1.35);
            }
            .pin-rdc { background-color: #e11d48; }
            .pin-rwanda { background-color: #16a34a; }
            .pin-burundi { background-color: #0284c7; }

            /* Leaflet popup styling matching theme */
            .leaflet-popup-content-wrapper {
                border-radius: 4px !important;
                padding: 4px 6px !important;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2) !important;
                border: 1px solid #e5e7eb !important;
            }
            .leaflet-popup-content {
                margin: 6px 8px !important;
                font-family: inherit !important;
                font-size: 12px !important;
                line-height: 1.4 !important;
            }
            .leaflet-popup-tip {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            }
        </style>

        @stack('styles')
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white selection:bg-yellow-400 selection:text-black flex flex-col min-h-screen">
        <!-- Top Navigation Bar -->
        <header class="w-full bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Brand Logo / Title -->
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl sm:text-[26px] font-black text-black tracking-tight">
                            Mupaka Samba Letu
                        </a>
                    </div>

                    <!-- Navigation Links & Action Button -->
                    <nav class="hidden md:flex items-stretch h-full space-x-8 lg:space-x-10">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 text-sm font-bold tracking-normal transition-all duration-150 {{ request()->routeIs('home') ? 'text-black border-b-[3.5px] border-yellow-400 -mb-[1px] font-extrabold' : 'text-gray-700 hover:text-black border-b-[3.5px] border-transparent hover:border-yellow-300 -mb-[1px]' }}">
                            Accueil
                        </a>
                        <a href="{{ route('about') }}" class="inline-flex items-center px-1 text-sm font-bold tracking-normal transition-all duration-150 {{ request()->routeIs('about') ? 'text-black border-b-[3.5px] border-yellow-400 -mb-[1px] font-extrabold' : 'text-gray-700 hover:text-black border-b-[3.5px] border-transparent hover:border-yellow-300 -mb-[1px]' }}">
                            Apropos
                        </a>
                        <a href="{{ route('news') }}" class="inline-flex items-center px-1 text-sm font-bold tracking-normal transition-all duration-150 {{ request()->routeIs('news') ? 'text-black border-b-[3.5px] border-yellow-400 -mb-[1px] font-extrabold' : 'text-gray-700 hover:text-black border-b-[3.5px] border-transparent hover:border-yellow-300 -mb-[1px]' }}">
                            Actualités
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 text-sm font-bold tracking-normal transition-all duration-150 {{ request()->routeIs('dashboard*') ? 'text-black border-b-[3.5px] border-yellow-400 -mb-[1px] font-extrabold' : 'text-gray-700 hover:text-black border-b-[3.5px] border-transparent hover:border-yellow-300 -mb-[1px]' }}">
                                Tableau de bord
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-1 text-sm font-bold tracking-normal transition-all duration-150 {{ request()->routeIs('login') ? 'text-black border-b-[3.5px] border-yellow-400 -mb-[1px] font-extrabold' : 'text-gray-700 hover:text-black border-b-[3.5px] border-transparent hover:border-yellow-300 -mb-[1px]' }}">
                                Connexion
                            </a>
                        @endauth

                        <div class="flex items-center pl-2">
                            <a href="{{ route('home') }}#contact" class="inline-flex items-center justify-center bg-black hover:bg-neutral-800 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 transition duration-150 ease-in-out shadow-none">
                                CONTACT
                            </a>
                        </div>
                    </nav>

                    <!-- Mobile Menu Button -->
                    <div class="flex md:hidden items-center space-x-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-xs font-bold bg-gray-100 px-3 py-1.5 rounded">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-xs font-bold text-black">
                                Connexion
                            </a>
                        @endauth
                        <a href="{{ route('home') }}#contact" class="bg-black text-white text-xs font-bold px-3 py-1.5 uppercase">
                            Contact
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Page Content Slot -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer Section -->
        <footer id="contact" class="w-full bg-black text-white pt-16 pb-8 border-t border-neutral-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Footer 3-Columns Grid -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12">
                    
                    <!-- Left Col: Branding & Social Icons -->
                    <div class="md:col-span-6">
                        <h3 class="text-xl font-black text-yellow-400 tracking-tight">
                            Mupaka Shamba Letu
                        </h3>
                        <p class="text-xs font-bold text-gray-300 tracking-wider uppercase mt-2">
                            DR CONGO | RWANDA | BURUNDI
                        </p>
                        <p class="text-xs text-gray-400 font-normal mt-2">
                            Commerce Transfrontalier pour la paix
                        </p>

                        <!-- Social Media Icons (X, LinkedIn, Facebook) -->
                        <div class="flex items-center space-x-3.5 mt-6">
                            <!-- X (Twitter) -->
                            <a href="https://x.com" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)"
                               class="w-9 h-9 flex items-center justify-center rounded-full bg-neutral-900 border border-neutral-700 text-gray-300 hover:text-black hover:bg-yellow-400 hover:border-yellow-400 transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>

                            <!-- LinkedIn -->
                            <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"
                               class="w-9 h-9 flex items-center justify-center rounded-full bg-neutral-900 border border-neutral-700 text-gray-300 hover:text-black hover:bg-yellow-400 hover:border-yellow-400 transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.2V10.9H6.46M7.83 6.5a1.64 1.64 0 0 0-1.64 1.64c0 .9.74 1.64 1.64 1.64s1.64-.74 1.64-1.64c0-.9-.74-1.64-1.64-1.64Z"/>
                                </svg>
                            </a>

                            <!-- Facebook -->
                            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                               class="w-9 h-9 flex items-center justify-center rounded-full bg-neutral-900 border border-neutral-700 text-gray-300 hover:text-black hover:bg-yellow-400 hover:border-yellow-400 transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Middle Col: Links 1 -->
                    <div class="md:col-span-3">
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('home') }}" class="text-sm font-bold text-white hover:text-yellow-400 transition">
                                    Accueil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('about') }}" class="text-sm font-bold text-white hover:text-yellow-400 transition">
                                    A propos
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Right Col: Links 2 -->
                    <div class="md:col-span-3">
                        <ul class="space-y-3">
                            <li>
                                <a href="{{ route('home') }}#contact" class="text-sm font-bold text-white hover:text-yellow-400 transition">
                                    Contacte
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('news') }}" class="text-sm font-bold text-white hover:text-yellow-400 transition">
                                    Actualités
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>

                <!-- Footer Bottom Copyright Line -->
                <div class="border-t border-neutral-800 pt-6 text-center">
                    <p class="text-xs text-gray-400 font-normal">
                        &copy; 2026 Mupaka Shamba Letu. Tous droits réservés.
                    </p>
                </div>
            </div>
        </footer>

        <!-- Back to Top Button -->
        <div x-data="{ showBackToTop: false }"
             @scroll.window="showBackToTop = (window.pageYOffset > 350)"
             class="fixed bottom-6 right-6 z-50">
            <button x-show="showBackToTop"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-6 scale-75"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-6 scale-75"
                    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    aria-label="Retour en haut"
                    title="Retour en haut"
                    class="group flex items-center justify-center w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-black text-yellow-400 hover:bg-yellow-400 hover:text-black border-2 border-yellow-400 shadow-2xl transition-all duration-300 transform hover:-translate-y-1 focus:outline-none"
                    x-cloak>
                <svg class="w-5 h-5 sm:w-6 sm:h-6 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                </svg>
            </button>
        </div>

        <!-- Leaflet Map JS (Optional) -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

        @stack('scripts')
    </body>
</html>
