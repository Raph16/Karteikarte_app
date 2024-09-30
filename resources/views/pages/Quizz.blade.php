<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Quiz') }}
        </h2>
    </x-slot>
    <div x-data="{ 
        OpenLendCard: false,
        reviewFilter: 'all',
        startQuizzShow: false,
        selectDeck: false,
        scoreQuizz: null,
        loose: null
    }" class="mt-2 py-12 border border-yellow-500 h-full flex flex-col justify-center items-center bg-gray-800 shadow-sm sm:rounded-lg">
        <template x-if="!startQuizzShow">
            <div class="border w-[75%] p-4 flex flex-col gap-4 justify-center items-start">
                <h1 class="text-indigo-500/85  font-semibold text-2xl">Welcome to the Quiz App!</h1>
                <p class="text-white/70  text-lg">
                    Willkommen zu dem Entdeckungs-Lernquiz. Das Quiz besteht aus 15 Fragen und beinhaltet die Auswahl der richtigen Antwort aus 4 anderen.
                    <br>
                    Um sicher für Ihre Prüfungen bereit zu sein, müssen Sie nacheinander zwei Serien mit je 15 Fragen richtig beantworten und bestehen
                </p>
                <button @click="startQuizzShow=!startQuizzShow; selectDeck=!selectDeck" class="p-2 border border-indigo-500 text-indigo-500 rounded-lg hover:bg-indigo-500 hover:text-white/85">Los geht</button>
            </div>
        </template>    
        <template x-if="startQuizzShow">
            <div class="w-11/12">
                <livewire:actions.quizz />
            </div>
        </template>    
    </div>
</x-app-layout>
