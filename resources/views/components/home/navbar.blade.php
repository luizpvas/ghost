<div class="my-2">
    <div class="max-w-screen-md mx-auto flex items-center justify-between">
        <x-logo.dark class="h-6" />

        <div>
            <x-dropdown>
                <x-slot name="trigger">
                    @if(Auth::user()->avatar->attached())
                    @else
                    @endif
                    <button>{{ Auth::user()->name }}</button>
                </x-slot>

                <x-dropdown.link :href="route('workspaces.index')">
                    <x-heroicon.solid.grid class="h-4 text-gray-500" />
                    <span>{{ __('Workspaces') }}</span>
                </x-dropdown.link>

                <x-dropdown.link href="#">
                    <x-heroicon.solid.user-circle class="h-4 text-gray-500" />
                    <span>{{ __('Profile') }}</span>
                </x-dropdown.link>

                <x-dropdown.divider />

                <x-dropdown.link :href="route('auth.sessions.destroy', 'self')" method="DELETE" :data-disable-with="__('Signing out...')">
                    <x-heroicon.solid.logout class="h-4 text-gray-500" />
                    <span>{{ __('Sign out') }}</span>
                </x-dropdown.link>
            </x-dropdown>
        </div>
    </div>
</div>