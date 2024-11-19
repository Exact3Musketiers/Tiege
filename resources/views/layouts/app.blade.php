<!doctype html>
@php
    if (request()->has('refresh')) {
        Cache::forget('background_image');
    }

    $user = auth()->user();

    if (!is_null($user)) {
        if (!is_null($background_image = $user->background_image_path)) {
            $bg = $background_image;
        } else {
            $bg = null;
        }
    } else {
        $bg = Cache::remember('background_image', 3600, function () {
            $bg_count = count(File::files(public_path('images/backgrounds')));
            return asset('images/backgrounds/'.rand(1, $bg_count).'.jpg');
        });
    }
@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @vite('resources/js/app.js')

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

</head>

<body>
<div class="has-background-image lazy position-fixed"
     @if (!is_null($bg))
         style="
                background: url({{ $bg }}) center center;
                background-repeat: no-repeat;
                background-size: cover;
            "
    @endif
>
</div>
<div>
    <nav class="navbar w-100">
        <button class="fs-5 ms-3 me-lg-3 sidebar-button" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                aria-controls="sidebar">
            <i class="fas fa-bars"></i>
        </button>
        <a class="text-decoration-none" href="{{route('home')}}" id="home">
            <div class="rainbow rainbow_text_animated">Tige.site</div>
        </a>
        <div style="width: 54px"></div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="offcanvas offcanvas-start sidebar p-0" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
                <div class="position-relative">
                    <a class="text-decoration-none " href="{{route('home')}}" id="home">
                        <div class="rainbow rainbow_text_animated">Tige.site</div>
                    </a>
                    <button class="fs-5 sidebar-button close" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                            aria-controls="sidebar">
                        <i class="fas fa-times"></i>
                    </button>

                    <div class="offcanvas-body">
                        <div class="card bg-tertiary-dark mb-2">
                            @include('includes.profileManagement')
                        </div>
                        <div class="card bg-tertiary-dark mb-auto">
                            <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                                id="menu">
                                <x-nav-collapse :routes="[
                                    ['name' => 'Random', 'route' => 'numbers.random'],
                                    ['name' => 'Rond Rijden', 'route' => 'driving.index']
                                ]" title="Nummers" icon="far fa-hand-peace"/>

                                <x-nav-collapse :routes="[
                                    ['name' => 'SaRCasMIfY', 'route' => 'sarcasm'],
                                    ['name' => 'UwUify', 'route' => 'uwu']
                                ]" title="Textify" icon="fas fa-font"/>

                                <x-nav-collapse :routes="[
                                    ['name' => 'Steam', 'route' => 'steam.index'],
                                    ['name' => 'Reviews', 'route' => 'steam.review.all'],
                                    ['name' => 'Wiki Search', 'route' => 'wiki.index']
                                ]" title="Games" icon="fas fa-gamepad"/>

                                @auth
                                    <x-nav-collapse :routes="[
                                        ['name' => 'Lyrics', 'route' => 'lyrics'],
                                        ['name' => 'Lastfm', 'route' => 'lastfm'],
                                    ]" title="Muziek" icon="fas fa-music"/>
                                @endauth
                            </ul>
                        </div>
                        <hr>
                        <ul class="btn-toggle-nav list-unstyled fw-normal ps-3">
                            <li class=""><a href="{{ route('policy') }}" class="rounded text-light">policy</a></li>
                        </ul>
                        <hr>
                        @auth
                            @if (auth()->user()->lastfm != null)
                                @include('includes.music')
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
            <div class="col p-0">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</div>
</body>
</html>

