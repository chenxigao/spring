<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-enquiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Spring') - {{ setting('site_name', 'Spring 万花园') }}</title>
    <meta name="description" content="@yield('description', setting('sep_description', '！'))">
    <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'Spring 社区，论坛，鲜花爱好者论坛。'))">

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

@if(app()->isLocal())
    @include('sudosu::user-selector')
@endif

<!-- Script -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')

</body>

</html>