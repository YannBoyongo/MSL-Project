<x-public-layout title="Actualités">
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
    <x-breadcrumb :items="['Actualités' => null]" />

    <!-- Main Content Section -->
    <section class="w-full bg-white pb-20 pt-2"
             x-data="{
                 activeFilter: 'all',
                 articles: [
                     {
                         id: 1,
                         type: 'flash',
                         tag: 'Flash',
                         title: 'Fermeture de la frontière de Bukavu en raison de l\'épidémie d\'Ebola.',
                         date: 'Publié le 09 Août 2026',
                         link: '{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}'
                     },
                     {
                         id: 2,
                         type: 'flash',
                         tag: 'Flash',
                         title: 'Fermeture de la frontière de Bukavu en raison de l\'épidémie d\'Ebola.',
                         date: 'Publié le 09 Août 2026',
                         link: '{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}'
                     },
                     {
                         id: 3,
                         type: 'flash',
                         tag: 'Flash',
                         title: 'Fermeture de la frontière de Bukavu en raison de l\'épidémie d\'Ebola.',
                         date: 'Publié le 09 Août 2026',
                         link: '{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}'
                     },
                     {
                         id: 4,
                         type: 'flash',
                         tag: 'Flash',
                         title: 'Fermeture de la frontière de Bukavu en raison de l\'épidémie d\'Ebola.',
                         date: 'Publié le 09 Août 2026',
                         link: '{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}'
                     }
                 ]
             }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-10">
                
                <!-- Left Sidebar: Filter Section -->
                <aside class="md:col-span-4">
                    <div class="bg-white pr-2">
                        <!-- Sidebar Title -->
                        <h3 class="text-sm font-black text-black tracking-tight pb-2 border-b border-gray-200">
                            Filtrer les résultats
                        </h3>

                        <!-- Filter Items List -->
                        <div class="divide-y divide-gray-100 text-xs">
                            <button @click="activeFilter = (activeFilter === 'flash' ? 'all' : 'flash')"
                                    type="button"
                                    class="w-full text-left py-3 font-bold transition flex items-center justify-between group"
                                    :class="activeFilter === 'flash' ? 'text-black' : 'text-gray-800 hover:text-black'">
                                <span class="group-hover:translate-x-0.5 transition-transform">Flash (3)</span>
                            </button>

                            <button @click="activeFilter = (activeFilter === 'event' ? 'all' : 'event')"
                                    type="button"
                                    class="w-full text-left py-3 font-bold transition flex items-center justify-between group"
                                    :class="activeFilter === 'event' ? 'text-black' : 'text-gray-800 hover:text-black'">
                                <span class="group-hover:translate-x-0.5 transition-transform">Evénement (3)</span>
                            </button>

                            <button @click="activeFilter = (activeFilter === 'press' ? 'all' : 'press')"
                                    type="button"
                                    class="w-full text-left py-3 font-bold transition flex items-center justify-between group"
                                    :class="activeFilter === 'press' ? 'text-black' : 'text-gray-800 hover:text-black'">
                                <span class="group-hover:translate-x-0.5 transition-transform">Communiqués de presse(3)</span>
                            </button>
                        </div>
                    </div>
                </aside>

                <!-- Right Main Area: Article Cards List -->
                <main class="md:col-span-8">
                    <div class="space-y-4">
                        <template x-for="article in articles" :key="article.id">
                            <article class="bg-white border border-gray-200 p-5 sm:p-6 shadow-sm hover:border-gray-300 transition"
                                     x-show="activeFilter === 'all' || activeFilter === article.type">
                                <!-- Tag -->
                                <div class="mb-3">
                                    <span class="border border-black px-2 py-0.5 text-[10px] font-bold text-black uppercase tracking-wider inline-block"
                                          x-text="article.tag">
                                        Flash
                                    </span>
                                </div>

                                <!-- Article Title -->
                                <h2 class="text-sm sm:text-base font-black text-black leading-snug tracking-tight mb-2"
                                    x-text="article.title">
                                    Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola.
                                </h2>

                                <!-- Publication Date -->
                                <p class="text-[11px] text-gray-600 font-medium mb-4"
                                   x-text="article.date">
                                    Publié le 09 Août 2026
                                </p>

                                <!-- Read More Link -->
                                <div>
                                    <a :href="article.link" class="text-xs font-black text-black hover:underline inline-block">
                                        Lire plus
                                    </a>
                                </div>
                            </article>
                        </template>
                    </div>

                    <!-- Static fallback for non-JS/SSR and testing assertions -->
                    <noscript>
                        <div class="space-y-4">
                            @for($i = 0; $i < 4; $i++)
                                <article class="bg-white border border-gray-200 p-5 sm:p-6 shadow-sm">
                                    <div class="mb-3">
                                        <span class="border border-black px-2 py-0.5 text-[10px] font-bold text-black uppercase tracking-wider inline-block">
                                            Flash
                                        </span>
                                    </div>
                                    <h2 class="text-sm sm:text-base font-black text-black leading-snug tracking-tight mb-2">
                                        Fermeture de la frontière de Bukavu en raison de l'épidémie d'Ebola.
                                    </h2>
                                    <p class="text-[11px] text-gray-600 font-medium mb-4">
                                        Publié le 09 Août 2026
                                    </p>
                                    <div>
                                        <a href="{{ route('news.show', 'fermeture-frontiere-bukavu-ebola') }}" class="text-xs font-black text-black hover:underline inline-block">
                                            Lire plus
                                        </a>
                                    </div>
                                </article>
                            @endfor
                        </div>
                    </noscript>

                    <!-- Plus d'actualités Button -->
                    <div class="mt-8">
                        <button type="button"
                                class="inline-flex items-center justify-center bg-yellow-400 hover:bg-yellow-500 text-black font-black text-xs uppercase tracking-wider px-6 py-2.5 transition shadow-sm">
                            Plus d'actualités
                        </button>
                    </div>
                </main>

            </div>
        </div>
    </section>
</x-public-layout>
