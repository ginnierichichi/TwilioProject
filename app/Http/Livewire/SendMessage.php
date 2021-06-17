<?php

namespace App\Http\Livewire;

use App\Api\Twilio;
use App\Jobs\SendTextMessage;
use App\Models\AddressBook;
use App\Models\Message;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use http\Env\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SendMessage extends Component
{
    use WithRateLimiting;

    public $newMessage;
    public AddressBook $number;
    public Message $message;
    public $messageId;
    public $status;

    public function rules()
    {
       return [
           'number.phone' => 'required',
           'message.body' => 'required|max:250',
           ];
    }

    public function mount()
    {
        $this->number = AddressBook::make();
        $this->message = Message::make();
    }

    /**
     * @param  Message  $message
     */
    public function updateStatus(Message $message): void
    {
        if ($this->messageId && $message->status !== 'delivered') {
            try {
                (new Twilio())->updateStatus($message);
            } catch (TwilioException $e) {
            }
        }
    }

    /**
     * @param Request $request
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function addNumber()
    {
        $this->validate([
            'number.phone' => ['required', 'numeric', 'min:10' , 'regex:/^\\(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4})(\s?\#(\d{4}|\d{3}))?$/', 'min:10'],
        ]);

        $twilio_sid = config('services.twilio.key');
        $token = config('services.twilio.secret');

        $twilio = new Client($twilio_sid, $token);

        $twilio->lookups->v1->phoneNumbers($this->number->phone)
            ->fetch(["countryCode" => "GB"]);

        $replace = preg_replace('/^0/', '+44', $this->number['phone']);

        AddressBook::create([
            'user_id' => auth()->id(),
            'phone' => $replace
        ]);

        $this->number = AddressBook::make();
    }

    /**
     * @param $messageId
     */
    public function openMessage($messageId)
    {
        $this->messageId = $messageId;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
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
        }

        $this->message = Message::make();
    }

    public function render()
    {
        return view('dashboard', [
            'numbers' => AddressBook::orderBy('created_at', 'desc')->where('user_id', auth()->id())->get(),
            'messages' => Message::where('address_book_id', $this->messageId)->where('user_id', auth()->id())->with('addressBook', 'user')->get(),
        ]);
    }
}
