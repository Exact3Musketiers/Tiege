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
            {{--SIDEBAR--}}
            <div class="row flex-nowrap">
                <div class="sidebar-behind">
                </div>

                <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sb-with sidebar text-center mt-3">
                    <a href="{{route('home')}}">
                        <img src="{{asset('images/logo-white.png')}}" width="25%">
                    </a>
                    <div class="card bg-dark">
                        <div class="profile profile-picture text-center">

                            <div class="text-light fs-1 fw-bold h-50">
                                {{ Auth::user()->name }}
                            </div>

                            <div class="text-muted fs-4 fw-bold">
                                @if(Auth::user()->role == 0)
                                    Admin
                                @else
                                    User
                                @endif
                            </div>
                        </div>

                        <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                            id="profileMenu">
                            <li>
                                <a href="#options" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                    <i class="fas fa-cog"></i><span
                                        class="ms-1 d-none d-sm-inline">Options</span> </a>
                                <ul class="collapse nav flex-column ms-1" id="options" data-bs-parent="#profileMenu">
                                    <li class="w-100">
                                    <li>
                                        <a href="{{ route('profile') }}" class="nav-link px-0">
                                            <span class="d-none d-sm-inline"></span>Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="nav-link px-0" href="{{ route('logout') }}"
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
                            </li>
                        </ul>
                    </div>


                    <div class="card bg-dark">
                        <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                            id="menu">
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link align-middle px-0" id="home">
                                    <i class="fas fa-home"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                                </a>
                            </li>
                            @if(Auth::user()->role != 1)

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
                            @endif
                            @if(Auth::user()->role != 1)

                                <li>
                                    <a href="#textify" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                        <i class="fas fa-font"></i><span
                                            class="ms-1 d-none d-sm-inline">Text-ify</span> </a>
                                    <ul class="collapse nav flex-column ms-1" id="textify" data-bs-parent="#menu">
                                        <li class="w-100">
                                        <li>
                                            <a href="{{ route('sarcasm') }}" class="nav-link px-0"> <span
                                                    class="d-none d-sm-inline"></span>SaRCasMIfY</a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            <li>
                                <a href="#music" data-bs-toggle="collapse" class="nav-link px-0 align-middle ">
                                    <i class="fas fa-music"></i> <span class="ms-1 d-none d-sm-inline">Music</span></a>
                                <ul class="collapse nav flex-column ms-1" id="music" data-bs-parent="#menu">
                                    <li class="w-100">
                                        <a href="{{ route('lyrics') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline"></span>Lyrics</a>
                                    </li>
                                    <li class="w-100">
                                        <a href="{{ route('lastfm') }}" class="nav-link px-0"> <span
                                                class="d-none d-sm-inline"></span>Lastfm</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div
                        class="card bg-transparent d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                        <div class="navbar-dark-under pt-3">
                            <div class="col-12">
                                @include('partials.music')
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
            document.getElementById(split[3]).parentNode.children[0].classList.add('active');
            document.getElementById(split[3]).classList.add('show');
            if (hrefSelector.length > 0)
                document.getElementById(hrefSelector[0].classList.add('active'));
        }

        // Hide Navbar on scroll down
        var prevScrollpos = window.pageYOffset;
        window.onscroll = function () {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                document.getElementById("navbar").style.top = "0";
            } else {
                document.getElementById("navbar").style.top = "-80px";
            }
            prevScrollpos = currentScrollPos;

        }


    });
</script>
