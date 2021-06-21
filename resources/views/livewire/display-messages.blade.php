<div class="py-12 font-monsterrat w-full" >
    <div class="flex justify-center mx-auto">
    <x-table>
            <x-slot name="head">
                <x-table.heading>Recipients number</x-table.heading>
                <x-table.heading>Body of Message</x-table.heading>
                <x-table.heading>Time Sent</x-table.heading>
                <x-table.heading>Status</x-table.heading>
            </x-slot>

            <x-slot name="body">
                @forelse($messages as $message)
                    <x-table.row>
                        <x-table.cell class="font-medium text-gray-900">
                            <div class="flex items-center">
                                <div class="w-6 h-3 mr-2"></div>
                                {{ $message->addressBook->phone }}
                            </div>
                        </x-table.cell>
                        <x-table.cell>
                            {{ $message->body }}
                        </x-table.cell>
                        <x-table.cell>
                            {{ $message->created_at->format('d, M Y') }} at {{ $message->created_at->format('H:i') }}
                        </x-table.cell>
                        <x-table.cell>
                            <div class="flex justify-center bg-{{ $message->status_colour }}-200 rounded-lg px-4 py-2">
                                {{ $message->status }}
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.row>
                        <x-table.cell colspan="4">
                            <div class="text-center text-lg font-medium py-6 text-cool-gray-500">
                                <div>No Messages sent yet.</div>
                                <a class="underline hover:text-green-300" href="{{ route('dashboard') }}">Send a message?</a>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @endforelse
            </x-slot>
        </x-table>

        <div>
            {{ $messages->links() }}
        </div>
    </div>
</div>
