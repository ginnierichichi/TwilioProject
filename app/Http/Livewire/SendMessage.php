<?php

namespace App\Http\Livewire;

use App\Api\Twilio;
use App\Jobs\SendTextMessage;
use App\Models\AddressBook;
use App\Models\Message;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use http\Env\Request;
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
           'message.body' => 'required',
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
//        $data = $request->validate([
//
//            'number.phone' => 'required|unique:users|numeric',
//        ]);
//
//        $twilio_sid = config('services.twilio.key');
//        $token = config('services.twilio.secret');
//        $twilio_verify_sid = config('services.twilio.verify');
//
//
//        $twilio = new Client($twilio_sid, $token);
//        $twilio->verify->v2->services($twilio_verify_sid)
//            ->verifications
//            ->create($data['phone_number'], "sms");
//        User::create([
//            'name' => $data['name'],
//            'phone_number' => $data['phone_number'],
//            'password' => Hash::make($data['password']),
//        ]);

        $this->validate([ 'number.phone' => 'required|numeric',]);
        $this->number->save();

        $this->number = AddressBook::make();
    }

    /**
     * @param $messageId
     */
    public function openMessage($messageId)
    {
        $this->messageId = $messageId;
    }

    //to do: Verify phone number through twilio
    // status callback to update if delivered or failed.

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
            'numbers' => AddressBook::orderBy('created_at', 'desc')->get(),
            'messages' => Message::where('address_book_id', $this->messageId)->with('addressBook', 'user')->get(),
        ]);
    }
}
