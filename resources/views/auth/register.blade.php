<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <div class="h-28 w-28">
                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.42 19"><defs><style>.cls-1{fill:#f22f46;}</style></defs><path class="cls-1" d="M10.32,12.42a.92.92,0,1,1-.92-.9A.92.92,0,0,1,10.32,12.42ZM9.4,9.29a.9.9,0,1,0,.92.9A.91.91,0,0,0,9.4,9.29Zm6.14-1c.31,3.54-1.4,6.63-3.91,7.81a5.24,5.24,0,0,1-2.89.46,5.5,5.5,0,0,1-2.83-1.28A7.93,7.93,0,0,1,3.26,9.94,8.46,8.46,0,0,1,5.11,3.73a5.57,5.57,0,0,1,5-2.06,5.7,5.7,0,0,1,3.29,1.71A8.11,8.11,0,0,1,15.54,8.32Zm-2.16.81c0-3.05-1.77-5.5-4-5.5s-4,2.45-4,5.5,1.77,5.5,4,5.5S13.38,12.18,13.38,9.13Zm-4-2.05a.91.91,0,1,0,.92.9A.92.92,0,0,0,9.4,7.08Zm0-2.15a.9.9,0,1,0,.92.9A.92.92,0,0,0,9.4,4.93Zm-5-.16S1.24,2.61,3,3l2.43.51L4.54,4.58"/></svg>
            </div>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="twilio_phone" value="{{ __('Phone Number') }}" />
                <x-jet-input id="twilio_phone" class="block mt-1 w-full focus:outline-none border border-gray-200 py-2" type="twilio_phone" name="twilio_phone" :value="old('twilio_phone)" required />

            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms"/>

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
