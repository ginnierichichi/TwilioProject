<?php

namespace App\Http\Livewire;

use App\Models\User;
use http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Twilio\Rest\Client;

class VerifyPhoneNumber extends Component
{
    public $user;
    public $showVerificationModal = false;

    public function mount(User $user)
    {
        $this->user = $user;
    }


    protected function verify(Request $request)
    {
        $this->showVerificationModal = true;

        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone_number' => ['required', 'string'],
        ]);
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");


        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $data['phone_number']));
        if ($verification->valid) {
            $user = tap(User::where('twilio_phone', $data['twilio_phone']))->update(['isVerified' => true]);

            /* Authenticate user */
            Auth::login($user->first());
            return redirect()->route('home')->with(['message' => 'Phone number verified']);
        }
        return back()->with(['twilio_phone' => $data['twilio_phone'], 'error' => 'Invalid verification code entered!']);
    }

    public function render()
    {
        dd('hello');
        return view('auth.register', [
            'users' => User::all(),
        ]);
    }
}
