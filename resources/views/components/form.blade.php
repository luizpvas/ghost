<form action="{{ $action }}" method="{{ $attributes->get('method', 'POST') == 'POST' ? 'POST' : 'POST' }}">
    @csrf
    @method($attributes->get('method', 'POST'))

    {{ $slot }}
</form>