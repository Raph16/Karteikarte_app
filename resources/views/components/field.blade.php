@props(['disabled' => false, 'label' => "", 'type' => 'text', 'name' => '', 'value' => '', 'modele' => '', 'requis'=> false , 'hide'=>'no'])
<div class="mb-4.5 {{ ($hide=='yes') ? 'hidden': '' }}">
    <x-label associate="{{ $name }}" include="{{ $requis ? true : false }}">{{ucfirst($label) }} </x-label>
    <div class="px-3 py-2 rounded-lg bg-gray-800">
        <input autofocus {{ $disabled ? 'disabled':'' }} id="{{ $name }}"  name="{{ $modele }}" placeholder="{{ $slot }}" type="{{ $type }}" value="{{ old($name, $value) }}" x-model="{{ $modele }}" wire:model.defer="{{ $modele }}" {{ $attributes->merge(['class' => 'px-3 bg-slate-100 border-gray-300 py-2  focus:border-indigo-500 focus:ring-indigo-600  rounded-md shadow-sm']) }} />
    </div>
    <x-error input="{{ $modele }}"></x-error>
</div>

