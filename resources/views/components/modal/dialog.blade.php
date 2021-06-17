@props(['id' => null, 'maxWidth' => null, 'maxHeight' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="text-lg px-6 py-4 bg-gray-100 rounded-t-lg">
        {{ $title }}
    </div>
    <div class="px-6 py-4 overflow-y-auto overflow-x-hidden" style="{{ $maxHeight ? 'max-height:'.$maxHeight : '' }}">
        {{ $content }}
    </div>
    <div class="px-6 py-4 bg-gray-100 text-right space-x-1 rounded-b-lg">
        {{ $footer }}
    </div>
</x-modal>
