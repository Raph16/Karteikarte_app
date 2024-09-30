@props(['name'=>'',
        'label' =>'',
        'modele'=> '',
        'ligne'=> 1,
        'value'=> "",
        'icon'=> false,
        'image'=> false
    ])
<div>
    <x-label associate="{{ $name }}">{{ $label }}</x-label>
    <div class="flex  items-center px-3 py-2 rounded-lg bg-gray-800">
            <template x-if="{{ $icon }}">
                <button type="button" class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer dark:text-gray-400 hover:text-white hover:bg-gray-600">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                        <path fill="currentColor" d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 1H2a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0ZM7.565 7.423 4.5 14h11.518l-2.516-3.71L11 13 7.565 7.423Z"/>
                    </svg>
                    <span class="sr-only">Upload image</span>
                </button>
            </template>
            <template x-if="{{ $image }}">
                <button type="button" class="p-2 rounded-lg cursor-pointer text-gray-400 hover:text-white hover:bg-gray-600">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.408 7.5h.01m-6.876 0h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM4.6 11a5.5 5.5 0 0 0 10.81 0H4.6Z"/>
                    </svg>
                    <span class="sr-only">Add emoji</span>
                </button>
            </template>
            <div class="w-full flex flex-col gap-1:">
                <textarea id="{{ $name }}" wire:model="{{ $modele }}" x-model="{{ $modele }}"  rows="{{ $ligne }}" value="{{ old($name, $value) }}"
                    class="block mx-1 p-2.5 w-full text-sm text-black/85 font-semibold rounded-lg border focus:ring-indigo-500 focus:border-indigo-500 bg-slate-100 border-gray-600 placeholder-black/70 dark:focus:ring-indigo-500 dark:focus:border-indigo-500" placeholder="{{ $slot }}"></textarea>
                <x-error input="{{ $modele }}"></x-error>
            </div>
    </div>
</div>