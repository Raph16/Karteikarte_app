<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
     
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-900 ">
            <div class="h-screen flex flex-col gap-5 items-center justify-center top-3.5 bg-gray-200">

                <div class="border-2 border-gray-900 h-[80%] w-10/12 relative overflow-hidden pb-2" id="cadre">
                    <livewire:layout.navigation />
                    <!-- Page Heading -->
                    @if (isset($header))
                        <header class="bg-gray-800 shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif
                    
                    <div class=" h-[80%] pb-2" id="menu">
                        <div class="w-full h-full pb-2">
                            <div class="container mx-auto w-full h-full mb-1   px-6 pb-3 overflow-auto">
                                <!-- Remove class [ border-dashed border-2 border-gray-300 ] to remove dotted border -->
                                <div class="w-full h-full rounded pb-2">
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
        @livewireScripts
    </body>
</html>
