@php
    $bg = Cache::remember('background_image', 3600, function () {
        $bg_count = count(File::files(public_path('images/backgrounds')));
        return asset('images/backgrounds/'.rand(1, $bg_count).'.jpg');
    });
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite('resources/js/app.js')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
</head>

<body class="full-page">
    <div class="row w-100 h-100 m-0">
        <div class="col-xs-12 col-md-8 col-lg-6 bg-dark h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-md-8 fs-5 bg-dark">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="col text-center justify-content-center align-items-center d-block d-none d-md-flex"
            @if (!is_null($bg))
                style="
            background: url({{ $bg }}) center center;
            background-repeat: no-repeat;
            background-size: cover;
            "
            @endif>
            <div class="bg-dark-opacity">
                <img class="img-fluid p-5" src="{{ asset('/images/logo-white.png') }}" alt="">
            </div>
        </div>
    </div>
</body>
</html>
