@extends('layouts.app')

@section('content')
    <x-home.navbar />

    <div class="max-w-screen-md mx-auto space-y-unit">
        <x-panel>
            <x-slot name="title">
                <x-heroicon.solid.user-circle class="h-4" />
                <span>{{ __('Profile') }}</span>
            </x-slot>

            <x-slot name="description">{{ __('Manage your profile information.') }}</x-slot>

            <x-form action="{{ route('auth.profiles.update', $user) }}" method="PUT">
                <div class="space-y-unit">
                    <x-form.input name="name" :value="$user->name" :label="__('Name')" />
                    <x-form.input name="email" :value="$user->email" :label="__('E-mail address')" type="email" />
                    <x-form.select name="timezone" :options="\App\Models\User::timezoneOptions()" :value="$user->timezone" :label="__('Timezone')" />
                    <x-button primary submit :data-disable-with="__('Saving changes...')">
                        {{ __('Save changes') }}
                    </x-button>
                </div>
            </x-form>
        </x-panel>

        <x-panel>
            <x-slot name="title">
                <x-heroicon.solid.lock-closed class="h-4" />
                <span>{{ __('Security') }}</span>
            </x-slot>

            <x-slot name="description">
                {{ __('Secure your account by making sure you have a strong password and two-factor authentication enabled.') }}
            </x-slot>

            <div class="space-y-unit">
                <x-form.field name="password" :label="__('Password')">
                    <div>
                        <x-button secondary small>{{ __('Change password') }}</x-button>
                    </div>
                </x-form.field>

                <reflinks-frame id="{{ $user->domId('profile') }}">
                    <x-form.field name="two_factor_authentication" :label="__('Two-factor authentication')">
                        @if($user->hasTwoFactorAuthentication())
                            <div class="flex items-center space-x-2">
                                <div class="text-green-600  dark:text-green-400 flex items-center space-x-1">
                                    <x-heroicon.solid.shield-check class="h-4" />
                                    <span>{{ __('On') }}</span>
                                </div>
                                <x-button secondary small href="{{ route('auth.profiles.update', [$user, 'two_factor_authentication' => 'disabled']) }}" method="PUT" :data-disable-with="__('Turning off...')">
                                    {{ __('Turn off') }}
                                </x-button>
                            </div>

                        @else
                            <div class="flex items-center space-x-2">
                                <div class="text-red-600 dark:text-red-400 flex items-center space-x-1">
                                    <x-heroicon.solid.shield-exclamation class="h-4" />
                                    <span>{{ __('Off') }}</span>
                                </div>
                                <x-button secondary small href="{{ route('auth.profiles.update', [$user, 'two_factor_authentication' => 'by_email']) }}" method="PUT" :data-disable-with="__('Turning on...')">
                                    {{ __('Turn on') }}
                                </x-button>
                            </div>
                        @endif
                    </x-form.field>
                </reflinks-frame>
            </div>
        </x-panel>
    </div>
@endsection