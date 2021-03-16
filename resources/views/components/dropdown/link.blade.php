<a {{ $attributes->merge(['class' => 'flex items-center space-x-1 px-3 py-1.5 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-blue-500 hover:text-black dark:hover:text-white']) }}>
    @if($attributes->has('icon'))
        <x-dynamic-component :component="$icon" class="h-4 text-gray-500 dark:text-gray-300" />
    @endif

    <span>{{ $slot }}</span>
</a>