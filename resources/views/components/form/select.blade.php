<x-form.field {{ $attributes }}>
    <select
        name="{{ $name }}"
        class="
            block w-full text-base border rounded-sm py-1 px-2 transform duration-200
            bg-white text-black border-gray-300 dark:bg-gray-900 dark:text-white dark:border-gray-900
            focus:border-blue-400 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-700

            @if($attributes->has('icon')) pl-8 @endif
        "
        @if($attributes->has('required')) required @endif
    >
        @foreach($options as $key => $text)
            <option
                value="{{ $key }}"
                @if($key == $value) selected @endif
            >
                {{ $text}}
            </option>
        @endforeach
    </select>
</x-form.field>