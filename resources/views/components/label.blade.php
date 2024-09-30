@props(['associate'=>'', 'include'=>false ])

<label for="{{ $associate }}" {{ $attributes->merge(['class' => 'block font-medium text-sm py-2 relative'])}}>
    {{ ucfirst($slot) ??  $associate }}
    @if($include)
        <span class="text-red-500 ">*</span>
    @endif
</label>
