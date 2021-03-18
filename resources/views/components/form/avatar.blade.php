<x-form.field
    {{ $attributes }}
    x-data="{
        originalSrc: '{{ $value->url() ?: asset('img/default_avatar.svg') }}',
        src: '{{ $value->url() ?: asset('img/default_avatar.svg') }}',
        filename: null,
        changeFile: function(file) {
            this.filename = file.name.length > 16 ? file.name.substr(0, 15) + '...' : file.name
            let reader = new FileReader()
            reader.onload = (e) => { this.src = e.target.result }
            reader.readAsDataURL(file)
        },
        clearFile: function() {
            this.filename = null
            this.src = this.originalSrc
            this.$refs.input.value = ''
        }
    }"
>
    <div class="inline-flex items-center group">
        <img x-bind:src="src" class="w-12 h-12 rounded-full" />

        <div class="ml-2 flex items-center">
            <label x-show="!filename">
                <input x-ref="input" type="file" name="{{ $name }}" class="hidden" @change="changeFile($event.target.files[0])" />
                <x-button as="div" type="button" secondary small>
                    <x-heroicon.solid.upload class="h-3.5" />
                    <span>{{ __('Upload') }}</span>
                </x-button>
            </label>

            <x-button type="button" secondary small x-show="filename" @click="clearFile()">
                <span x-text="filename"></span>
                <x-heroicon.solid.x class="h-3.5" />
            </x-button>
        </div>
    </div>
</x-form.field>