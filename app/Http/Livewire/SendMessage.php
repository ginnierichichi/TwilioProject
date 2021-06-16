<?php

namespace App\Http\Livewire;

use App\Jobs\SendTextMessage;
use App\Models\AddressBook;
use App\Models\Message;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;
use Twilio\Rest\Client;

class SendMessage extends Component
{
    use WithRateLimiting;

    public $newMessage;
    public AddressBook $number;
    public Message $message;
    public $messageId;

    public function rules()
    {
       return [
           'number.phone' => 'required',
           'message.body' => 'required',
           ];
    }

    public function mount()
    {
        $this->number = AddressBook::make();
        $this->message = Message::make();

    }


    public function addNumber()
    {
        $this->validate([ 'number.phone' => 'required|unique:users_phone_number|numeric',]);
        $this->number->save();
    }

    public function openMessage($messageId)
    {
        $this->messageId = $messageId;
    }

    public function send()
    {
//        try {
//            $this->rateLimit(10);


            $this->validateOnly('message.body');

            $message = new Message();

            $message->user_id = auth()->id();
            $message->address_book_id = $this->messageId;
            $message->body = $this->message->body;
            $message->save();

            SendTextMessage::dispatch($message->load('addressBook'));


//        } catch (TooManyRequestsException $exception) {
//            $this->addError('email', "Slow down! Please wait another $exception->secondsUntilAvailable seconds to log in.");
//
//            return;
//        }
    }

    public function render()
    {
        return view('dashboard', [
            'numbers' => AddressBook::all(),
            'messages' => Message::where('address_book_id', $this->messageId)->with('addressBook', 'user')->get(),
        ]);
    }
}
