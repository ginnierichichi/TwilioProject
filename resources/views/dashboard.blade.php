<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Send an SMS Message') }}
    </h2>
</x-slot>

<div class="py-12 font-monsterrat">
    <div class="flex justify-center mx-auto sm:px-6 lg:px-8">
        <div class="w-10/12 my-10 flex space-x-6">
            <div class="w-5/12 ">
                <div class="pb-8">
                    <div class="relative flex items-center">
                        <div class="mr-4">To:</div>
                        <input type="text" wire:keydown.enter="addNumber"  wire:model.defer="number.phone" placeholder="+44123456789"  class="text-md w-full focus:outline-none focus:border-indigo-400 focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-5 pr-16 bg-gray-100 border-2 border-gray-200 focus:ring-indigo-400 rounded-full py-2" x-ref="input" />
                        <div class="absolute right-2 items-center inset-y-0 hidden sm:flex">
                            <button type="button" wire:click="addNumber"  class="inline-flex items-center justify-center rounded-full h-8 w-8 transition duration-200 ease-in-out text-white bg-pink-300 hover:bg-blue-600 focus:outline-none" @click.prevent="updateChat($refs.input)">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-xs text-red-500">
                        @if ($errors->has('number.phone'))
                            <span class="text-danger">{{ $errors->first('number.phone') }}</span>
                        @endif
                    </div>
                </div>
{{--                @dd($numbers->first())--}}
                @foreach($numbers as $number)
                <div wire:key="number-{{$number->id}}" wire:click="openMessage({{ $number->id }})" class="bg-white cursor-pointer rounded-lg shadow-md mb-4 p-4 {{ $number->id === $messageId ? 'bg-indigo-200' : '' }}" >
                   <div> {{ $number->phone }}</div>
                </div>
                @endforeach
            </div>

            <div class="w-7/12 max-h-full">
                @if($messageId)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4 ">
                        <div>Send a Message</div>

                        <div  class="h-full  overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch my-6 border rounded-lg">
                            <div class="flex-1 p-2 sm:p-6 justify-between flex flex-col h-3/4 overflow-scroll">
                                @foreach($messages as $message)
                                    <div id="messages"
                                         class="flex flex-col p-1 "
                                        wire:key="message-{{$message->id}}">
                                        <div>
                                            <div>
                                                <div class="flex items-end justify-end">
                                                    <div class="flex flex-col  text-md leading-tight max-w-lg mx-2 order-1 items-end">
                                                        <div>
                                                        <div class="px-4 py-3 rounded-xl inline-block rounded-br-none bg-blue-500 text-white">
                                                            {{ $message->body  }}
                                                        </div>
                                                            <div class="items-end flex justify-end" wire:poll.750ms="updateStatus({{ $message }})">
                                                                @if($message->status === 'queued')
                                                                    <i class="fas fa-check text-gray-400"></i>
                                                                @elseif ($message->status === 'delivered')
                                                                    <i class="fas fa-check text-green-300"></i>
                                                                @else
                                                                    <i class="fas fa-times text-red-300"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
                                    <div class="relative flex">
                                        <input type="text"  wire:keydown.enter="send" wire:model.defer="message.body" :error="$errors->first('message.body')" placeholder="Say something..." class="text-md w-full focus:outline-none focus:border-indigo-400 focus:ring-indigo-400 focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-5 pr-16 bg-gray-100 border-2 border-gray-200  rounded-full py-2" x-ref="input" />
                                        <div class="absolute right-2 items-center inset-y-0 hidden sm:flex">
                                            <button type="button" wire:click="send"  class="inline-flex items-center justify-center rounded-full h-8 w-8 transition duration-200 ease-in-out text-white bg-pink-300 hover:bg-blue-600 focus:outline-none" @click.prevent="updateChat($refs.input)">
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="text-xs text-red-500">
                                        @if ($errors->has('message.body'))
                                            <span class="text-danger">{{ $errors->first('message.body') }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($alertFm = Session::get('error'))
                                            <div class="alert alert-warning alert-block">
                                                <button type="button" class="close" data-dismiss="alert"> <i class="fas fa-times text-red-500"></i></button>
                                                <strong>{{ $alertFm }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>

