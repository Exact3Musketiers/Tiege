@extends('layouts.app')

@section('content')
    <div id="lastfmBox" class="mx-auto text-center container">
        <div class="row">
            <div class="card bg-dark">
                @if(Auth::user()->lastfm != $user)
                    <a class="btn btn-primary position-absolute start-0" href="{{route('lastfm')}}">
                        <i class="fad fa-backward"></i>
                        {{Auth::user()->lastfm}}
                    </a>
                @endif
                <p class="position-absolute end-0">Powered by AudioScrobbler</p>
            </div>

            <div class="card bg-dark align-items-center mt-5">
                <h1 class="card-header">LastFM VERSUS MODE</h1>
                <div class="d-flex">
                    <h4 class="border-2 border-bottom border-primary me-2">{{Auth::user()->lastfm}}</h4>
                    <h3>VS</h3>
                    <h4 class="border-2 border-bottom border-danger ms-2">{{$user}}</h4>
                </div>

            </div>
            <hr/>

            {{--Last week--}}
            <div class="card bg-dark">
                <div class="card-header">
                    <h4>Last week</h4>
                    <h3>{{$fromDate}} - {{$toDate}}</h3>
                    <h4>
                        <b> {{count($userCountWeeklyTracks->track)}} scrobbles</b>
                        VS
                        <b> {{count($countWeeklyTracks->track)}} scrobbles</b>
                    </h4>

                    <div class="progress">
                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             style={{"width:" . count($userCountWeeklyTracks->track) / (count($countWeeklyTracks->track) + count($userCountWeeklyTracks->track)) * 100 . '%'}}></div>
                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             style={{"width:" . count($countWeeklyTracks->track) / (count($countWeeklyTracks->track) + count($userCountWeeklyTracks->track)) * 100 . '%'}}></div>
                    </div>

                </div>
            </div>
            <hr/>
            {{--Weekly--}}
            <div class="card bg-dark">
                <div class="card-header">
                    <h4>Weekly running</h4>
                    <h3>{{$toDate}} - Now</h3>
                    <h4>
                        <b> {{count($userData->weeklyRunningTracks->track)}} scrobbles</b>
                        VS
                        <b> {{count($data->weeklyRunningTracks->track)}} scrobbles</b>
                    </h4>

                    <div class="progress">
                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             style={{"width:" . count($userData->weeklyRunningTracks->track) / (count($data->weeklyRunningTracks->track) + count($userData->weeklyRunningTracks->track)) * 100 . '%'}}></div>
                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             style={{"width:" . count($data->weeklyRunningTracks->track) / (count($data->weeklyRunningTracks->track) + count($userData->weeklyRunningTracks->track)) * 100 . '%'}}></div>
                    </div>

                </div>
            </div>
            <hr/>

            {{--Today--}}
            <div class="card bg-dark">
                <div class="card-header">
                    <h4>Today</h4>
                    <h4>
                        <b> {{count($userData->dailyTracks->track)}} scrobbles</b>
                        VS
                        <b> {{count($data->dailyTracks->track)}} scrobbles</b>
                    </h4>

                    <div class="progress">
                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             style={{"width:" . count($userData->dailyTracks->track) / (count($data->dailyTracks->track) + count($userData->dailyTracks->track)) * 100 . '%'}}></div>
                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             style={{"width:" . count($data->dailyTracks->track) / (count($data->dailyTracks->track) + count($userData->dailyTracks->track)) * 100 . '%'}}></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

