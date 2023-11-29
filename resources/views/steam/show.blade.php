@extends('layouts.app')

@section('content')
@if (isset($user->steamid))
<div style="
    @if (!empty($selectedGameInfo['background']))
        background-image:url('{{ $selectedGameInfo['background'] }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: fixed;
    @else
        background-color: #1e354e;
    @endif
        min-height: 100vh;
">
{{-- #1a2430 --}}
    <div class="container pt-5" >
        <div class="row">
            <div class="col-lg-8">
                <div class="card text-white bg-dark">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="@if(!$playerSummary->isEmpty()){{ $playerSummary['avatarfull'] }} @else {{ asset('/images/placeholder-square.jpeg') }} @endif" class="img-fluid w-100 rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                @if(!$playerSummary->isEmpty())
                                    <a href="{{ $playerSummary['profileurl'] }}"><h5 class="card-title">{{ $playerSummary['personaname'] }}</h5></a>
                                    <p class="card-text mb-0">Eigenaar van {{ count($ownedGames) }} games!</p>
                                    <p class="card-text">{{ $playerSummary['personaname'] }} heeft {{ $percentagePlayed }}% van die games gespeeld.</p>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:{{ $percentagePlayed }}%" aria-valuenow="{{ $percentagePlayed }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @else
                                    <h5 class="card-title">Oei!</h5>
                                    <p class="card-text">Het ziet er naar uit dat het steam id dat je hebt opgegeven incorrect is</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card text-white bg-dark mt-4">
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if (isset($selectedGameInfo['header_image']))
                                <img src="{{ $selectedGameInfo['header_image'] }}" class="img-fluid w-100 rounded-start" alt="{{ $selectedGameInfo['name'] }}">
                            @else
                                <img src="{{ asset('/images/placeholder-wide.jpeg') }}" class="img-fluid w-100 rounded-start" alt="alternatieve game afbeelding">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body pb-0">
                                @if (isset($selectedGameInfo['name']))
                                    <h5 class="card-title hidden-icon text-center"><a href="steam://run/{{$selectedGameInfo['steam_appid']}}/"> <i class="fas fa-play icon"></i>{{ $selectedGameInfo['name'] }}</a> | speeltijd: {{ $selectedGameInfo['playtime_forever'] }}</h5>
                                @else
                                    <h5 class="card-title text-center">Dit spel heeft geen naam</h5>
                                @endif
                                @if (isset($selectedGameInfo['short_description']))
                                    <p class="card-title">{{ $selectedGameInfo['short_description'] }}</p>
                                @else
                                    <p class="card-title">Dit spel heeft geen beschrijving</p>
                                @endif
                            </div>
                        </div>
                        <form action="{{ route('steam.getNewGame', $user) }}" class="p-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-primary border-primary">Tussen de</span>
                                <input type="number" name="min" class="form-control" placeholder="Minimum minuten gespeeld" aria-label="Username" value="{{ old('min') ?? cache('user.'.$user->getKey().'.minutes', ['min' => null])['min'] }}">
                                <span class="input-group-text bg-primary border-primary">en de</span>
                                <input type="number" name="max" class="form-control" placeholder="Maximum minuten gespeeld" aria-label="Server" value="{{ old('max') ?? cache('user.'.$user->getKey().'.minutes', ['max' => null])['max'] }}">
                                <span class="input-group-text bg-primary border-primary">minuten</span>
                            </div>
                            <button type="submit" class="btn btn-outline-primary w-100">Geef me een ander spel</button>
                        </form>
                    </div>
                </div>
                <div class="card text-white bg-dark mt-4">
                    <div class="row g-0">

                        <div class="card-body m-0">
                            @auth
                                @if (!isset($selectedGameInfo['name']) || $user->getKey() !== Auth()->user()->id)
                                    <h5 class="card-title">Voor dit spel kan je geen feedback geven</h5>
                                @else
                                    @if (isset($steamReview))
                                    <form action="{{ route('steam.update', [$user, $steamReview]) }}" method="post">
                                        @method('PATCH')
                                        @csrf
                                        @include('includes._errors')
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <label class="form-check-label" for="recomendedSwitch">aanbevelen</label>
                                                    <input class="form-check-input" type="checkbox" name="recomended" id="recomendedSwitch"
                                                        @if ((empty(old()) && $steamReview->recomended) || array_key_exists('recomended', old())) checked @endif
                                                    >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="feedback" class="form-label">Wat vond je van {{ $selectedGameInfo['name'] }}?</label>
                                                <textarea class="form-control" name="review" id="feedback" rows="3" placeholder="Ik vind {{ $selectedGameInfo['name'] }}...">{{ old('review') ?? $steamReview->review }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-outline-primary w-100">update</button>
                                        </form>
                                    @else
                                        <form action="{{ route('steam.store', $user) }}" method="post">
                                            @csrf
                                            <div class="mb-3">
                                                <div class="form-check form-switch">
                                                    <label class="form-check-label" for="recomendedSwitch">aanbevelen</label>
                                                    <input class="form-check-input" type="checkbox" name="recomended" id="recomendedSwitch"
                                                        @if (array_key_exists('recomended', old())) checked @endif
                                                    >
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="feedback" class="form-label">Wat vond je van {{ $selectedGameInfo['name'] }}?</label>
                                                <textarea class="form-control" name="review" id="feedback" rows="3" placeholder="Ik vind {{ $selectedGameInfo['name'] }}...">{{ old('review') }}</textarea>
                                            </div>

                                            <button type="submit" class="btn btn-outline-primary w-100">Verstuur</button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                            @guest
                                <h5 class="card-title">Je kan alleen feedback geven als je bent ingelogd.</h5>
                            @endguest
                        </div>
                    </div>
                </div>
                @if ($allReviews->count() > 0)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card text-white bg-dark">
                                <div class="card-header">Anderen zeggen dit:</div>
                            </div>
                        </div>
                        @foreach ($allReviews as $review)
                        <div class="col-md-4 mt-2">
                            <div class="card bg-dark
                                @if ($review->recomended)
                                    border-success
                                @else
                                    border-danger
                                @endif  mb-3 h-100">
                                <div class="card-header">{{ $review->user->name }}</div>
                                <hr class="m-0">
                                <div class="card-body pt-2">
                                    <p class="card-text">{{ $review->review }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card text-white bg-dark">
                    <div class="card-body">
                        @if (count($recentGames) > 0)
                            @foreach ($recentGames as $game)
                                <div class="card w-100 bg-dark">
                                <img src="{{ $game['img_logo_url'] }}" class="card-img-top" alt="{{ $game['name'] }}">
                                <div class="card-body">
                                    <h5 class="card-title hidden-icon text-center"><a href="steam://run/{{$game['appid']}}/"><i class="fas fa-play icon"></i>{{ $game['name'] }}</a></h5>
                                    <hr class="mt-0 mb-2">
                                    <p class="mb-0">Afgelopen 2 weken {{ App\Services\Steam::minutesToHours($game['playtime_2weeks']) }} gespeeld</p>
                                    <p>In totaal {{ App\Services\Steam::minutesToHours($game['playtime_forever']) }} gespeeld</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p>Where recent games?</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container pt-5" >
    <div class="row">
        <div class="col-lg-8">
            <div class="card text-white bg-dark">
                <h1>Check of je je steam account hebt gekoppeld</h1>
                <a href="{{ route('profile.edit', $user) }}">Check het hier</a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
