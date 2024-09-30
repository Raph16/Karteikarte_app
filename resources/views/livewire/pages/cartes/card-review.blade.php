<div class="p-6 mb-2 text-gray-100" x-data="{
    FoundCards: @entangle('FoundCards'),
    currentIndex: @entangle('currentCardIndex'),
    filter: @entangle('filter'),
    showAnswer: false,
    unReviewedCard:  @entangle('unReviewedCard'),
    reviewedCard: @entangle('reviewedCard'),
    toReviewedCard: @entangle('toReviewedCard'),
    openBtnForNextCard: false,
    openBtnForPrevCard: this.currentIndex > 0 ?? false ,
    currentCard() {
        return this.FoundCards.length > 0 ? this.FoundCards[this.currentIndex] : null;
    },
    nextCard() {
        if (this.currentIndex < this.FoundCards.length - 1) {
            this.currentIndex++;
            this.showAnswer = false;
            this.prevCard();
        }
    },
    prevCard() {
        if (this.currentIndex >= this.FoundCards.length - 1 || this.currentIndex > 0) {
            this.currentIndex--;
            this.showAnswer = false;
        }
    }
}">
    <h2 class="mb-2 text-lg font-semibold text-white">
        {{-- {{ $foundDeck->name }} --}}
        <span x-text="FoundDeck.name"></span>
        <span x-text="FoundDeck.cards_count" class="inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
            {{ $totalCardDisponible }}
        </span>
    </h2>
    <div class="p-2 flex flex-col gap-2">
        <div>
            <ul class="max-w-md space-y-1 list-inside text-gray-400">
                <li class="flex items-center">
                    <i  :class="{'ri-checkbox-circle-line text-green-500': unReviewedCard > 0, 'ri-close-circle-line text-red-500': unReviewedCard < 1  }"
                        class="me-2 flex-shrink-0 "></i>
                    <span x-text="(unReviewedCard > 0) ? 'Noch nicht gelernt': 'Noch nicht gelernt'"></span>
                    <span x-text="unReviewedCard" class="inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full"></span>
                </li>
                <li class="flex items-center">
                    <i  :class="{'ri-checkbox-circle-line text-green-500': toReviewedCard > 0, 'ri-close-circle-line text-red-500': toReviewedCard < 1  }"
                        class="me-2 flex-shrink-0 "></i>
                    <span x-text="(toReviewedCard > 0) ? 'Wiederholen': 'Wiederholen'"></span>
                    <span x-text="toReviewedCard" class="inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full"></span>
                </li>
                <li class="flex items-center">
                    <i  :class="{'ri-checkbox-circle-line text-green-500': reviewedCard > 0, 'ri-close-circle-line text-red-500': reviewedCard < 1  }"
                        class="me-2 flex-shrink-0 "></i>
                    <span x-text="(reviewedCard > 0) ? 'Gelernt': 'Gelernt'"></span>
                    <span x-text="reviewedCard" class="inline-flex items-center justify-center w-4 h-4 ms-2 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full"></span>
                </li>
            </ul>
        </div>

        <div x-show="!OpenLendCard">
            <x-action methods="OpenLendCard=!OpenLendCard;" methodeWire=" " class="mt-2 p-2 border-2 border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-500 hover:text-white/85 ">
                Jetzt lernen
            </x-action>
        </div>
    </div>
     <div x-show="OpenLendCard" class="mt-4">
         <x-action methods="console.log('refreshed');" time=1000 wMsg=false methodeWire='refresh' class="mt-2 p-2 outline outline-indigo-700 text-indigo-300 rounded-lg hover:bg-indigo-700 hover:text-white/85 " spinerClass="border-yello-600 bg-transparent">
             refresh <i class="ri-refresh-line ml-2"></i>
         </x-action>
        <div class="p-2 mt-2 border-4 border-indigo-500 rounded-lg relative">
            <div class="flex justify-center gap-4 mb-4">
                <button wire:click="setFilter('unreviewed')" class="p-2 border-2 rounded-lg border-indigo-500 text-indigo-500 bg-none text-xs hover:bg-indigo-700 hover:text-white/85 font-semibold" :class="{'bg-indigo-500 text-white': filter === 'unreviewed'}" >Noch nicht gelernt</button>
                <button wire:click="setFilter('toreview')" class="p-2 border-2 rounded-lg border-indigo-500 text-indigo-500 bg-none text-xs hover:bg-indigo-700 hover:text-white/85 font-semibold" :class="{'bg-indigo-500 text-white': filter === 'toreview'}" >Wiederholen</button>
                <button wire:click="setFilter('reviewed')" class="p-2 border-2 rounded-lg border-indigo-500 text-indigo-500 bg-none text-xs hover:bg-indigo-700 hover:text-white/85 font-semibold" :class="{'bg-indigo-500 text-white': filter === 'reviewed'}" >Gelernt</button>
                {{-- <button wire:click="setFilter('all')" class="p-2 border-2 rounded-lg border-indigo-500 text-indigo-500 bg-none text-xs hover:bg-indigo-700 hover:text-white/85 font-semibold" :class="{'bg-indigo-500 text-white': filter === 'all'}">Alle</button> --}}
            </div>
            <span class="absolute top-1 end-1 inline-flex items-center justify-center h-6  text-xs  font-thin text-primary text-white bg-transparent rounded-md"> 
                <span x-text="filter" class="text-xs  font-thin text-primary text-white">Karten</span> 
                <span x-text="FoundCards.length > 0 ? (currentIndex + 1 +' / '+ FoundCards.length) : ''" class="mx-1 text-xs  font-thin text-primary text-white"></span>
            </span>
            
            <template x-if="FoundCards.length < 1">
                <div id="alert-additional-content-4" class="p-4 mb-4 border rounded-lg bg-gray-800 text-yellow-300 border-yellow-800" role="alert">
                    <div class="flex items-center">
                        <i class="ri-error-warning-line w-4 me-2"></i>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium">{{ ucfirst('Keine Karte für diese Kategorie gefunden') }} !</h3>
                    </div>
                </div>
            </template>
            <template x-if="FoundCards.length > 0">
                <div class="mt-1">
                    <h3 class="text-lg font-semibold">Frage</h3>
                    <p x-text="currentCard().question"></p>
                </div>
            </template>
            
            <template x-if="showAnswer && currentCard()">
                <div>
                    <hr class="border-2 border-slate-300 my-1">
                    <h3 class="text-lg font-semibold">Antwort</h3>
                    <p x-text="currentCard().answer"></p>
                </div>
            </template>
        
            <template x-if="FoundCards.length > 0">
                <div class="flex justify-between items-center gap-2 mt-4">
                    <x-action methods="showAnswer=!showAnswer;" time=500 methodeWire=" " wMsg=false class="text-sm p-2 border-2 border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-500 hover:text-white/85 ">
                        <span x-text="showAnswer ? 'Antwort ausblenden' : 'Antwort anzeigen'"></span> 
                        <i :class="{'ri-eye-line': !showAnswer, 'ri-eye-off-line': showAnswer,}"></i>
                    </x-action>
                    <template x-if="showAnswer">
                        <div class="p-2">
                            <h2 class="text-base text-white/65">Bewerten</h2>
                            <hr class="border-2 border-slate-300 my-1">
                            <div class="mt-1 flex justify-center gap-1">
                                <x-action methods="openBtnForNextCard=true;" time=1000 wMsg=false methodeWire="markCardAsReviewed('toreview')" class="text-xs p-1 border-2 border-indigo-500 rounded-lg text-indigo-500 hover:bg-indigo-600 hover:text-white/85 ">
                                    To review
                                </x-action>
                                <x-action methods="openBtnForNextCard=true;" time=1000 wMsg=false methodeWire="markCardAsReviewed('easy')" class="text-xs p-1 border-2 border-indigo-500 rounded-lg text-indigo-500 hover:bg-indigo-600 hover:text-white/85 ">
                                    easy
                                </x-action>
                                <x-action methods="openBtnForNextCard=true;" time=1000 wMsg=false methodeWire="markCardAsReviewed('medium')" class="text-xs p-1 border-2 border-indigo-500 rounded-lg text-indigo-500 hover:bg-indigo-600 hover:text-white/85 ">
                                    medium
                                </x-action>
                                <x-action methods="openBtnForNextCard=true;" time=1000 wMsg=false methodeWire="markCardAsReviewed('hard')" class="text-xs p-1 border-2 border-indigo-500 rounded-lg text-indigo-500 hover:bg-indigo-600 hover:text-white/85 ">
                                    hard
                                </x-action>
                            </div>
                        </div>  
                    </template>
                    <template x-if="showAnswer && openBtnForNextCard">
                        <div class="flex justify-around items-center">
                            <x-action wMsg=false methods="prevCard();" hide="openBtnForPrevCard" methodeWire=" " time=1000 class="text-xs p-1 border-2 border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-600 hover:text-white/85 ">
                                <i class="ri-arrow-left-fill"></i>
                            </x-action>
                            <x-action wMsg=false methods="nextCard();" methodeWire=" " time=1000 class="text-xs p-1 border-2 border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-600 hover:text-white/85 ">
                                <i class="ri-arrow-right-fill"></i>
                            </x-action>
                        </div>
                    </template>
                </div>
            </template> 
        </div>
    </div>
</div>