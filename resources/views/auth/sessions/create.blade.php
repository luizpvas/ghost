@extends('layouts.app')

@section('content')
<div class="mt-12 max-w-lg mx-auto">
    <div class="my-unit flex justify-center">
        <x-logo.dark class="h-8" />
    </div>

    <x-form :action="route('auth.sessions.store')">
        <div class="space-y-unit">
            <x-form.input :label="__('E-mail address')" name="email" type="email" icon="heroicon.solid.mail" />
            <x-form.input :label="__('Password')" name="password" type="password" icon="heroicon.solid.lock-closed" />
            <x-button primary :data-disable-with="__('Signing in...')">
                {{ __('Sign in') }}
            </x-button>
        </div>
    </x-form>

    <div class="mt-unit flex flex-col">
        <x-link :href="route('auth.sign_in_by_email_only.create')">
            {{ __("Forgot your password?") }}
        </x-link>

        <x-link :href="route('auth.registrations.create')">
            {{ __("Don't have an account yet? Register here.") }}
        </x-link>
    </div>
</div>
@endsection
