@props(['label' => '', 'name' => '', 'selectedValue' => '', 'collection' => [], 'key' => '', 'valueOption' => '', 'modele' => ''])

<div x-data="{ items: {{ json_encode($collection) }}, selectedValue: '{{ $selectedValue }}' }" class="mt-1">
    <x-label associate="{{ $name }}">{{ ucfirst($label) }}</x-label>
    {{-- <div class="flex items-center px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-700"> --}}
        <template x-if="items.length > 0">
            <div class="w-full flex items-center px-3 py-2 rounded-lg bg-gray-800">
                <select id="{{ $name }}" wire:model="{{ $modele }}" x-model="{{ $modele }}" name="{{ $name }}" :disabled="items.length === 0" 
                    class="block mx-1 p-2.5 w-full text-sm text-black/85 font-semibold rounded-lg border bg-slate-100 border-gray-600 placeholder-black/70 focus:ring-indigo-500 focus:border-indigo-500 shadow-md group max-h-[56px] open:!max-h-[400px] transition-[max-height] duration-500 overflow-hidden">
                    <option selected class="dark:text-black/85 hover:bg-indigo-500">{{ $slot }}</option>
                    <template x-for="(item, index) in items" :key="index">
                        <option class="dark:text-black/85 hover:bg-indigo-500" x-bind:value="item['{{ $valueOption }}']" x-text="item['{{ $key }}']" :selected='item["{{ $valueOption }}"] === selectedValue' ></option>
                    </template>
                </select>
            </div>
        </template>
        <template x-if="items.length < 1">
            <div class="p-4 mb-4 text-sm rounded-lg bg-gray-800 text-yellow-300" role="alert">
                <span class="font-medium">Warning! :</span> Pas de {{ $name }} trouvée !.
            </div>
        </template>
    {{-- </div> --}}
    <x-error input="{{ $modele }}"></x-error>
</div>
