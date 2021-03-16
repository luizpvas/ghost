<x-form.field {{ $attributes }}>
    <div class="relative text-gray-500 focus-within:text-blue-400">
        <input type="{{ $attributes->get('type', 'text') }}"
            name="{{ $name }}"
            class="
                block w-full text-base border border-gray-300 rounded-sm py-1 px-2 transform duration-200 text-black
                hover:border-blue-300
                focus:border-blue-400 focus:ring-2 focus:ring-blue-100

                @if($attributes->has('icon')) pl-8 @endif
            "
            @if($attributes->has('required')) required @endif
            @if($attributes->has('minlength')) minlength="{{ $minlength }}" @endif
            @if($attributes->has('maxlength')) maxlength="{{ $maxlength }}" @endif
        />

        @if($attributes->has('icon'))
            <div class="absolute top-0 left-0 ml-2 h-full flex items-center">
                <x-dynamic-component :component="$icon" class="h-4" />
            </div>
        @endif
    </div>
</x-form.field>