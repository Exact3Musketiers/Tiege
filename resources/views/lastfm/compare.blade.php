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
            <h1>Scrobbles</h1>
            {{--Last week--}}
            <div class="card bg-dark">
                <div class="card-header">
                    <h3>Last week</h3>
                    <h4>{{$fromDate}} - {{$toDate}}</h4>

                    @if(isset($userCountWeeklyTracks->track[0]) || isset($countWeeklyTracks->track[0]))
                    <div class="progress">
                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             style={{"width:" . count($userCountWeeklyTracks->track) / (count($countWeeklyTracks->track) + count($userCountWeeklyTracks->track)) * 100 . '%'}}>
                            {{count($userCountWeeklyTracks->track)}}
                        </div>
                        <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             style={{"width:" . count($countWeeklyTracks->track) / (count($countWeeklyTracks->track) + count($userCountWeeklyTracks->track)) * 100 . '%'}}>
                            {{count($countWeeklyTracks->track)}}
                        </div>
                    </div>
                    @else
                        Both users have 0 scrobbles
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    @endif

                </div>
            </div>
            <hr/>
            {{--Weekly--}}
            <div class="card bg-dark">
                <div class="card-header">
                    <h3>Weekly running</h3>
                    <h4>{{$toDate}} - Now</h4>

                    @if(isset($userData->weeklyRunningTracks->track[0]) || isset($data->weeklyRunningTracks->track[0]))
                        <div class="progress">
                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                 role="progressbar"
                                 style={{"width:" . count($userData->weeklyRunningTracks->track) / (count($data->weeklyRunningTracks->track) + count($userData->weeklyRunningTracks->track)) * 100 . '%'}}>
                                {{count($userData->weeklyRunningTracks->track)}}
                            </div>
                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                                 role="progressbar"
                                 style={{"width:" . count($data->weeklyRunningTracks->track) / (count($data->weeklyRunningTracks->track) + count($userData->weeklyRunningTracks->track)) * 100 . '%'}}>
                                {{count($data->weeklyRunningTracks->track)}}
                            </div>
                        </div>
                    @else
                        Both users have 0 scrobbles
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    @endif

                </div>
            </div>
            <hr/>

            {{--Today--}}
            <div class="card bg-dark">
                <div class="card-header">
                    <h3>Today</h3>

                    @if(isset($userData->dailyTracks->track[0]) || isset($data->dailyTracks->track[0]))
                        <div class="progress">
                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated"
                                 role="progressbar"
                                 style={{"width:" . count($userData->dailyTracks->track) / (count($data->dailyTracks->track) + count($userData->dailyTracks->track)) * 100 . '%'}}>
                                {{count($userData->dailyTracks->track)}}
                            </div>
                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                                 role="progressbar"
                                 style={{"width:" . count($data->dailyTracks->track) / (count($data->dailyTracks->track) + count($userData->dailyTracks->track)) * 100 . '%'}}>
                                {{count($data->dailyTracks->track)}}
                            </div>
                        </div>
                    @else
                        Both users have 0 scrobbles
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                 aria-valuemax="100"></div>
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
@endsection

