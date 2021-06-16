@props([
    'disabled' => false,
    'name' => '',
    'id' => '',
    'text' => '',
    'value' => '',
    'checked' => false,
])

<div class="block">
    <label for="{{ $id }}" class="flex items-center">
        <input type="checkbox" {{ $attributes->merge(['class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded']) }} value="{{ $value }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {{ $checked ? 'checked' : '' }}/>
        <span class="ml-2 text-sm text-gray-600">{{ $text }}</span>
    </label>
</div>
