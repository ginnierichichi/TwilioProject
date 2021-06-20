@props([
    'color' => 'gray',
])

<div {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-0.5 rounded text-xs font-medium leading-4 bg-'.$color.'-100 text-'.$color.'-800']) }}>
    {{ $slot }}
</div>
