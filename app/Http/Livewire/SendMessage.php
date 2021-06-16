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
           'number.phone' => 'required|unique:users_phone_number|numeric',
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
        $this->validate([ 'number.phone' => 'required',]);
        $this->number->save();
    }

    public function openMessage($messageId)
    {
        $this->messageId = $messageId;
    }

    public function send()
    {
        try {
//            $this->rateLimit(10);

            $this->validate();

            $message = Message::create([
                'user_id' => auth()->id(),
                'address_book_id' => $this->messageId,
                'body' => $this->message->body,
            ]);


//            $this->message->user_id = auth()->id();
//            $this->message->address_book_id = $this->messageId;

//            $this->message->save();

            SendTextMessage::dispatch($message);


        } catch (TooManyRequestsException $exception) {
            $this->addError('email', "Slow down! Please wait another $exception->secondsUntilAvailable seconds to log in.");

            return;
        }
    }

    public function render()
    {
        return view('dashboard', [
            'numbers' => AddressBook::all(),
            'messages' => Message::where('address_book_id', $this->messageId)->with('addressBook', 'user')->get(),
        ]);
    }
}
