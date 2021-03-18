@php
    $tag = $attributes->get('as', 'button');

    $base = 'inline-flex items-center leading-none rounded-sm cursor-pointer transition duration-100';

    $themes = [
        'primary' => "
            bg-blue-500 text-white border border-blue-600 shadow
            hover:bg-blue-400 hover:border-blue-500 focus:ring
        ",
        'secondary' => "
            bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-900 shadow-sm
            hover:border-gray-400 dark:hover:border-black dark:hover:text-white focus:border-blue-400 focus:ring
        "
    ];

    $sizes = [
        'small' => "text-sm h-6 px-1 space-x-1",
        'base' => "h-8 px-4 space-x-2",
        'large' => "h-8 px-4 space-x-3"
    ];

    $themeClass = $attributes->has('secondary') ? 'secondary' : 'primary';
    $sizeClass = $attributes->has('small') ? 'small' : ($attributes->has('large') ? 'large' : 'base');
@endphp

<{{ $tag }}
    {{ $attributes }}
    class="{{ $base . ' ' . $themes[$themeClass] . ' ' . $sizes[$sizeClass] }}"
    @if($attributes->has('primary')) style="text-shadow: 0 -1px rgba(0, 0, 0, 0.2);" @endif
>
    {{ $slot }}
</{{ $tag }}>