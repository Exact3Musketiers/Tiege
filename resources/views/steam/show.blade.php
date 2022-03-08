@extends('layouts.app')

@section('content')
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
                                <img src="{{ $playerSummary['avatarfull'] }}" class="img-fluid w-100 rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <a href="{{ $playerSummary['profileurl'] }}"><h5 class="card-title">{{ $playerSummary['personaname'] }}</h5></a>
                                <p class="card-text mb-0">Eigenaar van {{ count($ownedGames) }} games!</p>
                                <p class="card-text">{{ $playerSummary['personaname'] }} heeft {{ $percentagePlayed }}% van die games gespeeld.</p>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width:{{ $percentagePlayed }}%" aria-valuenow="{{ $percentagePlayed }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card text-white bg-dark mt-4">
                    <div class="row g-0">
                        <div class="col-md-4">
                                <img src="{{ $selectedGameInfo['header_image'] }}" class="img-fluid w-100 rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body pb-0">
                                <h5 class="card-title">{{ $selectedGameInfo['name'] }} | speeltijd: {{ $selectedGameInfo['playtime_forever'] }}</h5>
                                <p class="card-text mb-0"> {{ $selectedGameInfo['short_description'] }} </p>
                            </div>
                        </div>
                        <Submit-button></Submit-button>
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
                            <div class="mb-3">
                                <label for="feedback" class="form-label">Wat vond je van {{ $selectedGameInfo['name'] }}?</label>
                                <textarea class="form-control" name="feedback" id="feedback" rows="3" placeholder="Ik vind {{ $selectedGameInfo['name'] }}..."></textarea>
                            </div>
                            <button class="btn btn-outline-primary w-100">Verstuur</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card text-white bg-dark">
                    <div class="card-body">
                        @foreach ($recentGames as $game)
                            <div class="card w-100 bg-dark" style="width: 18rem;">
                            <img src="{{ $game['img_logo_url'] }}" class="card-img-top" alt="{{ $game['name'] }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $game['name'] }}</h5>
                                <hr class="mt-0 mb-2">
                                <p class="mb-0">Afgelopen 2 weken {{ App\Services\Steam::minutesToHours($game['playtime_2weeks']) }} gespeeld</p>
                                <p>In totaal {{ App\Services\Steam::minutesToHours($game['playtime_forever']) }} gespeeld</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
