<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('page')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body class="font-fixed h-screen bg-gray-800 text-white">
        <div id="app" class="container mx-auto">
            @yield('container')
        </div>
    </body>

    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</html>
