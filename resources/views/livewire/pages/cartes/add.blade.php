<div x-data="{ 
    Card: @entangle('Card'),
    calledDeckForm: false,
    hasDecks: @json($Decks->isNotEmpty()), 
    openModal() { this.calledDeckForm = true }, 
    closeModal() { this.calledDeckForm = false },
    selectedType: 'Pakettyp',
    selectedDeck: 'Wählen Sie ein Paket aus',
    }"> 
    <x-form intitule=" {{ $targetCardId ? 'Karte aktualisieren: '.$targetCardId :'Neue Karte ' }}" class="p-2 flex flex-col gap-2">
        <div class="flex justify-evenly items-center gap-2 bg-black/10 rounded-lg py-3" x-data="{ showDeck: true}" >
            <div>
                <x-dropdown align="left" width="48" id="typeCard" >
                    <x-slot name="trigger">
                        <button type="button" class="inline-flex items-center px-3 py-2.5 border border-transparent text-sm leading-4 font-medium rounded-md text-black/60 bg-gray-100 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div x-text="selectedType"></div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        @foreach ($cardTypes as $cardType )
                            <x-dropdown-link @click="selectedType='{{ $cardType['type'] }}'; Card.type='{{ $cardType['type'] }}'; console.log(Card)"> {{ $cardType['type'] }}</x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div>
           
            <div>
                <x-dropdown align="right" width="48" id="typeDeck" >
                    <x-slot name="trigger">
                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black/60 bg-gray-100 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div x-text="selectedDeck"></div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        @foreach ($Decks as $Deck)
                            <x-dropdown-link @click="selectedDeck='{{ $Deck->name }}'; Card.paquet={{ $Deck->id }}; console.log(Card)"> {{ $Deck->name }}</x-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div>
            <div class="">
                <button type="button" @click="openModal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Stapel erstellen
                </button>
                <div x-show="calledDeckForm">
                    <x-modal show="calledDeckForm" name='Nouveau Paquet' @close="closeModal" title="Créer un nouveau paquet">
                        <!-- Hier können Sie die Komponente aufrufen, die die Pakete erstellt -->
                        <livewire:forms.deck wire:key="{{ str()->random(17) }}" />
                        <button @click=" calledDeckForm=false"> 
                            <i class="ri-close-fill absolute top-2 end-2"></i>
                        </button>
                    </x-modal>
                </div>
            </div>
        </div>
        <x-textarea name='question' label="Frage" requis="true" modele='Card.question' ligne=1 value="Card.question">
            Ex: was ist Java ?
        </x-textarea>
        <x-field label='Antwort' name='answer' modele="Card.answer" requis="true" value="Card.answer" class="w-full text-black/85 font-semibold text-sm placeholeder-black/70 ">
            Ex: eine Programmiersprache
        </x-field>
        <hr class="my-1 bg-slate-50 border-1 border-white" />
        <div class="flex gap-4 justify-end items-center mt-3">
            <x-action methodeWire="saveCard" color="red" class="capitalize p-2 hover:bg-blue-500 border border-blue-500 rounded-lg text-base">
                save
            </x-action>
            <x-action methods="calledDeckForm = false;" time=500 methodeWire="clearForm" color="red" class="capitalize text-base p-2 hover:bg-red-500 text-white/80 rounded-lg border border-red-500">
                clear
            </x-action>
        </div>
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
    </x-form>
</div>
