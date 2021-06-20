@props([
    'height' => null,
])

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8" {{ $height ? "style=max-height:{$height}px" : '' }}>
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow border-b overflow-hidden border-gray-200 sm:rounded-lg">
                <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>
                    <thead>
                    <tr>

                        {{ $head }}

                    </tr>
                    </thead>

                    <tbody>

                    {{ $body }}

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
