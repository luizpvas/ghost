<form action="{{ $action }}" method="{{ $attributes->get('method', 'POST') }}">
    @csrf

    {{ $slot }}
</form>