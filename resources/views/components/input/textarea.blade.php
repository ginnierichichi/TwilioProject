@props(['disable' => false])
<div class="flex rounded-md shadow-sm">
    <textarea {{ $attributes }} rows="3"
              class="shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md {{ $disable ? ' bg-gray-50' : '' }}" {{ $disable ? 'disabled' : '' }}/></textarea>
</div>
