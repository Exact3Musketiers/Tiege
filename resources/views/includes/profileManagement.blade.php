@php
    $current_route = Route::currentRouteName();
    $route = 'profile.edit';
    $is_current_page = $route === $current_route;
@endphp

<div class="profile text-center p-2">
    <div class="profile-text fs-1 fw-bold h-50 text-nowrap overflow-x-hidden">
        @if(auth()->user() !== null)
            {{ Auth::user()->name }}
        @else
            Gast
        @endif
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
    <li class="mb-1 w-100">
        <button class="btn btn-toggle align-items-center rounded @if (!$is_current_page) collapsed @endif w-100"
                data-bs-toggle="collapse" data-bs-target="#{{ $route }}"
                aria-expanded="{{ $is_current_page }}">
            <i class="fas fa-cog ms-1"></i>
            <span class="ms-1">Opties</span>
        </button>
        <div class="collapse @if ($is_current_page)) show @endif" id="{{ $route }}">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                @auth
                    <li>
                        <a href="{{ route('profile.edit', Auth::user()) }}" class="rounded ps-5 py-1 w-100 d-block
                            @if ($route === $current_route)
                                text-secondary
                            @endif
                        ">
                            Profiel
                        </a>
                    </li>
                    <li>
                        <a class="rounded rounded ps-5 py-1 w-100 d-block" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Uitloggen
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              class="d-none">
                            @csrf
                        </form>
                    </li>
                @endauth
                @guest
                    <li><a href="{{ route('login') }}" class="rounded rounded ps-5 py-1 w-100 d-block">Login</a>
                @endguest
            </ul>
        </div>
    </li>
</ul>
