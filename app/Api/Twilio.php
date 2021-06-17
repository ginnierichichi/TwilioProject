<?php
namespace App\Api;
use App\Models\Message;
use Illuminate\Http\Request;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
/**
 * Class Twilio API.
 */
class Twilio
{
    /**
     * @return Client
     * @throws ConfigurationException
     */
    public function call(): Client
    {
        $account_sid = config('services.twilio.key');
        $auth_token = config('services.twilio.secret');
        return new Client($account_sid, $auth_token);
    }

    /**
     * @param Message $message
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function sendSms(Message $message): void
    {
        $twilio_number = config('services.twilio.number');
        $response = $this->call()->messages->create(
            $message->addressBook->phone,
            [
                'from' => $twilio_number,
                'body' => $message->body,
                'statusCallBack' => 'https://a6ccdbb5a2fd.ngrok.io/callback',
            ] );


            $message->sid = $response->sid;


        $message->status = $response->status;
        $message->save();
    }

    /**
     * @param Message $message
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function updateStatus(Message $message): void
    {
        $response = $this->call()->messages($message->sid)->fetch();
        $message->status = $response->status;
        $message->save();
    }

}

