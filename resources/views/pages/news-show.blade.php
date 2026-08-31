<x-public-layout title="Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola">
    <!-- Header Banner with breadcomb image -->
    <div class="relative w-full h-48 sm:h-56 md:h-64 lg:h-72 bg-cover bg-center flex items-end"
         style="background-image: url('{{ asset('images/breadcomb.png') }}');">
        <!-- Badge at the bottom left -->
        <div class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 pb-6">
            <div class="inline-block bg-black text-white text-xs sm:text-sm font-bold px-4 py-2 uppercase tracking-wider">
                Actualités
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <x-breadcrumb :items="['Actualités' => route('news'), 'Détail actualité' => null]" />

    <!-- Main Content Section -->
    <section class="w-full bg-white pb-20 pt-2">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-10">
                
                <!-- Left Sidebar: Categories & Recent Items -->
                <aside class="md:col-span-4 space-y-6">
                    <div class="bg-white pr-2">
                        <!-- Back Button -->
                        <a href="{{ route('news') }}"
                           class="inline-flex items-center space-x-2 text-xs font-bold text-gray-700 hover:text-black transition mb-5 pb-3 border-b border-gray-100 w-full group">
                            <svg class="w-4 h-4 text-black transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Retour aux actualités</span>
                        </a>

                        <!-- Sidebar Title -->
                        <h3 class="text-sm font-black text-black tracking-tight pb-2 border-b border-gray-200">
                            Catégories
                        </h3>

                        <!-- Filter List Links -->
                        <div class="divide-y divide-gray-100 text-xs">
                            <a href="{{ route('news') }}" class="py-3 font-bold text-gray-800 hover:text-black flex items-center justify-between group transition">
                                <span class="group-hover:translate-x-0.5 transition-transform">Flash (3)</span>
                            </a>
                            <a href="{{ route('news') }}" class="py-3 font-bold text-gray-800 hover:text-black flex items-center justify-between group transition">
                                <span class="group-hover:translate-x-0.5 transition-transform">Evénement (3)</span>
                            </a>
                            <a href="{{ route('news') }}" class="py-3 font-bold text-gray-800 hover:text-black flex items-center justify-between group transition">
                                <span class="group-hover:translate-x-0.5 transition-transform">Communiqués de presse (3)</span>
                            </a>
                        </div>
                    </div>

                    <!-- Recent News Box -->
                    <div class="bg-gray-50 border border-gray-200 p-4">
                        <h4 class="text-xs font-black uppercase tracking-wider text-black mb-3 pb-1 border-b border-gray-200">
                            Articles récents
                        </h4>
                        <ul class="space-y-3 text-xs">
                            <li>
                                <a href="{{ route('news.show', 'harmonisation-regimes-commerciaux') }}" class="font-bold text-black hover:underline block leading-snug">
                                    Harmonisation des régimes commerciaux et facilitation douanière.
                                </a>
                                <span class="text-[10px] text-gray-500 font-medium">08 Août 2026</span>
                            </li>
                            <li class="pt-2 border-t border-gray-100">
                                <a href="{{ route('news.show', 'actualisation-quotidienne-prix') }}" class="font-bold text-black hover:underline block leading-snug">
                                    Actualisation quotidienne des prix et taux de change frontaliers.
                                </a>
                                <span class="text-[10px] text-gray-500 font-medium">05 Août 2026</span>
                            </li>
                        </ul>
                    </div>
                </aside>

                <!-- Right Main Area: Article Details -->
                <main class="md:col-span-8">
                    <article class="bg-white">
                        <!-- Tag Badge -->
                        <div class="mb-3">
                            <span class="border border-black px-2.5 py-0.5 text-[11px] font-bold text-black uppercase tracking-wider inline-block">
                                Flash
                            </span>
                        </div>

                        <!-- Article Headline -->
                        <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-black leading-tight tracking-tight mb-3">
                            Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola.
                        </h1>

                        <!-- Publication Meta Information -->
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600 font-medium pb-5 mb-6 border-b border-gray-200">
                            <span>Publié le 09 Août 2026</span>
                            <span>•</span>
                            <span>Frontière RDC - Rwanda (Poste Ruzizi I & II)</span>
                            <span>•</span>
                            <span class="font-bold text-black">MSL Info Frontière</span>
                        </div>

                        <!-- Article Body -->
                        <div class="space-y-4 text-xs sm:text-sm text-gray-800 font-medium leading-relaxed">
                            <p>
                                Les autorités sanitaires et administratives ont annoncé une restriction temporaire des flux transfrontaliers au poste de Bukavu suite à la détection de cas suspects dans la zone sanitaire environnante. Cette mesure préventive vise à endiguer la propagation du virus et à renforcer les protocoles de surveillance sanitaire.
                            </p>

                            <!-- Alert Box with Theme Color -->
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 my-6">
                                <h4 class="font-bold text-black text-xs uppercase tracking-wider mb-1">
                                    Consignes pour les commerçants transfrontaliers :
                                </h4>
                                <ul class="list-disc list-inside space-y-1 text-xs text-gray-800">
                                    <li>Respect strict des points de lavage des mains et contrôles de température.</li>
                                    <li>Privilégier les formalités douanières déclarées électroniquement via la plateforme.</li>
                                    <li>Contacter les agents de liaison MSL en cas de difficultés aux points de passage.</li>
                                </ul>
                            </div>

                            <h2 class="text-base sm:text-lg font-bold text-black tracking-tight pt-2">
                                Mesures d'accompagnement et continuité des échanges
                            </h2>

                            <p>
                                Afin de minimiser l'impact économique sur les petits commerçants transfrontaliers et les associations membres des AVECs, un couloir sanitaire sécurisé reste opérationnel pour l'acheminement des produits vivriers et des denrées de première nécessité sous contrôle médical renforcé.
                            </p>

                            <p>
                                La cellule de veille du projet <strong>Mupaka Shamba Letu</strong> suit de près l'évolution de la situation en coordination avec les comités transfrontaliers de paix et les autorités locales de la RDC et du Rwanda. Tout changement relatif aux horaires et conditions d'accès sera communiqué en temps réel sur la plateforme.
                            </p>
                        </div>

                        <!-- Social Share Section -->
                        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center space-x-3">
                                <span class="text-xs font-bold text-gray-700">Partager :</span>
                                <!-- X -->
                                <a href="https://x.com" target="_blank" rel="noopener noreferrer" aria-label="Partager sur X"
                                   class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-yellow-400 hover:text-black text-gray-700 transition">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </a>
                                <!-- LinkedIn -->
                                <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="Partager sur LinkedIn"
                                   class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-yellow-400 hover:text-black text-gray-700 transition">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.2V10.9H6.46M7.83 6.5a1.64 1.64 0 0 0-1.64 1.64c0 .9.74 1.64 1.64 1.64s1.64-.74 1.64-1.64c0-.9-.74-1.64-1.64-1.64Z"/>
                                    </svg>
                                </a>
                                <!-- Facebook -->
                                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Partager sur Facebook"
                                   class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-yellow-400 hover:text-black text-gray-700 transition">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/>
                                    </svg>
                                </a>
                            </div>

                            <div>
                                <a href="{{ route('news') }}"
                                   class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-black font-black text-xs uppercase tracking-wider px-6 py-2.5 transition shadow-sm">
                                    Toutes les actualités
                                </a>
                            </div>
                        </div>
                    </article>
                </main>

            </div>
        </div>
    </section>
</x-public-layout>
