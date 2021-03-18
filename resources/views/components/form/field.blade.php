<div
    data-field="{{ $name }}"
    {{ $attributes->only(['x-data',' x-init']) }}
>
    <label for="{{ $name }}" class="block text-gray-900 dark:text-gray-200">{{ $attributes->get('label', $name) }}</label>

    @if($attributes->has('hint'))
        <div class="text-sm text-gray-700 dark:text-gray-400">{!! $hint !!}</div>
    @endif

    {{ $slot }}

    <div data-validation class="text-red-600 dark:text-red-400 text-sm"></div>
</div>