@extends('layouts.app')

@section('content')
<div class="mt-12 max-w-lg mx-auto">
    <div class="my-unit flex justify-center">
        <x-logo.dark class="h-8" />
    </div>

    <x-form :action="route('auth.session_confirmations.store')">
        <input type="hidden" name="session_id" value="{{ request('session_id') }}" />

        <div class="space-y-unit">
            <div>
                <div class="text-lg font-bold">{{ __('Check your inbox 📨') }}</div>
                {!! __('We just sent an email to <code class="text-sm text-red-500">:email</code> with a 5-digit confirmation code.', [
                    'email' => request('email')
                ]) !!}
            </div>

            <x-form.input :label="__('Please enter the confirmation code')" name="confirmation_code" type="text" maxlength="5" />
            <x-button primary :data-disable-with="__('Signing in...')">
                <span>{{ __('Confirm sign in') }}</span>
                <x-heroicon.solid.arrow-right class="h-4" />
            </x-button>
        </div>
    </x-form>

    <div class="mt-unit flex flex-col">
        <x-link :href="route('auth.sessions.create')">
            {{ __("Sign in with another account.") }}
        </x-link>
    </div>
</div>
@endsection
