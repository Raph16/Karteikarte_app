<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Révision > ") }} <span class="text-base font-semibold">{{ $foundDeck->name }}</span>
        </h2>
    </x-slot>
    <div x-data="{ 
            OpenLendCard: false,
            reviewFilter: 'all',
            FoundDeck: @js($foundDeck),
        }" 
        class="py-12" @fresh="setTimeout( () => {
            $wire.loadDecks();
            console.log('refreshed');
            showDeck = true;
            } , 2000) ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg py-3" >
                <livewire:actions.cardreview :deckSlug="$foundDeck->slug" filter="unreviewed" :Deck="$foundDeck" />
            </div>
        </div>
    </div>
</x-app-layout>
