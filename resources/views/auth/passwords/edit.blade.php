@extends('layouts.app')

@section('content')
    <x-home.navbar />

    <div class="max-w-screen-md mx-auto space-y-unit">
        <x-panel>
            <x-slot name="title">
                <x-heroicon.solid.lock-closed class="h-4" />
                <span>{{ __('Password') }}</span>
            </x-slot>

            <x-slot name="description">{{ __('Update your password.') }}</x-slot>

            <x-form action="{{ route('auth.passwords.update', $user) }}" method="PUT">
                <div class="space-y-unit">
                    <x-form.input name="current_password" :label="__('Confirm your current password')" type="password" />
                    <x-form.input name="new_password" :label="__('New password')" type="password" />

                    <div class="flex items-center space-x-2">
                        <x-button secondary href="{{ route('auth.profiles.edit', $user) }}">
                            {{ __('Cancel') }}
                        </x-button>

                        <x-button primary submit :data-disable-with="__('Changing password...')">
                            {{ __('Change password') }}
                        </x-button>
                    </div>
                </div>
            </x-form>
        </x-panel>
    </div>
@endsection