@extends('layouts.app')

@section('content')
<div class="mt-12 max-w-lg mx-auto">
    <div class="my-unit flex justify-center">
        <x-logo.dark class="h-8" />
    </div>

    <x-form :action="route('auth.sign_in_by_email_only.store')">
        <div class="space-y-unit">
            <x-form.input
                name="email"
                :label="__('Enter your email address')"
                :hint="__('We\'re gonna send you an email with a confirmation code to complete the sign in.')"
                type="email"
                icon="heroicon.solid.mail"
            />

            <x-button primary :data-disable-with="__('Sending email...')">
                {{ __('Send me the confirmation code') }}
            </x-button>
        </div>
    </x-form>

    <div class="mt-unit flex flex-col">
        <x-link :href="route('auth.sessions.create')">
            {{ __("Remembered your password? Sign in.") }}
        </x-link>
    </div>
</div>
@endsection