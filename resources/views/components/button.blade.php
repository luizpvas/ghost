<button
    {{ $attributes }}

    @if($attributes->has('primary'))
        class="
            inline-flex items-center space-x-2 leading-none h-8 rounded-sm
            bg-blue-500 text-white border border-blue-600 px-4 shadow
            transition duration-100
            hover:bg-blue-400 hover:border-blue-500 focus:ring
        "
        style="text-shadow: 0 -1px rgba(0, 0, 0, 0.2);"
    @endif
>
    {{ $slot }}
</button>