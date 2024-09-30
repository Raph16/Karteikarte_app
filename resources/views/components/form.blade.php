@props(['disabled' => false,
    'intitule' => 'formulaire',
    'wireSub'=>'',
    'bar' => 'yellow',
    'divider' => true
    ])
<form  wire:submit="{{ $wireSub ?? ' ' }}" class="bg-transparent shadow py-3">
    <h1 class="text-start text-2xl font-bold  mt-2  px-3 py-2 text-white/75  tracking-wider {{ $divider ? "border-b border-$bar-500": " " }} pb-4">
        {{$intitule}}
    </h1>
    <div {{ $attributes->merge(['class'=>"bg-transparent  p-3"]) }}>
        {{ $slot }}
    </div>
</form>  