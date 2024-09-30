<div x-data="{ Deck: @entangle('Deck')}" class="flex flex-col gap-2">
    <x-form intitule="{{ $targetDeckId ? 'Paket aktualisieren: '.$Deck['name'] :'Neu Stapel' }}" class="m-1 p-3 ">
        <x-field hide='no' label='Name' name='paquetName' modele="Deck.name" class="w-full  font-semibold text-sm  placeholeder-black/85 text-black/85 bg-slate-100">
            Ex: Englisch
        </x-field>
        <x-textarea name='description' label="Kurze Beschreibung" modele="Deck.description" ligne=1 >
            Ex: Dieses Paket ist für Englisch-Lernkarten bestimmt
        </x-textarea>
        <x-field hide='yes' disabled="true" label='Propriétaire' name='proprietaire' modele="Deck.proprietaire" value="Deck.proprietaire" class="w-full text-black/85 font-semibold text-sm  placeholeder-black/70 bg-slate-100">
            Ersteller
        </x-field>
         <hr class="my-1 bg-slate-50 border-2 border-white" />
        <div class="flex gap-4 justify-end items-center mt-3">
            <x-action methods=' ' methodeWire='saveDeck' class="capitalize p-2 hover:bg-blue-500 border border-blue-500 rounded-lg text-base">
                save
            </x-action>
            <x-action methods='calledDeckForm = false;' time=300 methodeWire='' color="red" class="capitalize text-base p-2 hover:bg-red-500 text-white/80 rounded-lg border border-red-500">
                clear
            </x-action>
        </div>
    </x-form> 
    @if (session()->has('success'))
        <div class="my-2 p-2 ">
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        </div>
    @elseif (session()->has('echec'))
        <div class="my-2 p-2 ">
            <x-alert type="echec">
                {{ session('echec') }}
            </x-alert>
        </div>
    @endif        
</div>
