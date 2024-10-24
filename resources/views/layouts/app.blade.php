<!doctype html>
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
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

</head>

<body>
    <div>
        <div class="container-fluid">
            {{--SIDEBAR--}}
            <div class="row flex-nowrap">
                <button class="btn btn-primary collapse-sidebar mt-3" id="menuToggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseSidebar" aria-expanded="true"
                    aria-controls="collapseSidebar">
                    <i class="fas py-1"></i>
                </button>
                <div class="sidebar-behind collapse show" id="collapseSidebar">
                    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sb-with sidebar text-center">
                        <div class="fs-2 card me-1 bg-dark slide-in-blurred-top mt-5">
                            <a class="slide-rotate-hor-top text-decoration-none" href="{{route('home')}}" id="home">
                                <div class="rainbow rainbow_text_animated">Tige.site</div>
                            </a>
                        </div>

                        <div class="card bg-tertiary-dark me-1 slide-in-left">
                            <div class="profile profile-picture text-center">

                                <div class="profile-text fs-1 fw-bold h-50">
                                    @if(auth()->user() !== null) {{ Auth::user()->name }} @else Gast @endif
                                </div>

                                <div class="fs-4 fw-bold">
                                    @if(auth()->user() !== null)
                                        {{ Auth::user()->role == 0 ? 'Admin' : 'Gebruiker' }}
                                    @else
                                        Gebruiker
                                    @endif
                                </div>
                            </div>
                            <ul class="list-unstyled ps-0 nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                                id="profileMenu">
                                <li class="mb-1">
                                    <button class="btn btn-toggle align-items-center rounded collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#profile-collapse"
                                        aria-expanded="false" id="options">
                                        <i class="fas fa-cog"></i>
                                        <span class="ms-1">Options</span>
                                    </button>
                                    <div class="collapse" id="profile-collapse">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                            @auth
                                                <li><a href="{{ route('profile.edit', Auth::user()) }}" class="rounded">Profile</a></li>
                                                <li>
                                                    <a class="rounded" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                            @endauth
                                            @guest
                                            <li><a href="{{ route('login') }}" class="rounded">Login</a>
                                                @endguest
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="card bg-tertiary-dark me-1 mb-auto slide-in-left">
                            <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                                id="menu">
                                <x-nav-collapse :routes="[
                                    ['name' => 'Random', 'route' => 'numbers.random'],
                                    ['name' => 'Rond Rijden', 'route' => 'driving.index']
                                ]" title="Nummers" icon="far fa-hand-peace" />

                                <x-nav-collapse :routes="[
                                    ['name' => 'SaRCasMIfY', 'route' => 'sarcasm'],
                                    ['name' => 'UwUify', 'route' => 'uwu']
                                ]" title="Textify" icon="fas fa-font" />

                                <x-nav-collapse :routes="[
                                    ['name' => 'Steam', 'route' => 'steam.index'],
                                    ['name' => 'Reviews', 'route' => 'steam.review.all'],
                                    ['name' => 'Wiki Search', 'route' => 'wiki.index']
                                ]" title="Games" icon="fas fa-gamepad" />

                                @auth
                                    <x-nav-collapse :routes="[
                                        ['name' => 'Lyrics', 'route' => 'lyrics'],
                                        ['name' => 'Lastfm', 'route' => 'lastfm'],
                                    ]" title="Muziek" icon="fas fa-music" />
                                @endauth
                            </ul>
                        </div>
                        <hr>
                        <ul class="btn-toggle-nav list-unstyled fw-normal small ">
                            <li class=""><a href="{{ route('policy') }}" class="rounded text-light">policy</a></li>
                        </ul>
                        <hr>
                        @auth
                            @if (auth()->user()->lastfm != null)
                                <div
                                    class="slide-in-elliptic-top-fwd card bg-transparent d-flex flex-column align-items-center align-items-sm-start px-3">
                                    <div class="navbar-dark-under py-3">
                                        <div class="col-12">
                                            @include('partials.music')
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth

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

