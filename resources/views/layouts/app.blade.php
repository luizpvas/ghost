<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Ghost</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <script src="{{ mix('js/app.js') }}"></script>

        <template id="reflinks-disable-with-spinner">
            <svg class="animate-spin -ml-1 mr-3 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </template>
    </head>
    <body class="bg-white text-black dark:bg-gray-700 dark:text-white font-sans text-base">
        @yield('content')
    </body>
</html>