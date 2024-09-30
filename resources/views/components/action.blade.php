@props(['type'=>'button','wMsg'=>true, 'methods'=>"", 'color'=> "red", 'methodeWire'=>" ", 'spinerClass'=>" ", 'time'=>5000, 'textWait'=>" "])
<span x-data="{ show: false, disabled: false , wMsg: {{ $wMsg }}}" class="">
    <button
        x-show='!show' 
        :disabled='disabled'
        @click=" show = true; disabled = true; {{ $methods }} setTimeout(() => { show = false; disabled = false; }, {{ $time }});"
        wire:click='{{ $methodeWire }}'
        type="{{ $type }}" 
        {{ $attributes->merge(['class' => "mx-1"]) }}
        :class="{'bg-transparent': show}"
        >
        {{ $slot }}
    </button>
    <span x-show='show' class="flex justify-center items-center bg-transparent">
        <span x-show='show && wMsg' class="mx-1 p-1 {{ $textWait }} dark:text-white/80">Bitte warten !</span>
        <div x-show='show' {{ $attributes->merge(['class' => "border $spinerClass animate-spin  rounded-full h-4 w-4"]) }}></div>
    </span>
</span>

