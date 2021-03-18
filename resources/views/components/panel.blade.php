<div {{ $attributes->merge(['class' => 'flex border bg-white dark:bg-gray-800 dark:border-gray-900 p-unit rounded shadow-sm']) }}>
    <div class="w-1/3 mr-unit">
        <div class="font-bold flex items-center space-x-1 text-gray-800 dark:text-gray-200">{{ $title }}</div>
        <div class="text-sm text-gray-700 dark:text-gray-300">{{ $description }}</div>
    </div>

    <div class="w-2/3 flex-shrink-0">
        {{ $slot }}
    </div>
</div>