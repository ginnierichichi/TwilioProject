@props([
    'toggled' => false,
])

<button type="button"
        x-data="{ on: '{{ $toggled }}' }"
        @click="on = !on"
        :aria-pressed="on.toString()"
        aria-pressed="false"
        class="flex-shrink-0 group relative rounded-full inline-flex items-center justify-center h-5 w-10 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    <span aria-hidden="true"
          :class="{ 'bg-indigo-600': on, 'bg-gray-200': !on }"
          class="absolute h-4 w-9 mx-auto rounded-full transition-colors ease-in-out duration-200 bg-gray-200"></span>
    <span aria-hidden="true"
          :class="{ 'translate-x-5': on, 'translate-x-0': !on }"
          class="absolute left-0 inline-block h-5 w-5 border border-gray-200 rounded-full bg-white shadow transform ring-0 transition-transform ease-in-out duration-200 translate-x-0"></span>
</button>