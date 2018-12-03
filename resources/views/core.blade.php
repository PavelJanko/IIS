<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        {{-- Meta tags --}}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Fonts --}}
        <link href="https://fonts.googleapis.com/css?family=Raleway:200,400,600" rel="stylesheet">

        {{-- CSS --}}
        <link rel="stylesheet" href="/css/app.css">

        {{-- Page title --}}
        <title>{{ config('app.name') }}{!! isset($pageTitle) ? ' &middot; ' . $pageTitle : '' !!}</title>
    </head>
    <body>
        <div id="app">
            @include('partials.navbar-top')
            @yield('layout')
        </div>

        {{-- Scripts --}}
        <script src="/js/app.js"></script>
        @if(session('status'))
            <script>
                swal({
                    title: '{{ session('status')['title'] }}',
                    text: '{{ session('status')['message'] }}',
                    type: '{{ session('status')['type'] }}',
                });
            </script>
        @endif
        @yield('scripts')
    </body>
</html>
