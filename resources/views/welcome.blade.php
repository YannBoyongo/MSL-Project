<x-public-layout>
    <!-- Hero Slider Section -->
    <section class="relative w-full min-h-[540px] lg:min-h-[600px] xl:min-h-[640px] bg-cover bg-center bg-no-repeat flex items-center overflow-hidden"
             style="background-image: url('{{ asset('images/Picture1.jpg') }}');"
             x-data="{
                 activeSlide: 0,
                 totalSlides: 3,
                 autoplayInterval: null,
                 startAutoplay() {
                     this.stopAutoplay();
                     this.autoplayInterval = setInterval(() => {
                         this.next();
                     }, 6000);
                 },
                 stopAutoplay() {
                     if (this.autoplayInterval) {
                         clearInterval(this.autoplayInterval);
                         this.autoplayInterval = null;
                     }
                 },
                 prev() {
                     this.activeSlide = (this.activeSlide === 0) ? this.totalSlides - 1 : this.activeSlide - 1;
                 },
                 next() {
                     this.activeSlide = (this.activeSlide === this.totalSlides - 1) ? 0 : this.activeSlide + 1;
                 },
                 goTo(index) {
                     this.activeSlide = index;
                 }
             }"
             x-init="startAutoplay()"
             @mouseenter="stopAutoplay()"
             @mouseleave="startAutoplay()">
        <!-- Background Tint / Overlay -->
        <div class="absolute inset-0 bg-black/35 z-0"></div>

        <!-- Left Slider Arrow -->
        <button @click="prev()"
                aria-label="Slide précédente"
                class="absolute left-3 sm:left-6 lg:left-8 z-30 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full bg-black/40 hover:bg-black/75 text-white border border-white/20 transition backdrop-blur-sm focus:outline-none shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Right Slider Arrow -->
        <button @click="next()"
                aria-label="Slide suivante"
                class="absolute right-3 sm:right-6 lg:right-8 z-30 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full bg-black/40 hover:bg-black/75 text-white border border-white/20 transition backdrop-blur-sm focus:outline-none shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Slides Container -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 sm:px-14 lg:px-16 py-12 lg:py-16 w-full">
            
            <!-- Slide 1 -->
            <div x-show="activeSlide === 0"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak>
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
                                <a href="{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}" class="inline-flex items-center justify-center bg-black hover:bg-neutral-900 text-yellow-400 font-black text-xs uppercase tracking-wider px-5 py-2.5 transition">
                                    LIRE PLUS
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Notre Projet Content -->
                    <div class="lg:col-span-6 xl:col-span-7 lg:pl-10 text-white">
                        <div class="max-w-lg ml-auto">
                            <h1 class="text-3xl sm:text-4xl lg:text-[44px] font-black text-white tracking-tight leading-tight mb-4 drop-shadow-md">
                                Notre Projet
                            </h1>
                            <p class="text-xs sm:text-sm text-white/95 font-medium leading-relaxed mb-6 drop-shadow">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <div>
                                <a href="{{ route('about') }}" class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-black font-black text-xs uppercase tracking-wider px-7 py-3 transition shadow-md">
                                    APROPOS
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div x-show="activeSlide === 1"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak>
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
                                Harmonisation des régimes commerciaux et facilitation douanière.
                            </h2>
                            <!-- News Excerpt -->
                            <p class="text-xs sm:text-sm text-gray-800 font-medium leading-relaxed mb-6">
                                Mise en place de procédures simplifiées aux postes frontières pour encourager le petit commerce transfrontalier et sécuriser les revenus des commerçantes locales.
                            </p>
                            <!-- Read More Button -->
                            <div>
                                <a href="{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}" class="inline-flex items-center justify-center bg-black hover:bg-neutral-900 text-yellow-400 font-black text-xs uppercase tracking-wider px-5 py-2.5 transition">
                                    LIRE PLUS
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Notre Projet Content -->
                    <div class="lg:col-span-6 xl:col-span-7 lg:pl-10 text-white">
                        <div class="max-w-lg ml-auto">
                            <h1 class="text-3xl sm:text-4xl lg:text-[44px] font-black text-white tracking-tight leading-tight mb-4 drop-shadow-md">
                                Mupaka Shamba Letu
                            </h1>
                            <p class="text-xs sm:text-sm text-white/95 font-medium leading-relaxed mb-6 drop-shadow">
                                Renforcement de la cohésion sociale entre les communautés riveraines et soutien direct aux associations villageoises d'épargne et de crédit (AVEC) et commerçantes transfrontalières.
                            </p>
                            <div>
                                <a href="{{ route('about') }}" class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-black font-black text-xs uppercase tracking-wider px-7 py-3 transition shadow-md">
                                    APROPOS
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div x-show="activeSlide === 2"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 x-cloak>
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
                                Actualisation quotidienne des prix et taux de change frontaliers.
                            </h2>
                            <!-- News Excerpt -->
                            <p class="text-xs sm:text-sm text-gray-800 font-medium leading-relaxed mb-6">
                                Consultez en temps réel l'évolution des prix sur les marchés de Goma, Bukavu, Rubavu et Cibitoke pour des échanges commerciaux transparents et équitables.
                            </p>
                            <!-- Read More Button -->
                            <div>
                                <a href="{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}" class="inline-flex items-center justify-center bg-black hover:bg-neutral-900 text-yellow-400 font-black text-xs uppercase tracking-wider px-5 py-2.5 transition">
                                    LIRE PLUS
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Notre Projet Content -->
                    <div class="lg:col-span-6 xl:col-span-7 lg:pl-10 text-white">
                        <div class="max-w-lg ml-auto">
                            <h1 class="text-3xl sm:text-4xl lg:text-[44px] font-black text-white tracking-tight leading-tight mb-4 drop-shadow-md">
                                Commerce Pour La Paix
                            </h1>
                            <p class="text-xs sm:text-sm text-white/95 font-medium leading-relaxed mb-6 drop-shadow">
                                Une plateforme interactive dédiée à la transparence des prix, à la gestion des plaintes et au dialogue transfrontalier dans toute la région des Grands Lacs.
                            </p>
                            <div>
                                <a href="{{ route('about') }}" class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-black font-black text-xs uppercase tracking-wider px-7 py-3 transition shadow-md">
                                    APROPOS
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Bottom Pagination Indicator Dots -->
        <div class="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 z-30 flex items-center space-x-2.5">
            <button @click="goTo(0)"
                    aria-label="Slide 1"
                    class="h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                    :class="activeSlide === 0 ? 'w-8 bg-yellow-400' : 'w-2.5 bg-white/60 hover:bg-white'">
            </button>
            <button @click="goTo(1)"
                    aria-label="Slide 2"
                    class="h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                    :class="activeSlide === 1 ? 'w-8 bg-yellow-400' : 'w-2.5 bg-white/60 hover:bg-white'">
            </button>
            <button @click="goTo(2)"
                    aria-label="Slide 3"
                    class="h-2.5 rounded-full transition-all duration-300 focus:outline-none"
                    :class="activeSlide === 2 ? 'w-8 bg-yellow-400' : 'w-2.5 bg-white/60 hover:bg-white'">
            </button>
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
                <a href="{{ route('about') }}" class="inline-block border border-black px-7 py-2.5 bg-white hover:bg-black hover:text-white text-xs font-bold uppercase tracking-wider text-black transition shadow-sm">
                    A propos
                </a>
            </div>
        </div>
    </section>

    <!-- Impact Counter / Statistics Section with Animated Counters -->
    <section class="relative w-full bg-cover bg-center bg-no-repeat py-16 lg:py-24 overflow-hidden"
             style="background-image: url('{{ asset('images/Picture1.jpg') }}');"
             x-data="{
                 hasAnimated: false,
                 stats: [
                     { id: 'fpcts', target: 6000, current: 0 },
                     { id: 'avecs', target: 4500, current: 0 },
                     { id: 'plaintes', target: 2300, current: 0 },
                     { id: 'entrepreneurs', target: 800, current: 0 }
                 ],
                 init() {
                     const observer = new IntersectionObserver((entries) => {
                         entries.forEach(entry => {
                             if (entry.isIntersecting && !this.hasAnimated) {
                                 this.hasAnimated = true;
                                 this.animateCounters();
                             }
                         });
                     }, { threshold: 0.2 });
                     observer.observe(this.$el);
                 },
                 animateCounters() {
                     const duration = 2000;
                     const startTime = performance.now();
                     
                     const step = (currentTime) => {
                         const elapsed = currentTime - startTime;
                         const progress = Math.min(elapsed / duration, 1);
                         const easeOut = 1 - Math.pow(1 - progress, 3);
                         
                         this.stats.forEach(stat => {
                             stat.current = Math.floor(easeOut * stat.target);
                         });
                         
                         if (progress < 1) {
                             requestAnimationFrame(step);
                         } else {
                             this.stats.forEach(stat => {
                                 stat.current = stat.target;
                             });
                         }
                     };
                     requestAnimationFrame(step);
                 }
             }">
        <!-- Dark Overlay for High Contrast Stats with subtle gradient -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/75 via-black/65 to-black/80 z-0"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8 lg:gap-12 text-center">
                
                <!-- Stat 1: FPCTS -->
                <div class="group p-4 sm:p-6 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:bg-white/5 backdrop-blur-[1px]"
                     :class="hasAnimated ? 'opacity-100 translate-y-0 scale-100' : 'opacity-85 translate-y-3 scale-95'"
                     style="transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.1s;">
                    <p class="text-xs sm:text-sm font-black text-white/90 uppercase tracking-widest mb-3 transition-colors group-hover:text-yellow-400">
                        FPCTS
                    </p>
                    <p class="text-4xl sm:text-5xl lg:text-6xl font-black text-yellow-400 tracking-tight drop-shadow-md group-hover:drop-shadow-[0_4px_25px_rgba(250,204,21,0.6)] transition-all">
                        <span x-text="hasAnimated ? stats[0].current + '+' : '6000+'">6000+</span>
                    </p>
                </div>

                <!-- Stat 2: AVECs -->
                <div class="group p-4 sm:p-6 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:bg-white/5 backdrop-blur-[1px]"
                     :class="hasAnimated ? 'opacity-100 translate-y-0 scale-100' : 'opacity-85 translate-y-3 scale-95'"
                     style="transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.2s;">
                    <p class="text-xs sm:text-sm font-black text-white/90 uppercase tracking-widest mb-3 transition-colors group-hover:text-yellow-400">
                        AVECs
                    </p>
                    <p class="text-4xl sm:text-5xl lg:text-6xl font-black text-yellow-400 tracking-tight drop-shadow-md group-hover:drop-shadow-[0_4px_25px_rgba(250,204,21,0.6)] transition-all">
                        <span x-text="hasAnimated ? stats[1].current + '+' : '4500+'">4500+</span>
                    </p>
                </div>

                <!-- Stat 3: Plaintes/Feedback -->
                <div class="group p-4 sm:p-6 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:bg-white/5 backdrop-blur-[1px]"
                     :class="hasAnimated ? 'opacity-100 translate-y-0 scale-100' : 'opacity-85 translate-y-3 scale-95'"
                     style="transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.3s;">
                    <p class="text-xs sm:text-sm font-black text-white/90 uppercase tracking-widest mb-3 transition-colors group-hover:text-yellow-400">
                        Plaintes/Feedback
                    </p>
                    <p class="text-4xl sm:text-5xl lg:text-6xl font-black text-yellow-400 tracking-tight drop-shadow-md group-hover:drop-shadow-[0_4px_25px_rgba(250,204,21,0.6)] transition-all">
                        <span x-text="hasAnimated ? stats[2].current + '+' : '2300+'">2300+</span>
                    </p>
                </div>

                <!-- Stat 4: Jeunes Entrepreneurs -->
                <div class="group p-4 sm:p-6 rounded-2xl transition-all duration-300 transform hover:-translate-y-2 hover:bg-white/5 backdrop-blur-[1px]"
                     :class="hasAnimated ? 'opacity-100 translate-y-0 scale-100' : 'opacity-85 translate-y-3 scale-95'"
                     style="transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1) 0.4s;">
                    <p class="text-xs sm:text-sm font-black text-white/90 uppercase tracking-widest mb-3 transition-colors group-hover:text-yellow-400">
                        Jeunes Entrepreneurs
                    </p>
                    <p class="text-4xl sm:text-5xl lg:text-6xl font-black text-yellow-400 tracking-tight drop-shadow-md group-hover:drop-shadow-[0_4px_25px_rgba(250,204,21,0.6)] transition-all">
                        <span x-text="hasAnimated ? stats[3].current + '+' : '800+'">800+</span>
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
                            <a href="{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}" class="text-sm font-black text-black hover:underline inline-block">
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
                            <a href="{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}" class="text-sm font-black text-black hover:underline inline-block">
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
                            <a href="{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}" class="text-sm font-black text-black hover:underline inline-block">
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
                <a href="{{ route('news') }}" class="text-sm sm:text-base font-black text-black hover:underline inline-block">
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

    @push('scripts')
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
    @endpush
</x-public-layout>
