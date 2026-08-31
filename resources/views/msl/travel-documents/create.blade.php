<x-msl-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouveau document de voyage</h2></x-slot>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <x-form-tip title="Comment ajouter un document de voyage ?" :items="['Sélectionnez le pays concerné.', 'Choisissez le type de document.', 'Indiquez s\'il est obligatoire.', 'Ajoutez les conditions ou exigences applicables.', 'Ajoutez les frais uniquement s\'ils sont officiellement connus.', 'Sélectionnez la devise correspondant aux frais.', 'Fournissez des informations claires et à jour.']" />
                <form method="POST" action="{{ route('msl.travel-documents.store') }}" class="space-y-4">
                    @csrf
                    <div><x-input-label for="country_id" value="Pays *" /><select id="country_id" name="country_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><option value="">-</option>@foreach($countries as $c)<option value="{{ $c->id }}" @selected(old('country_id', $countryId)==$c->id)>{{ $c->name }}</option>@endforeach</select></div>
                    <div><x-input-label for="document_type_id" value="Type *" /><select id="document_type_id" name="document_type_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">@foreach($documentTypes as $t)<option value="{{ $t->id }}" @selected(old('document_type_id')==$t->id)>{{ $t->translate_name ?? $t->code }}</option>@endforeach</select></div>
                    <div><x-input-label for="language_id" value="Langue *" /><select id="language_id" name="language_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">@foreach($languages as $l)<option value="{{ $l->id }}" @selected(old('language_id')==$l->id)>{{ $l->name }}</option>@endforeach</select></div>
                    <div><x-input-label for="title" value="Titre *" /><x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title')" required /></div>
                    <div><x-input-label for="description" value="Description" /><textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea></div>
                    <label class="flex items-center gap-2"><input type="checkbox" name="is_required" value="1"> Obligatoire</label>
                    <x-primary-button>Enregistrer</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-msl-layout>

