<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Mupaka Shamba Letu') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Leaflet Map CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
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
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white selection:bg-yellow-400 selection:text-black">
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
                    <nav class="hidden md:flex items-center space-x-8 lg:space-x-10">
                        <a href="{{ route('home') }}" class="text-sm font-bold text-black border-b-[3px] border-yellow-400 pb-1 tracking-normal transition">
                            Accueil
                        </a>
                        <a href="#apropos" class="text-sm font-bold text-black hover:text-gray-600 tracking-normal transition">
                            Apropos
                        </a>
                        <a href="#actualites" class="text-sm font-bold text-black hover:text-gray-600 tracking-normal transition">
                            Actualités
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-black hover:text-gray-600 tracking-normal transition">
                                Tableau de bord
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-black hover:text-gray-600 tracking-normal transition">
                                Connexion
                            </a>
                        @endauth

                        <a href="#contact" class="inline-flex items-center justify-center bg-black hover:bg-neutral-800 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 transition duration-150 ease-in-out shadow-none">
                            CONTACT
                        </a>
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
                        <a href="#contact" class="bg-black text-white text-xs font-bold px-3 py-1.5 uppercase">
                            Contact
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="relative w-full min-h-[540px] lg:min-h-[600px] xl:min-h-[640px] bg-cover bg-center bg-no-repeat flex items-center"
                 style="background-image: url('{{ asset('images/Picture1.jpg') }}');">
            <!-- Background Tint / Overlay -->
            <div class="absolute inset-0 bg-black/25 z-0"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left Card: Flash News Card -->
                    <div class="lg:col-span-6 xl:col-span-5">
                        <div class="bg-white/90 backdrop-blur-md p-6 sm:p-8 shadow-2xl border border-white/40">
                            <!-- Flash Badge -->
                            <div class="mb-3">
                                <span class="inline-block bg-black text-yellow-400 font-black text-[10px] tracking-widest px-2.5 py-1 uppercase">
                                    FLASH
                                </span>
                            </div>

                            <!-- News Headline -->
                            <h2 class="text-lg sm:text-xl font-black text-black leading-snug tracking-tight mb-3.5">
                                Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola.
                            </h2>

                            <!-- News Excerpt -->
                            <p class="text-xs sm:text-sm text-gray-800 font-medium leading-relaxed mb-6">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>

                            <!-- Read More Button -->
                            <div>
                                <a href="#actualites" class="inline-flex items-center justify-center bg-black hover:bg-neutral-900 text-yellow-400 font-black text-xs uppercase tracking-wider px-5 py-2.5 transition">
                                    LIRE PLUS
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Notre Projet Content -->
                    <div class="lg:col-span-6 xl:col-span-7 lg:pl-10 text-white">
                        <div class="max-w-lg ml-auto">
                            <!-- Project Title -->
                            <h1 class="text-3xl sm:text-4xl lg:text-[44px] font-black text-white tracking-tight leading-tight mb-4 drop-shadow-md">
                                Notre Projet
                            </h1>

                            <!-- Project Description -->
                            <p class="text-xs sm:text-sm text-white/95 font-medium leading-relaxed mb-6 drop-shadow">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>

                            <!-- Project Action Button -->
                            <div>
                                <a href="#apropos" class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-black font-black text-xs uppercase tracking-wider px-7 py-3 transition shadow-md">
                                    APROPOS
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Quick Access Feature Cards Section -->
        <section class="w-full bg-[#d9d9d9] py-10 lg:py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    
                    <!-- Card 1: Prix du jour -->
                    <div class="bg-yellow-400 p-8 sm:p-10 flex flex-col items-center justify-center text-center shadow-md">
                        <h3 class="text-lg sm:text-xl font-black text-black tracking-tight mb-2">
                            Prix du jour
                        </h3>
                        <p class="text-xs sm:text-sm font-semibold text-black mb-6">
                            Consulter les prix du marché
                        </p>
                        <a href="{{ route('login') }}" class="inline-block border border-black px-6 py-2 bg-transparent hover:bg-black hover:text-white text-xs font-bold uppercase tracking-wider text-black transition">
                            Consulter
                        </a>
                    </div>

                    <!-- Card 2: Taux de change -->
                    <div class="bg-yellow-400 p-8 sm:p-10 flex flex-col items-center justify-center text-center shadow-md">
                        <h3 class="text-lg sm:text-xl font-black text-black tracking-tight mb-2">
                            Taux de change
                        </h3>
                        <p class="text-xs sm:text-sm font-semibold text-black mb-6">
                            Consulter les taux du jour
                        </p>
                        <a href="{{ route('login') }}" class="inline-block border border-black px-6 py-2 bg-transparent hover:bg-black hover:text-white text-xs font-bold uppercase tracking-wider text-black transition">
                            Consulter
                        </a>
                    </div>

                    <!-- Card 3: Signaler un problème -->
                    <div class="bg-yellow-400 p-8 sm:p-10 flex flex-col items-center justify-center text-center shadow-md">
                        <h3 class="text-lg sm:text-xl font-black text-black tracking-tight mb-2">
                            Signaler un problème
                        </h3>
                        <p class="text-xs sm:text-sm font-semibold text-black mb-6">
                            Soumettre une plainte
                        </p>
                        <a href="{{ route('login') }}" class="inline-block border border-black px-6 py-2 bg-transparent hover:bg-black hover:text-white text-xs font-bold uppercase tracking-wider text-black transition">
                            Soumettre
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- Project Mission / About Statement Section -->
        <section id="apropos" class="w-full bg-white py-16 lg:py-24">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-lg sm:text-xl md:text-2xl lg:text-[25px] font-black text-black leading-snug sm:leading-normal md:leading-relaxed tracking-tight max-w-3xl mx-auto">
                    L'objectif ultime et l'ambition du projet MSL II restent<br class="hidden sm:inline">
                    le renforcement de la cohésion sociale entre<br class="hidden sm:inline">
                    les communautés transfrontalières et<br class="hidden sm:inline">
                    de la stabilité dans la région des Grands Lacs
                </h2>

                <div class="mt-8">
                    <a href="{{ route('login') }}" class="inline-block border border-black px-7 py-2.5 bg-white hover:bg-black hover:text-white text-xs font-bold uppercase tracking-wider text-black transition shadow-sm">
                        A propos
                    </a>
                </div>
            </div>
        </section>

        <!-- Impact Counter / Statistics Section -->
        <section class="relative w-full bg-cover bg-center bg-no-repeat py-16 lg:py-20"
                 style="background-image: url('{{ asset('images/Picture1.jpg') }}');">
            <!-- Dark Overlay for High Contrast Stats -->
            <div class="absolute inset-0 bg-black/65 z-0"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12 text-center">
                    
                    <!-- Stat 1: FPCTS -->
                    <div>
                        <p class="text-xs sm:text-sm font-black text-white uppercase tracking-wider mb-2">
                            FPCTS
                        </p>
                        <p class="text-4xl sm:text-5xl lg:text-6xl font-black text-yellow-400 tracking-tight drop-shadow-md">
                            6000+
                        </p>
                    </div>

                    <!-- Stat 2: AVECs -->
                    <div>
                        <p class="text-xs sm:text-sm font-black text-white uppercase tracking-wider mb-2">
                            AVECs
                        </p>
                        <p class="text-4xl sm:text-5xl lg:text-6xl font-black text-yellow-400 tracking-tight drop-shadow-md">
                            4500+
                        </p>
                    </div>

                    <!-- Stat 3: Plaintes/Feedback -->
                    <div>
                        <p class="text-xs sm:text-sm font-black text-white uppercase tracking-wider mb-2">
                            Plaintes/Feedback
                        </p>
                        <p class="text-4xl sm:text-5xl lg:text-6xl font-black text-yellow-400 tracking-tight drop-shadow-md">
                            2300+
                        </p>
                    </div>

                    <!-- Stat 4: Jeunes Entrepreneurs -->
                    <div>
                        <p class="text-xs sm:text-sm font-black text-white uppercase tracking-wider mb-2">
                            Jeunes Entrepreneurs
                        </p>
                        <p class="text-4xl sm:text-5xl lg:text-6xl font-black text-yellow-400 tracking-tight drop-shadow-md">
                            800+
                        </p>
                    </div>

                </div>
            </div>
        </section>

        <!-- Map Section: Cross-Border Trade Region with Theme Integration -->
        <section class="relative w-full border-t-4 border-[#0284c7] bg-white">
            <div class="relative w-full h-[460px] sm:h-[500px] lg:h-[560px] bg-slate-100 overflow-hidden">
                <div id="crossBorderMap" class="w-full h-full z-0"></div>

                <!-- Map Legend in Top-Right Corner with theme styling -->
                <div class="absolute top-4 right-4 z-[400] bg-white/95 backdrop-blur-md border border-gray-200 px-4 py-3 shadow-lg rounded-sm text-xs">
                    <p class="text-[11px] font-black uppercase tracking-wider text-gray-500 mb-2 border-b border-gray-100 pb-1">
                        Pays Partenaires
                    </p>
                    <div class="flex flex-col space-y-2 font-bold text-gray-900">
                        <div class="flex items-center space-x-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-[#e11d48] border-2 border-white inline-block shadow-sm"></span>
                            <span>RDC</span>
                        </div>
                        <div class="flex items-center space-x-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-[#16a34a] border-2 border-white inline-block shadow-sm"></span>
                            <span>Rwanda</span>
                        </div>
                        <div class="flex items-center space-x-2.5">
                            <span class="w-3.5 h-3.5 rounded-full bg-[#0284c7] border-2 border-white inline-block shadow-sm"></span>
                            <span>Burundi</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Actualités / News Carousel Section (Yellow Background) -->
        <section id="actualites" class="w-full bg-yellow-400 py-14 lg:py-18 relative"
                 x-data="{
                     activeSlide: 0,
                     totalSlides: 3,
                     prev() {
                         this.activeSlide = (this.activeSlide === 0) ? this.totalSlides - 1 : this.activeSlide - 1;
                     },
                     next() {
                         this.activeSlide = (this.activeSlide === this.totalSlides - 1) ? 0 : this.activeSlide + 1;
                     }
                 }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 relative">
                
                <!-- Carousel Container with Arrows -->
                <div class="relative flex items-center">
                    
                    <!-- Left Navigation Arrow -->
                    <button @click="prev()" aria-label="Previous News" class="absolute -left-3 sm:-left-6 lg:-left-8 z-20 text-black hover:text-neutral-700 transition focus:outline-none p-2">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 font-bold" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <!-- News Cards Grid -->
                    <div class="w-full grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 px-4 sm:px-6">
                        
                        <!-- News Card 1 -->
                        <div class="bg-white p-6 sm:p-7 shadow-lg flex flex-col justify-between h-full border border-yellow-200">
                            <div>
                                <!-- Flash Tag -->
                                <div class="mb-4">
                                    <span class="border border-black px-2 py-0.5 text-[11px] font-bold text-black uppercase tracking-wider inline-block">
                                        Flash
                                    </span>
                                </div>
                                <!-- Title -->
                                <h3 class="text-base sm:text-lg font-black text-black leading-snug mb-4">
                                    Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola.
                                </h3>
                                <!-- Date -->
                                <p class="text-xs text-gray-600 font-medium mb-6">
                                    Publié le 09 Août 2026
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('login') }}" class="text-sm font-black text-black hover:underline inline-block">
                                    Lire plus
                                </a>
                            </div>
                        </div>

                        <!-- News Card 2 -->
                        <div class="bg-white p-6 sm:p-7 shadow-lg flex flex-col justify-between h-full border border-yellow-200">
                            <div>
                                <!-- Flash Tag -->
                                <div class="mb-4">
                                    <span class="border border-black px-2 py-0.5 text-[11px] font-bold text-black uppercase tracking-wider inline-block">
                                        Flash
                                    </span>
                                </div>
                                <!-- Title -->
                                <h3 class="text-base sm:text-lg font-black text-black leading-snug mb-4">
                                    Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola.
                                </h3>
                                <!-- Date -->
                                <p class="text-xs text-gray-600 font-medium mb-6">
                                    Publié le 09 Août 2026
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('login') }}" class="text-sm font-black text-black hover:underline inline-block">
                                    Lire plus
                                </a>
                            </div>
                        </div>

                        <!-- News Card 3 -->
                        <div class="bg-white p-6 sm:p-7 shadow-lg flex flex-col justify-between h-full border border-yellow-200">
                            <div>
                                <!-- Flash Tag -->
                                <div class="mb-4">
                                    <span class="border border-black px-2 py-0.5 text-[11px] font-bold text-black uppercase tracking-wider inline-block">
                                        Flash
                                    </span>
                                </div>
                                <!-- Title -->
                                <h3 class="text-base sm:text-lg font-black text-black leading-snug mb-4">
                                    Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola.
                                </h3>
                                <!-- Date -->
                                <p class="text-xs text-gray-600 font-medium mb-6">
                                    Publié le 09 Août 2026
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('login') }}" class="text-sm font-black text-black hover:underline inline-block">
                                    Lire plus
                                </a>
                            </div>
                        </div>

                    </div>

                    <!-- Right Navigation Arrow -->
                    <button @click="next()" aria-label="Next News" class="absolute -right-3 sm:-right-6 lg:-right-8 z-20 text-black hover:text-neutral-700 transition focus:outline-none p-2">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 font-bold" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                </div>

                <!-- More News Button -->
                <div class="text-center mt-10">
                    <a href="{{ route('login') }}" class="text-sm sm:text-base font-black text-black hover:underline inline-block">
                        Plus d'actualité
                    </a>
                </div>

            </div>
        </section>

        <!-- Nos Partenaires Section -->
        <section class="w-full bg-white py-16 lg:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Title -->
                <h2 class="text-2xl sm:text-3xl font-black text-black tracking-tight mb-2">
                    Nos Partenaires
                </h2>
                <!-- Yellow Underline -->
                <div class="w-14 h-1.5 bg-yellow-400 mx-auto mb-10"></div>

                <!-- Logos Container -->
                <div class="flex flex-wrap items-center justify-center gap-10 sm:gap-16 lg:gap-24">
                    <div class="flex items-center justify-center p-2">
                        <img src="{{ asset('images/swiss.jpg') }}" alt="Confédération suisse" class="h-12 sm:h-14 w-auto object-contain">
                    </div>
                    <div class="flex items-center justify-center p-2">
                        <img src="{{ asset('images/swede.png') }}" alt="Suède Sverige" class="h-12 sm:h-14 w-auto object-contain">
                    </div>
                </div>
            </div>
        </section>

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
                                <a href="#apropos" class="text-sm font-bold text-white hover:text-yellow-400 transition">
                                    A propos
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Right Col: Links 2 -->
                    <div class="md:col-span-3">
                        <ul class="space-y-3">
                            <li>
                                <a href="#contact" class="text-sm font-bold text-white hover:text-yellow-400 transition">
                                    Contacte
                                </a>
                            </li>
                            <li>
                                <a href="#actualites" class="text-sm font-bold text-white hover:text-yellow-400 transition">
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

        <!-- Leaflet Map JS Initialization -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof L !== 'undefined') {
                    // Center and frame the map around the Lake Kivu Cross-Border region (Goma, Rubavu, Bukavu, Rusizi, Kamanyola, Cibitoke)
                    var map = L.map('crossBorderMap', {
                        center: [-2.15, 29.15],
                        zoom: 9,
                        zoomControl: true,
                        scrollWheelZoom: false
                    });

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 18,
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>'
                    }).addTo(map);

                    // Cross-Border Points
                    var locations = [
                        // RDC (Red Pins)
                        { name: 'Goma (RDC)', countryName: 'RD Congo', lat: -1.6741, lng: 29.2285, country: 'rdc' },
                        { name: 'Bukavu (RDC)', countryName: 'RD Congo', lat: -2.5085, lng: 28.8608, country: 'rdc' },
                        { name: 'Kamanyola (RDC)', countryName: 'RD Congo', lat: -2.7300, lng: 29.0100, country: 'rdc' },
                        { name: 'Uvira (RDC)', countryName: 'RD Congo', lat: -3.3967, lng: 29.1378, country: 'rdc' },
                        
                        // Rwanda (Green Pins)
                        { name: 'Rubavu / Gisenyi (Rwanda)', countryName: 'Rwanda', lat: -1.6961, lng: 29.2564, country: 'rwanda' },
                        { name: 'Rusizi / Cyangugu (Rwanda)', countryName: 'Rwanda', lat: -2.4839, lng: 28.9075, country: 'rwanda' },
                        { name: 'Bugarama (Rwanda)', countryName: 'Rwanda', lat: -2.7000, lng: 29.0500, country: 'rwanda' },
                        { name: 'Muhanga (Rwanda)', countryName: 'Rwanda', lat: -2.0792, lng: 29.7567, country: 'rwanda' },
                        
                        // Burundi (Blue Pins)
                        { name: 'Mugina / Cibitoke (Burundi)', countryName: 'Burundi', lat: -2.8833, lng: 29.1167, country: 'burundi' },
                        { name: 'Buganda (Burundi)', countryName: 'Burundi', lat: -3.0020, lng: 29.1900, country: 'burundi' },
                        { name: 'Gatumba (Burundi)', countryName: 'Burundi', lat: -3.3278, lng: 29.2500, country: 'burundi' },
                        { name: 'Bujumbura (Burundi)', countryName: 'Burundi', lat: -3.3818, lng: 29.3622, country: 'burundi' }
                    ];

                    locations.forEach(function(loc) {
                        var customIcon = L.divIcon({
                            className: 'custom-pin-container',
                            html: '<div class="custom-pin pin-' + loc.country + '" title="' + loc.name + '"></div>',
                            iconSize: [14, 14],
                            iconAnchor: [7, 7]
                        });

                        var popupContent = '<div class="text-xs">' +
                            '<div class="font-bold text-gray-900">' + loc.name + '</div>' +
                            '<div class="text-[11px] text-gray-500 font-semibold">' + loc.countryName + ' • Marché & Point Frontalier</div>' +
                            '</div>';

                        L.marker([loc.lat, loc.lng], { icon: customIcon })
                            .addTo(map)
                            .bindPopup(popupContent);
                    });
                }
            });
        </script>
    </body>
</html>
