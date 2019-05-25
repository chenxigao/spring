<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-enquiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Spring') - Spring 万花园</title>
    <meta name="description" content="@yield('description', 'flower 爱好者社区')">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')

</head>

<body>

<div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="container">
        @include('common._message')
        @yield('content')
    </div>

    @include('layouts._footer')

</div>

<!-- Script -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')

</body>

</html>