<x-public-layout title="A propos">
    <!-- Header Banner with breadcomb image -->
    <div class="relative w-full h-48 sm:h-56 md:h-64 lg:h-72 bg-cover bg-center flex items-end"
         style="background-image: url('{{ asset('images/breadcomb.png') }}');">
        <!-- Badge at the bottom left -->
        <div class="max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 pb-6">
            <div class="inline-block bg-black text-white text-xs sm:text-sm font-bold px-4 py-2 uppercase tracking-wider">
                A propos
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <x-breadcrumb :items="['A propos' => null]" />

    <!-- Main Content Section -->
    <section class="w-full bg-white pb-20 pt-2">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Main Title -->
            <h1 class="text-2xl sm:text-3xl font-black text-black tracking-tight mb-8">
                Mupaka : un exemple de l'approche NEXUS
            </h1>

            <!-- Section 1: Objectif principal -->
            <div class="mb-8">
                <h2 class="text-lg sm:text-xl font-bold text-black tracking-tight mb-3">
                    Objectif principal
                </h2>
                <p class="text-xs sm:text-sm text-gray-800 font-medium leading-relaxed mb-4">
                    L'objectif ultime et l'ambition du projet MSL II restent le renforcement de la cohésion sociale entre les communautés transfrontalières et de la stabilité dans la région des Grands Lacs
                </p>
                <p class="text-xs sm:text-sm text-gray-800 font-medium leading-relaxed">
                    Le projet MSLII, tel que adapté en juin 2025, incarne une approche nexus en intégrant la réponse aux besoins immédiats (humanitaire), le renforcement de la résilience à long terme (développement) et la création des bases pour la paix future, le tout en étant sensible au contexte de conflit.
                </p>
            </div>

            <!-- Section 2: Approche -->
            <div class="mb-8">
                <h2 class="text-lg sm:text-xl font-bold text-black tracking-tight mb-3">
                    Approche
                </h2>
                <div class="space-y-4 text-xs sm:text-sm text-gray-800 font-medium leading-relaxed">
                    <p>
                        <span class="font-bold text-black">•Réponse aux nouveaux besoins immédiats (Humanitaire) :</span> Le projet MSLII prend en compte les 'nouveaux besoins immédiats' des communautés affectées par les conflits à l'est de la RDC telles que la guérison des traumatismes ce qui souligne une composante de réponse humanitaire rapide et flexible.
                    </p>
                    <p>
                        <span class="font-bold text-black">•Renforcement des mécanismes de résilience (Développement) :</span> L'approche vise aussi à 'contribuer au renforcement des mécanismes de résilience économique des communautés'. Cela met l'accent sur des activités de relèvement économique et d'amélioration de la capacité des communautés à faire face aux chocs.
                    </p>
                </div>
            </div>

            <!-- Section 3: Adaptations -->
            <div class="mb-8">
                <h2 class="text-lg sm:text-xl font-bold text-black tracking-tight mb-3">
                    Adaptations
                </h2>
                <div class="space-y-4 text-xs sm:text-sm text-gray-800 font-medium leading-relaxed">
                    <p>
                        <span class="font-bold text-black">•Résilience économique et mentale (Développement/Humanitaire) :</span> Les activités du projet travaillent spécifiquement sur la 'résilience économique et mentale de ces groupes vulnérables'. Cela touche à la fois des aspects de développement (autonomisation économique) et des aspects humanitaires (soutien psychologique suite au choc).
                    </p>
                    <p>
                        <span class="font-bold text-black">•Contribution à la construction de la paix (Paix) :</span> Le projet établit un lien direct entre la capacité des communautés à surmonter les chocs actuels et leur 'chance de participer à la construction de la paix à l'avenir'. Le projet vise à créer des conditions propices à la paix future en abordant les besoins actuels.
                    </p>
                    <p>
                        <span class="font-bold text-black">•Sensibilité aux conflits :</span> MSL II reste un projet sensible aux conflits. Il s'adapte aux nouveaux besoins et reconnait l'importance de ne pas exacerber les tensions existantes et d'opérer de manière à soutenir la paix.
                    </p>
                </div>
            </div>

        </div>
    </section>
</x-public-layout>
