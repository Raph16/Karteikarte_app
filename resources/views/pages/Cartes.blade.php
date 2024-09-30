<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cartes') }}
        </h2>
    </x-slot>
 
    <div x-data="{ openForm: true, openTab: false , id:'' }" class="py-3 my-1">
        <div >
            <div class="flex justify-between gap-4" >
                <button :class="{'border-b-2 border-indigo-400 ': openForm }"
                        class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 hover:shadow-lg hover:shadow-slate-200/50 focus:bg-slate-200 focus:shadow-lg focus:shadow-slate-200/50 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:hover:shadow-navy-450/50 dark:focus:bg-navy-450 dark:focus:shadow-navy-450/50 dark:active:bg-navy-450/90"
                        @click=" openForm=!openForm ;openTab=!openTab">
                {{ __('Karte hinzufügen') }}
              </button>
                <button :class="{'border-b-2 border-indigo-400 ': openTab }"
                        class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 hover:shadow-lg hover:shadow-slate-200/50 focus:bg-slate-200 focus:shadow-lg focus:shadow-slate-200/50 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:hover:shadow-navy-450/50 dark:focus:bg-navy-450 dark:focus:shadow-navy-450/50 dark:active:bg-navy-450/90"
                        @click=" openForm=!openForm; openTab=!openTab">
                {{ __('Alle Karten') }}
              </button>
            </div>
        </div>
        <div class="py-12 my-1">
            <div class="w-full h-full flex flex-col justify-start max-w-7xl mx-auto sm:px-6 md:px-7 lg:px-8">
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
                <template x-if="openForm">
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-100">
                            <livewire:forms.card wire:key="{{ str()->random(17) }}" />
                        </div>
                    </div>
                </template>
                <template x-if="openTab">
                    <div class="bg-gray-800  overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-black/75">
                            <livewire:actions.card wire:key="{{ str()->random(17) }}"/>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
