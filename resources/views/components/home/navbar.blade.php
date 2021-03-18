<div class="my-2">
    <div class="max-w-screen-md mx-auto flex items-center justify-between">
        <x-logo.dark class="h-6" />

        <div>
            <x-dropdown>
                <x-slot name="trigger">
                    <div class="flex items-center space-x-1 hover:bg-gray-100 rounded-full py-1 px-2">
                        @if(Auth::user()->avatar->attached())
                            <img src="{{ Auth::user()->avatar->url() }}" class="w-5 h-5 rounded-full" />
                        @endif

                        <button>{{ Auth::user()->name }}</button>
                    </div>
                </x-slot>

                <x-dropdown.link :href="route('workspaces.index')" icon="heroicon.solid.grid">
                    {{ __('Workspaces') }}
                </x-dropdown.link>

                <x-dropdown.link href="{{ route('auth.profiles.edit', auth()->id()) }}" icon="heroicon.solid.user-circle">
                    {{ __('Profile') }}
                </x-dropdown.link>

                <x-dropdown.divider />

                <x-dropdown.custom
                    x-data="{
                        theme: localStorage.theme || 'light',
                        setTheme: function(theme) {
                            this.theme = theme
                            localStorage.theme = theme

                            if(theme == 'light') {
                                document.documentElement.classList.remove('dark')
                            } else {
                                document.documentElement.classList.add('dark')
                            }
                        }
                    }"
                >
                    <div class="w-full cursor-pointer">
                        <div x-show="theme == 'light'" class="w-full flex items-center space-x-1" @click="setTheme('dark')">
                            <x-heroicon.solid.light-bulb class="h-4 text-gray-500 dark:text-gray-300" />
                            <span>Dark mode</span>
                        </div>
                        
                        <div x-show="theme == 'dark'" class="w-full flex items-center space-x-1" @click="setTheme('light')">
                            <x-heroicon.solid.light-bulb class="h-4 text-gray-500 dark:text-gray-300" />
                            <span>Light mode</span>
                        </div>
                    </div>
                </x-dropdown.custom>

                <x-dropdown.link icon="heroicon.solid.logout" :href="route('auth.sessions.destroy', 'self')" method="DELETE" :data-disable-with="__('Signing out...')">
                    {{ __('Sign out') }}
                </x-dropdown.link>
            </x-dropdown>
        </div>
    </div>
</div>