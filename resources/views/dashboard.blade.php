<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-3 h-full">
        <div class="w-full h-full flex flex-col justify-start max-w-7xl mx-auto sm:px-6 md:px-7 lg:px-8">
            <div class="inline-flex rounded-md shadow-sm py-3 justify-center" role="group">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium  bg-gray-800 border rounded-s-lg focus:z-10 focus:ring-2 focus:ring-gray-500 focus:text-white border-white text-white/60 hover:text-white hover:bg-gray-700 focus:bg-gray-700">
                <i class="ri-wallet-line w-3 me-2"></i>
                Stapel
                </a>
                <a href="{{ route('paquages') }}" type="button" class="inline-flex items-center px-4 py-2 text-sm font-medium  bg-gray-800 border rounded-e-lg  focus:z-10 focus:ring-2 focus:ring-gray-500 focus:text-white border-white text-white/60 hover:text-white hover:bg-gray-700 focus:bg-gray-700">
                <i class="ri-add-large-line me-1"></i>Hinzufügen
                </a>
            </div>
            <div class="h-full bg-gray-800 overflow-y-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <livewire:actions.deck />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
