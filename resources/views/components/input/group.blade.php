@props([
    'label' => '',
    'for' => '',
    'error' => false,
    'helpText' => false,
    'inline' => false,
    'paddingless' => false,
    'borderless' => false,
    'width' => 'w-full',
    'hidden' => false,
])

@if($inline)
    <div class="{{ $borderless ? '' : ' sm:border-t ' }} sm:border-gray-200 {{ $paddingless ? '' : ' sm:py-3 ' }} {{ $width }} {{ $hidden ? 'hidden' : '' }}">
        <label for="{{ $for }}" class="block text-sm font-medium leading-5 text-gray-700">{{ $label }}</label>

        <div class="mt-1 relative rounded-md shadow-sm">
            {{ $slot }}

            @if ($helpText)
                <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
            @endif
        </div>

        @if ($error)
            <div class="mt-1 text-red-500 text-sm">{{ $error }}</div>
        @endif
    </div>
@else
    <div class="flex sm:items-start {{ $borderless ? '' : ' sm:border-t ' }} sm:border-gray-200 {{ $paddingless ? '' : ' sm:py-3 ' }} {{ $width }}">
        <label for="{{ $for }}" class="block text-sm pr-6 font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
            {{ $label }}
        </label>

        <div class="mt-1 sm:mt-0 w-full ">
            {{ $slot }}

            @if ($error)
                <div class="mt-1 text-red-500 text-sm">{{ $error }}</div>
            @endif

            @if ($helpText)
                <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
            @endif
        </div>
    </div>
@endif
