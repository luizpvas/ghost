<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ghost</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}"></script>
    </head>
    <body class="font-sans text-base">
        @yield('content')
    </body>
</html>