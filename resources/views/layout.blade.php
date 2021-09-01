<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('page') / {{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <meta name="description" content="@yield('page', config('app.description'))">
        <meta name="keywords" content="@yield('page'), tv, series, imdb, ranking">

        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="@yield('page') / {{ config('app.name') }}" />
        <meta property="og:description" content="@yield('description', config('app.description'))" />
        <meta property="og:image" content="{{ asset('img/logo.png') }}" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:site_name" content="{{ config('app.name') }}" />

        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="{{ url()->current() }}">
        <meta name="twitter:creator" content="@jhonzya">
        <meta name="twitter:title" content="@yield('page') / {{ config('app.name') }}">
        <meta name="twitter:description" content="@yield('description', config('app.description'))">
        <meta name="twitter:image" content="{{ asset('img/logo.png') }}">
        <meta name="twitter:image:alt" content="{{ config('app.name') }}">
    </head>
    <body class="flex flex-col h-screen justify-between font-sans">
        <div id="app" class="container mx-auto">
            @yield('container')
        </div>
        <footer class="container mx-auto h-16">
            @include('footer')
        </footer>
    </body>

    <script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</html>
