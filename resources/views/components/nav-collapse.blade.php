@props(['routes', 'title', 'icon'])

@php
    $current_route = Route::currentRouteName();
    $routes = collect($routes);
    $is_current_page = $routes->flatten()->contains($current_route);
@endphp

<li class="mb-1 w-100">
    <button class="btn btn-toggle w-100 align-items-center rounded @if (!$is_current_page) collapsed @endif"
            data-bs-toggle="collapse" data-bs-target="#{{ $routes->first()['route'] }}"
            aria-expanded="{{ $is_current_page }}">
        <i class="{{ $icon }}"></i>
        <span class="ms-1">{{ $title }}</span>
    </button>
    <div class="collapse @if ($is_current_page)) show @endif" id="{{ $routes->first()['route'] }}">
        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
            @foreach($routes as $route)
                <li class="">
                    <a href="{{ route($route['route']) }}"
                       class="rounded rounded ps-5 py-1 w-100 d-block
                        @if ($route['route'] === $current_route)
                            text-secondary
                        @endif
                    ">
                        {{ $route['name'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</li>
