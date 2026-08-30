<x-pahewo-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Aide et FAQ</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm space-y-8">
                @include('pahewo.partials.flash')

                <section>
                    <h3 class="text-lg font-medium text-gray-800">Qu'est-ce que PAHEWO ?</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        PAHEWO est la plateforme de collecte et de suivi des prix des marchandises et des taux de change
                        dans la région. Elle permet aux collecteurs d'enregistrer des données sur le terrain et aux
                        administrateurs de suivre la couverture et la qualité des informations.
                    </p>
                </section>

                <section>
                    <h3 class="text-lg font-medium text-gray-800">Comment enregistrer un prix ?</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Accédez à <strong>Prix journaliers</strong>, cliquez sur « Enregistrer un prix », sélectionnez le marché,
                        la marchandise, la date et le montant observé. Vérifiez la devise avant de valider.
                    </p>
                </section>

                <section>
                    <h3 class="text-lg font-medium text-gray-800">Comment enregistrer un taux de change ?</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Depuis <strong>Taux de change</strong>, indiquez la paire de devises (devise de base et devise de destination),
                        le taux observé et la date. Exemple : 1 USD = 2 850 CDF signifie USD en base et CDF en destination.
                    </p>
                </section>

                <section>
                    <h3 class="text-lg font-medium text-gray-800">Filtrer par pays</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Sur les pages disposant d'un filtre pays, sélectionnez un pays puis cliquez sur « Appliquer ».
                        Seules les données des pays auxquels vous avez accès sont affichées.
                    </p>
                </section>

                <section>
                    <h3 class="text-lg font-medium text-gray-800">Soumettre une réclamation</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Si vous constatez une erreur ou une anomalie, créez une réclamation depuis le menu
                        <strong>Réclamations</strong>. Décrivez le problème et sélectionnez le type approprié.
                    </p>
                </section>

                <section>
                    <h3 class="text-lg font-medium text-gray-800">Changer la langue de l'interface</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Vous pouvez modifier votre langue préférée depuis les paramètres de langue de votre profil.
                        Les libellés traduits des marchandises et catégories s'adaptent à votre choix.
                    </p>
                </section>

                <section>
                    <h3 class="text-lg font-medium text-gray-800">Besoin d'assistance ?</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Contactez votre administrateur national ou le responsable de collecte de votre pays
                        pour toute question sur vos accès, vos marchés assignés ou la procédure de saisie.
                    </p>
                </section>
            </div>
        </div>
    </div>
</x-pahewo-layout>
