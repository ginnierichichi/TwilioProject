@props([
    'loader' => false,
    'loadingTarget' => null,
])

<span class="inline-flex rounded-md shadow-sm">
        <button wire:loading.attr="disabled"
                @if($loader) wire:loading.attr="disabled" @endif
                {{ $attributes->merge(['class' => 'inline-flex items-center justify-center text-sm font-medium border rounded-md transition-all ease-in-out duration-100 focus:outline-none focus:shadow-outline border-red-300 bg-white text-red-900 shadow-sm hover:bg-red-50 focus:border-red-400 focus:bg-white px-2 py-1 text-sm']) }}>
            {{ $slot }}

            @if($loader)
                <x-button.loading :loadingTarget="$loadingTarget" color="text-red-600" height="h-3" width="w-3"></x-button.loading>
            @endif
        </button>
</span>