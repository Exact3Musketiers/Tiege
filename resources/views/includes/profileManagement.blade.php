<div class="profile text-center">
    <div class="profile-text fs-1 fw-bold h-50">
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
        <button class="btn btn-toggle align-items-center rounded collapsed w-100"
                data-bs-toggle="collapse" data-bs-target="#profile-collapse"
                aria-expanded="false" id="options">
            <i class="fas fa-cog ms-1"></i>
            <span class="ms-1">Opties</span>
        </button>
        <div class="collapse" id="profile-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                @auth
                    <li>
                        <a href="{{ route('profile.edit', Auth::user()) }}" class="rounded ps-5 py-1 w-100 d-block">
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
                    <li><a href="{{ route('login') }}" class="rounded">Login</a>
                @endguest
            </ul>
        </div>
    </li>
</ul>
