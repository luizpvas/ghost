@php
    $themes = [
        'primary' => "
            inline-flex items-center space-x-2 leading-none rounded-sm
            bg-blue-500 text-white border border-blue-600 shadow
            transition duration-100
            hover:bg-blue-400 hover:border-blue-500 focus:ring
        ",
        'secondary' => "
            inline-flex items-center space-x-2 leading-none rounded-sm
            bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-900 shadow-sm
            transition duration-100
            hover:border-gray-400 dark:hover:border-black dark:hover:text-white focus:ring
        "
    ];

    $sizes = [
        'small' => "h-6 px-2",
        'base' => "h-8 px-4",
        'large' => "h-8 px-4"
    ];

    $themeClass = $attributes->has('secondary') ? 'secondary' : 'primary';
    $sizeClass = $attributes->has('small') ? 'small' : ($attributes->has('large') ? 'large' : 'base');
@endphp

<button
    {{ $attributes }}
    class="{{ $themes[$themeClass] . ' ' . $sizes[$sizeClass] }}"
    @if($attributes->has('primary')) style="text-shadow: 0 -1px rgba(0, 0, 0, 0.2);" @endif
>
    {{ $slot }}
</button>