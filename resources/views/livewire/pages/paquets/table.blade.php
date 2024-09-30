<div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg " x-data="{
    closeModal (){
        modalConfirm=false; 
        callDeckConfirmDeleting=false; 
        calledDeckEditForm=false;
    }
    }">
    {{-- {{ $Decks }} --}}
    <div class="flex justify-between items-center">
        <x-action methods="console.log('refreshed');" time=1000 wMsg=false methodeWire='freshDecks' class="mt-2 p-2 outline outline-violet-800 text-violet-300 rounded-lg hover:bg-violet-800 hover:text-white/85 " spinerClass="border-yello-600 bg-transparent">
            refresh <i class="ri-refresh-line ml-2"></i>
        </x-action>
        <span class="p-2 ml-2 text-violet-300 font-semibold">Anzahl Stapel: {{ count($Decks) }}</span>
    </div>
    <table class="w-full text-sm text-left my-2 py-2 rtl:text-right text-gray-400">
        <thead class="text-xs uppercase text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 bg-black/15">
                    Stapel
                </th>
                <th scope="col" class="px-6 py-3 bg-black/15">
                   Neu
                </th>
                <th scope="col" class="px-6 py-3 bg-black/15">
                   Wiederholen
                </th>
                <th scope="col" class="px-6 py-3 bg-black/15">
                    Gelernt
                </th>
                <th scope="col" class="px-6 py-3 text-center bg-black/15">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ( $Decks as $Deck )
                <tr class="border-b border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white bg-black/15">
                        <a  data-tooltip-target="tooltip-right" data-tooltip-placement="right" 
                            type="button"
                            x-tooltip.placement.top-end.success="'Paquet par défaut'"
                            href="{{ route('revision', ['slug' => $Deck->slug]) }}" class="underline">
                            {{ $Deck->name }}
                        </a>
                        <div id="tooltip-right" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            {{ $Deck->description }}
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </th>
                    <td class="font-bold px-6 py-4 text-blue-700">
                        {{ $Deck->getUnreviewedCardsCountForUser(auth()->id()) }}
                    </td>
                    <td class="font-bold px-6 py-4 text-red-600 bg-black/15">
                        {{ $Deck->getToReviewCardsCountForUser(auth()->id()) }}
                    </td>
                    <td class="font-bold px-6 py-4 text-green-600">
                        {{ $Deck->getReviewedCardsCountForUser(auth()->id()) }}
                    </td>
                    <td class="font-bold px-6 py-4 flex justify-evenly items-start gap-1 bg-black/15" x-data="{ modalConfirm: false, calledDeckEditForm: false, callDeckConfirmDeleting: false}">
                        <a href="{{ route('cartes') }}">
                            <x-action methods=' ' wMsg=false color='blue' class="text-violet-600">
                                <i class="ri-add-large-line"></i>
                            </x-action>
                        </a>
                        <x-action methods="modalConfirm=true; calledDeckEditForm=true; callDeckConfirmDeleting=false;" wMsg=false time=1000 color='red' class="text-violet-300" spinerClass="border-blue-600">
                            <i class="ri-file-edit-line"></i>
                        </x-action>
                       
                        <x-action methods='modalConfirm=true;calledDeckEditForm=false; callDeckConfirmDeleting=true;' wMsg=false time=2000 color='red' class="text-red-400">
                            <i class="ri-delete-bin-6-line"></i>                         
                        </x-action>
                        <div x-show="modalConfirm">
                            <x-modal show="modalConfirm" name='Supression de carte' @close="closeModal()" title="Suprimer une carte">
                                <button @click="modalConfirm=false"> 
                                    <i class="ri-close-fill absolute top-2 end-2"></i>
                                </button>
                                <template x-if="modalConfirm && callDeckConfirmDeleting">
                                    <div id="alert-additional-content-2" class="p-4 text-red-800 border border-red-300 rounded-lg bg-gray-800 dark:text-red-400 dark:border-red-800" role="alert">
                                        <div class="flex items-center">
                                          <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                          </svg>
                                          <span class="sr-only">Info</span>
                                          <h3 class="text-lg font-medium capitalize">Löschen</h3>
                                        </div>
                                        <div class="mt-2 mb-4 text-sm">
                                         {{ $Deck->cards_count }} werden verloren gehen ! Sind Sie sicher, dass Sie dieses Paket entfernen möchten? ?
                                        </div>
                                        <div class="flex">
                                            <button type="button" @click=" setTimeout(() => modalConfirm = false, 1500)" wire:click="deleteDeck({{ $Deck->id }})" class="capitalize text-white bg-red-800 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                              Löschen <i class="ml-1 ri-delete-bin-6-line"></i>  
                                            </button>
                                            <button type="button" @click="modalConfirm=false" class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800" data-dismiss-target="#alert-additional-content-2" aria-label="Close">
                                              Abbrechen
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <div x-show="modalConfirm && calledDeckEditForm" class="my-2 p-4">
                                    <livewire:forms.deck  :targetDeckId="$Deck->id" wire:key="{{ str()->random(17).$Deck->id }}" />
                                </div>
                            </x-modal>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="border-b border-gray-700">
                    <div id="alert-additional-content-4" class="p-4 mb-4 border rounded-lg bg-gray-800 text-yellow-300 border-yellow-800" role="alert">
                        <div class="flex items-center">
                        <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium">{{ ucfirst('Kein Stapel gefunden') }} !</h3>
                        </div>
                       
                    </div>
                </tr>
            @endforelse
        </tbody>
        
        @if (session()->has('success'))
            <tr class="border-b border-gray-700">
                <div class="my-2 p-2 ">
                    <x-alert type="success">
                        {{ session('success') }}
                    </x-alert>
                </div>
            </tr>
        @elseif (session()->has('echec'))
            <tr class="border-b border-gray-700">
                <div class="my-2 p-2 ">
                    <x-alert type="echec">
                        {{ session('echec') }}
                    </x-alert>
                </div>
            </tr>
        @endif
    </table>
</div>