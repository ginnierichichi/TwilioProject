@props([
    'title' => '',
    'first' => false,
])

<div class="border-b border-gray-300 pb-2 mb-2 {{ $first ? '' : 'mt-2' }}">
    <h3 class="font-semibold text-lg text-gray-900 leading-6">
        {{ $title }}
    </h3>

    @if($slot)
        <p class="text-gray-600 text-sm">
            {{ $slot }}
        </p>
    @endif
</div>

