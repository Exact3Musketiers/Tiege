<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
<div id="app">
    @auth
        <div class="container-fluid">
            <div class="row flex-nowrap">
                <div class="bg-dark sidebar-behind">
                </div>
                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark sb-with sidebar">
                    <div
                        class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                        <a href="{{ route('home') }}"
                           class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-decoration-none text-primary">
                            <span class="fs-5 d-none d-sm-inline">{{ config('app.name', 'Tiege.test') }}</span>
                        </a>
                        <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                            id="menu">
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link align-middle px-0" id="home">
                                    <i class="fas fa-home"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="#numbers" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="far fa-hand-peace"></i><span
                                        class="ms-1 d-none d-sm-inline">Numbers</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="numbers" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="{{ route('random.index') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline"></span>Random</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('currency') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline"></span>Currency</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#music" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                    <i class="fas fa-music"></i> <span class="ms-1 d-none d-sm-inline">Music</span></a>
                                <ul class="collapse nav flex-column ms-1" id="music" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="{{ route('lyrics') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline"></span>Lyrics</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        {{--    //TODO: fix width of this thingy, cause it's a big biatch--}}
                        <div class="navbar-dark-under pt-3">
                            <div class="col-12">
                                @include('partials.music')
                            </div>
                            <hr>
                            <div class="dropdown pb-4">
                                <a href="#"
                                   class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                                   id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{asset("images/avatar.png")}}" alt="hugenerd" width="30" height="30"
                                         class="rounded-circle">
                                    <span class="d-none d-sm-inline mx-1">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endauth
                <div class="col p-0 wrap-col">
                    <main>
                        @yield('content')
                    </main>
                </div>
                @auth
            </div>
        </div>
    @endauth


</div>
</body>
</html>

<script>
    //Sets current active navbar links
    document.addEventListener("DOMContentLoaded", function () {
        const loc = window.location.href;
        const split = loc.split("/");
        const hrefSelector = document.querySelectorAll("a[href='" + loc + "']");
        if(split[3] == "")
            document.getElementById("home").classList.add('active');
        else {
            document.getElementById(split[3]).parentNode.children[0].classList.add('active');
            document.getElementById(split[3]).classList.add('show');
            if (hrefSelector.length > 0)
                document.getElementById(hrefSelector[0].classList.add('active'));
        }
    });
</script>
