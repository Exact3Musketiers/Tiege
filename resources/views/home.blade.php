@php
    $routes = [
        ['link' => route('numbers.random'), 'icon' => 'fas fa-dice-d20', 'text' => 'Random'],
        ['link' => route('driving.index'), 'icon' => 'fas fa-car', 'text' => 'Rond Rijden'],
        ['link' => route('sarcasm'), 'icon' => 'fas fa-font-case', 'text' => 'Sarcasm'],
        ['link' => route('uwu'), 'icon' => 'fas fa-font-case', 'text' => 'UwU'],
        ['link' => route('steam.index'), 'icon' => 'fab fa-steam', 'text' => 'Steam'],
        ['link' => route('steam.review.all'), 'icon' => 'fab fa-steam', 'text' => 'Steam Reviews'],
        ['link' => route('wiki.index'), 'icon' => 'fab fa-wikipedia-w', 'text' => 'Wiki Search'],
        ['link' => route('lyrics'), 'icon' => 'fas fa-music', 'text' => 'Lyrics'],
        ['link' => route('lastfm'), 'icon' => 'fab fa-lastfm', 'text' => 'Muziek'],
    ]
@endphp

@extends('layouts.app')

@section('content')
    <div class="has-background-image lazy position-fixed"
         style="
            background: url({{ asset('images/backgrounds/'.$bg) }}) center center;
            background-repeat: no-repeat;
            background-size: cover;
        ">
    </div>

    <div class="container home">
        <div class="row justify-content-center">
            <div class="row">

                {{-- Left --}}
                <div class="col-lg-8">
                    <div class="my-3">
                        {{-- navigation --}}
                        <div class="card quick-access-box">
                            <div class="card-body">
                                <form action="{{ route('home.search') }}" method="POST">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input name="search" type="text" class="form-control outline-primary"
                                               placeholder="Wat wil je weten?" autofocus>
                                    </div>
                                </form>
                                <div class="d-flex flex-col flex-wrap gap-3">
                                    @each('components.nav-button', $routes, 'route')
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- news --}}
                    <div class=" float-start w-100">
                        <div class="card quick-access-box mb-3">
                            <div class="card-body row">
                                @if (isset($news['error']))
                                    {{$news['error']}}
                                @else
                                    @foreach ($news['articles'] as $article)
                                        <div class="news-item rounded-3 col-xl-3 col-lg-4 col-6 p-2">
                                            <a href="{{ $article->url }}" class="text-black text-decoration-none m-0" target="_blank">
                                                <div class="ratio ratio-1x1 rounded-3 mb-2" style="background: url({{ $article->image->link }}) top center; background-size: cover;"> </div>
                                                <strong>{{ $article->title }}</strong>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right --}}
                <div class="float-end col-lg-4 col-md-12 mt-3">
                    @if(isset($weather['error']))
                        <div class="card quick-access-box mb-3">
                            <p>{{ $weather['error'] }}</p>
                        </div>
                    @else
                        <div class="card quick-access-box to-jas text-center {{ $weather['to_jas'] ? 'red' : 'green' }} mb-3">
                            <h1 class="p-1 mb-0">{{ $weather['to_jas'] ? 'TO JAS :(' : 'NOT TO JAS!!!' }}</h1>
                        </div>

                        <div class="card quick-access-box weather mb-3" style="background: url({{ asset($weather['bram']) }}) top center; background-size: cover;">
                            <div class="weather-wrap px-3 py-5 rounded-3">
                                <h1>{{ $weather['temperature'] }}&deg;C</h1>
                                <h1>{{ $weather['type'] }}</h1>
                                <h1>{{ $weather['wind_bft'] }} Bft - {{ $weather['wind_direction'] }}</h1>
                                <h1>{{ $weather['wind_text'] }}</h1>
                                <small class="location">
                                    @if (!is_null(auth()->user()) && !is_null(auth()->user()->location))
                                        {{ Str::replace(',', ', ', auth()->user()->location) }}
                                    @else
                                        {{ Str::replace(',', ', ', config('services.weather.default_location')) }}
                                    @endif
                                </small>
                            </div>
                        </div>
                    @endif

                    @if (!empty($steamReview))
                        <div class="card quick-access-box mb-3">
                            <img class="top-image card-img-top" src="https://cdn.cloudflare.steamstatic.com/steam/apps/{{ $steamReview->steam_appid }}/header.jpg" alt="{{ $steamReview->name }}">
                            <div class="score">
                                <h1 class="{{ ($steamReview->recomended) ? 'bg-success' : 'bg-danger' }} text-white text-center mb-0 py-1 h2">
                                    {{ ($steamReview->recomended) ? ':)' : ':(' }}
                                </h1>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-1">{{ $steamReview->name }}</h5>
                                <p class="card-text lh-sm mb-1">"<em>{{ $steamReview->review }}</em>"</p>
                                <p class="card-text mb-0">- {{ $steamReview->user->name }}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">{{ $steamReview->playtime_forever }} Gespeeld</small>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

