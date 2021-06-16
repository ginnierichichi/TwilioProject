@props([
    'placeholder' => null,
    'trailingAddOn' => null,
    'disable' => false
])

<div class="flex">
    <select {{ $attributes->merge(['class' => 'shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md' . ($disable ? ' bg-gray-50' : '') . ($trailingAddOn ? ' rounded-r-none' : '')]) }} {{ !$disable ?: 'disabled' }}>
        @if ($placeholder)
            <option disabled value="">{{ $placeholder }}</option>
        @endif

        {{ $slot }}
    </select>

    @if ($trailingAddOn)
        {{ $trailingAddOn }}
    @endif
</div>
