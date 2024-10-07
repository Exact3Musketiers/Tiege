<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

</head>

<body>
    <div id="app">
        <div class="container-fluid">
            {{--SIDEBAR--}}
            <div class="row flex-nowrap">
                <button class="btn btn-primary collapse-sidebar mt-3" id="menuToggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseSidebar" aria-expanded="true"
                    aria-controls="collapseSidebar" onclick="toggleMenu()">
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

                                <div class="profile-text text-light fs-1 fw-bold h-50">
                                    @if(auth()->user() !== null) {{ Auth::user()->name }} @else Gast @endif
                                </div>

                                <div class="text-muted fs-4 fw-bold">
                                    @if(auth()->user() !== null)
                                    @if(Auth::user()->role == 0)
                                    Admin
                                    @else
                                    Gebruiker
                                    @endif
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
                                <li class="mb-1">
                                    <button class="btn btn-toggle align-items-center rounded collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#numbers-collapse"
                                        aria-expanded="false">
                                        <i class="far fa-hand-peace"></i>
                                        <span class="ms-1">Numbers</span>
                                    </button>
                                    <div class="collapse" id="numbers-collapse">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small" id="numbers">
                                            <li><a href="{{ route('numbers.random') }}"
                                                    class="rounded">Random</a></li>
                                            <li><a href="{{ route('driving.index') }}" class="rounded">Rond rijden</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="mb-1">
                                    <button class="btn btn-toggle align-items-center rounded collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#textify-collapse"
                                        aria-expanded="false">
                                        <i class="fas fa-font"></i><span class="ms-1">Text-ify</span>
                                    </button>
                                    <div class="collapse" id="textify-collapse">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small" id="textify">
                                            <li><a href="{{ route('sarcasm') }}"
                                                    class="rounded">SaRCasMIfY</a></li>
                                            <li><a href="{{ route('uwu') }}" class="rounded">UwUify</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="mb-1">
                                    <button class="btn btn-toggle align-items-center rounded collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#game-collapse"
                                        aria-expanded="false">
                                        <i class="fas fa-gamepad"></i><span class="ms-1">Games</span>
                                    </button>
                                    <div class="collapse" id="game-collapse">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small" id="game">
                                            <li><a href="{{ route('steam.index') }}" class="rounded">Steam</a></li>
                                            <li><a href="{{ route('steam.review.all') }}" class="rounded">reviews</a></li>
                                            <li><a href="{{ route('wiki.index') }}" class="rounded">Wiki Search</a></li>
                                        </ul>
                                    </div>
                                </li>
                                @auth
                                <li class="mb-1">
                                    <button class="btn btn-toggle align-items-center rounded collapsed"
                                        data-bs-toggle="collapse" data-bs-target="#music-collapse"
                                        aria-expanded="false">
                                        <i class="fas fa-music"></i><span class="ms-1">Music</span>
                                    </button>
                                    <div class="collapse" id="music-collapse" id="music">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                            <li><a href="{{ route('lyrics') }}" class="rounded">Lyrics</a>
                                            </li>
                                            <li><a href="{{ route('lastfm') }}" class="rounded">Lastfm</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
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
                <div class="col p-0 wrap-col">
                    <main>
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    //TODO: deze niet already open dingen overriden
    let clickedMobile = false
    let clickedDesktop = true;

    function toggleMenu() {
        const isMobile = window.innerWidth <= 600;
        clickedMobile = document.getElementById("menuToggler").getAttribute("aria-expanded") === 'true' && isMobile;
        clickedDesktop = document.getElementById("menuToggler").getAttribute("aria-expanded") === 'true' && !isMobile;
    }

    function mobileNav() {
        if (window.innerWidth <= 600 && !clickedMobile || window.innerWidth >= 600 && !clickedDesktop) {
            document.getElementById("collapseSidebar").classList.remove("show");
            document.getElementById("menuToggler").setAttribute("aria-expanded", "false");
        } else {
            document.getElementById("collapseSidebar").classList.add("show")
            document.getElementById("menuToggler").setAttribute("aria-expanded", "true");
        }
    }

    window.onload = window.onresize = mobileNav;

    //Hides nav on ctrl+q
    function HideNav(e) {
        var evtobj = window.event ? event : e
        if (evtobj.keyCode == 81 && evtobj.ctrlKey) {
            var sidebar = document.getElementsByClassName('sidebar');
            var sidebarBehind = document.getElementsByClassName('sidebar-behind');
            if (sidebar[0].classList.contains('collapse')) {
                sidebar[0].classList.remove('collapse');
                sidebarBehind[0].classList.remove('collapse')
            } else {
                sidebar[0].classList.add('collapse')
                sidebarBehind[0].classList.add('collapse')
            }
        }
    }

    document.onkeydown = HideNav;


    //Sets current active navbar links
    document.addEventListener("DOMContentLoaded", function () {
        const loc = window.location.href;
        const split = loc.split("/");
        const hrefSelector = document.querySelectorAll("a[href='" + loc + "']");
        if (split[3] == "")
            document.getElementById("home").classList.add('active');
        else {
            // document.getElementById(split[3]).parentNode.children[0].classList.add('active');
            // document.getElementById(split[3]).classList.add('show');
            if (hrefSelector.length > 0)
                document.getElementById(hrefSelector[0].classList.add('active'));
        }
    });
</script>
