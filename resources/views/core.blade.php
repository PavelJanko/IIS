<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/css/app.css">

        <title>Hello, world!</title>
    </head>
    <body>
        @include('partials.navbar-top')
        @yield('content')
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="/js/app.js"></script>
    </body>
</html>
