<?php

namespace App\Actions\Fortify;

use App\Models\User;
use http\Client\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * @param array $input
     * @return mixed
     * @throws ValidationException
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function create(array $input): mixed
    {

        $data =  Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'twilio_phone' => ['required', 'numeric', 'unique:users', 'regex:/^\\(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4})(\s?\#(\d{4}|\d{3}))?$/', 'min:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $twilio_sid = config('services.twilio.key');
        $token = config('services.twilio.secret');
        $twilio_verify_sid = config('services.twilio.verify');

        $twilio = new Client($twilio_sid, $token);


        $twilio->lookups->v1->phoneNumbers($data['twilio_phone'])
            ->fetch(["countryCode" => "GB"]);


        $replace = preg_replace('/^0/', '+44', $input['twilio_phone']);

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'twilio_phone' => $replace,
            'password' => Hash::make($input['password']),
        ]);


    }
}
