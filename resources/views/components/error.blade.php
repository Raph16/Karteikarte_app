@props(['input'=>''])
@error($input)
    <p {{ $attributes->merge(['class' => 'text-xs italic my-1 text-red-500 dark:text-red-500']) }} >
        {{ $message }}
    </p>
@enderror
