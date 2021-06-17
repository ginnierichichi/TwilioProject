@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
    <x-modal.dialog wire:model="confirmingPassword">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="content">
            {{ $content }}

            <div class="mt-4" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
                <x-input.group inline="false" :error="$errors->first('confirmable_password')" borderless="true" paddingless="true">
                    <x-input.text x-ref="confirmable_password"
                                  wire:model.defer="confirmablePassword"
                                  wire:keydown.enter="confirmPassword"/>
                </x-input.group>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button.secondary wire:click="stopConfirmingPassword" wire:loading.attr="disabled">
                Nevermind
            </x-button.secondary>

            <x-button.primary class="ml-2" wire:click="confirmPassword" wire:loading.attr="disabled">
                {{ $button }}
            </x-button.primary>
        </x-slot>
    </x-modal.dialog>
@endonce
