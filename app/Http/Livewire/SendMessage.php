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
        $this->validate([ 'number.phone' => 'required|unique:address_books|numeric',]);
        $this->number->save();

        $this->number = AddressBook::make();
    }

    public function openMessage($messageId)
    {
        $this->messageId = $messageId;
    }

    //to do: Verify phone number through twilio
    // status callback to update if delivered or failed.

    public function send()
    {
        $this->validateOnly('message.body');

        try {
            $this->rateLimit(1, 5);

            $message = new Message();

            $message->user_id = auth()->id();
            $message->address_book_id = $this->messageId;
            $message->body = $this->message->body;
            $message->save();

            SendTextMessage::dispatch($message->load('addressBook'));


        } catch (TooManyRequestsException $exception) {

            session()->flash('error',"Slow down! Please wait another $exception->secondsUntilAvailable seconds to log in." );
            return;

//            $this->addError('email', "Slow down! Please wait another $exception->secondsUntilAvailable seconds to log in.");
//
//            return;
        }

        $this->message = Message::make();
    }

    public function render()
    {
        return view('dashboard', [
            'numbers' => AddressBook::orderBy('created_at', 'desc')->get(),
            'messages' => Message::where('address_book_id', $this->messageId)->with('addressBook', 'user')->get(),
        ]);
    }
}
