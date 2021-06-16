<?php

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Redis\LimiterTimeoutException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SendTextMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws LimiterTimeoutException
     */
    public function handle(): void
    {
        Redis::throttle('SendTextMessage')->allow(1)->every(5)->block(10)->then(function () {
            $account_sid = config('services.twilio.key');
            $auth_token = config('services.twilio.secret');
            $twilio_number = config('services.twilio.number');

            $client = new Client($account_sid, $auth_token);
            $message = $this->message;

            $response = $client->messages->create(
                $message->addressBook->phone,
                [
                    'from' => $twilio_number,
                    'body' => $message->body,
                    'statusCallBack' => 'https://0e68094f2f7d.ngrok.io/callback',
                ] );

            $this->message->status = $response->status;
            $this->message->save();
        }, function () {
            $this->release(10);
        });

    }


    public function failed()
    {
        $this->message->status = 'failed';

        $this->message->save();
        //to do: send message to user
    }
}
