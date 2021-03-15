<div data-field="{{ $name }}">
    <label for="{{ $name }}" class="text-gray-900">{{ $attributes->get('label', $name) }}</label>

    @if($attributes->has('hint'))
        <div class="text-sm text-gray-700">{!! $hint !!}</div>
    @endif

    {{ $slot }}

    <div data-validation class="text-red-600 text-sm"></div>
</div>