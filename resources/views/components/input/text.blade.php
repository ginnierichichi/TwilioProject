@props([
'type' => 'text',
'leadingAddOn' => false,
'disable' => false
])

<div class="flex rounded-md shadow-sm w-full">

    <input
        type="{{ $type }}" {{ $attributes->merge(['class' => 'focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300' . ($disable ? ' bg-gray-50' : '') . ($leadingAddOn ? ' rounded-r-none rounded-l-md' : ' rounded-md')]) }}  {{ $disable ? 'disabled' : '' }} />
    @if ($leadingAddOn)
        <button
            class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
            <i class="fa-lg {{ $leadingAddOn }} text-indigo-500"> </i>
        </button>
    @endif
</div>


