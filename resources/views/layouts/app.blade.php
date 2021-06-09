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
                <button class="btn btn-primary rounded-circle collapse-sidebar mt-3" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSidebar" aria-expanded="true" aria-controls="collapseSidebar">
                    <i class="fas"></i>
                </button>
                <div class="sidebar-behind collapse show mt-5" id="collapseSidebar">
                    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sb-with sidebar text-center">
                        <div class="fs-2 card bg-dark slide-in-blurred-top">
                            <a class="slide-rotate-hor-top text-decoration-none" href="{{route('home')}}">
                                <div class="rainbow rainbow_text_animated">Tige.site</div>
                            </a>
                        </div>

                        <div class="card bg-dark slide-in-left">
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
                                            <li><a href="{{ route('profile') }}" class="link-dark rounded">Profile</a>
                                            </li>
                                            <li><a class="link-dark rounded" href="{{ route('logout') }}"
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
                                </li>
                            </ul>
                        </div>


                        <div class="card bg-dark mb-auto slide-in-left">
                            <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                                id="menu">
                                @if(Auth::user()->role != 1)

                                    <li class="mb-1">
                                        <button class="btn btn-toggle align-items-center rounded collapsed"
                                                data-bs-toggle="collapse" data-bs-target="#numbers-collapse"
                                                aria-expanded="false">
                                            <i class="far fa-hand-peace"></i>
                                            <span class="ms-1">Numbers</span>
                                        </button>
                                        <div class="collapse" id="numbers-collapse">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small" id="numbers">
                                                <li><a href="{{ route('random.index') }}"
                                                       class="link-dark rounded">Random</a></li>
                                                <li><a href="{{ route('currency') }}"
                                                       class="link-dark rounded">Currency</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                                @if(Auth::user()->role != 1)

                                    <li class="mb-1">
                                        <button class="btn btn-toggle align-items-center rounded collapsed"
                                                data-bs-toggle="collapse" data-bs-target="#textify-collapse"
                                                aria-expanded="false">
                                            <i class="fas fa-font"></i><span
                                                class="ms-1">Text-ify</span>
                                        </button>
                                        <div class="collapse" id="textify-collapse">
                                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small" id="textify">
                                                <li><a href="{{ route('sarcasm') }}"
                                                       class="link-dark rounded">SaRCasMIfY</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                                <li class="mb-1">
                                    <button class="btn btn-toggle align-items-center rounded collapsed"
                                            data-bs-toggle="collapse" data-bs-target="#music-collapse"
                                            aria-expanded="false">
                                        <i class="fas fa-music"></i><span
                                            class="ms-1">Music</span>
                                    </button>
                                    <div class="collapse" id="music-collapse" id="music">
                                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                            <li><a href="{{ route('lyrics') }}" class="link-dark rounded">Lyrics</a>
                                            </li>
                                            <li><a href="{{ route('lastfm') }}" class="link-dark rounded">Lastfm</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div
                            class="slide-in-elliptic-top-fwd card bg-transparent d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 min-vh-100">
                            <div class="navbar-dark-under pt-3">
                                <div class="col-12">
                                    @include('partials.music')
                                </div>
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

