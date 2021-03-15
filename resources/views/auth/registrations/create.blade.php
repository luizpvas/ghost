@extends('layouts.app')

@section('content')
<div class="mt-12 max-w-lg mx-auto">
    <div class="my-unit flex justify-center">
        <x-logo.dark class="h-8" />
    </div>

    <x-form :action="route('auth.registrations.store')">
        <div class="space-y-unit">
            <x-form.input :label="__('Full name')" name="name" required />
            <x-form.input :label="__('E-mail address')" name="email" type="email" required />
            <x-form.input :label="__('Password')" name="password" type="password" :hint="__('At least 8 characters.')" required minlength="8" />

            <x-form.checkbox name="agreement" required>
                {!! __('I agree to the <a class="underline" href=":tos_url" target="_blank">Terms of Service</a> and <a class="underline" href=":privacy_url" target="_blank">Privacy Policy</a>.', [
                    'tos_url' => '/terms_of_service',
                    'privace_url' => '/privacy_policy'
                ]) !!}
            </x-form.checkbox>

            <x-button primary :data-disable-with="__('Creating account...')">
                {{ __('Create my account') }}
            </x-button>
        </div>
    </x-form>

    <div class="mt-unit flex flex-col">
        <x-link :href="route('auth.sessions.create')">
            {{ __('Already have an account? Sign in here.') }}
        </x-link>
    </div>
</div>
@endsection