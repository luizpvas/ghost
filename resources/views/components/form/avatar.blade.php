<x-form.field
    {{ $attributes }}
    x-data="{
        attached: {{ $value->attached() ? 'true' : 'false' }}
    }"
>
    <div class="inline-flex items-center group">
        <img src="{{ asset('img/default_avatar.svg') }}" class="w-12 h-12" />

        <div class="ml-2 flex items-center space-x-2">
            <label>
                <input x-ref="input" type="file" name="{{ $name }}" class="hidden" />
                <x-button as="div" type="button" secondary small>
                    <x-heroicon.solid.upload class="h-3.5" />
                    <span>{{ __('Upload') }}</span>
                </x-button>
            </label>

            <x-button secondary small>
                <x-heroicon.solid.x class="h-3.5" />
                <span>{{ __('Remove') }}</span>
            </x-button>
        </div>
    </div>
</x-form.field>