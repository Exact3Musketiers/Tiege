@extends('layouts.app')

@section('content')
    <div id="lastfmBox" class="mx-auto text-center mb-5 container">
        @if(empty(Auth::user()->lastfm))
            To use this feature you need Last.FM connected to your account.
        @else
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
                    <h1 class="card-header">LastFM Leaderboards</h1>
                    <h4>{{$user}}</h4>
                    <h3>{{$fromDate}} - {{$toDate}}</h3>
                    <h4><b> {{count($countWeeklyTracks->track)}} scrobbles</b></h4>
                    @if(Auth::user()->lastfm != $user)
                        <a class="btn btn-primary" href="{{ route('lastfm.compare', ['user' => $user]) }}">
                            <i class="fas fa-not-equal"></i>
                            Compare
                        </a>
                    @endif

                </div>
                <div class="card bg-dark col-lg-12 col-md-12 my-4">
                    <div class="card-header">
                        <h2>Top artists</h2>
                        <h4>{{$fromDate}} - {{$toDate}}</h4>
                    </div>
                    <div class="row">
                        @foreach($data->weeklyArtists->artist as $artist)
                            <div class="card-body col-lg-6 col-md-6 col-sm-12">
                                @if($loop->index == 0)
                                    <span class="badge bg-success">{{ $artist->playcount }}</span>
                                @else
                                    <span class="badge bg-primary">{{ $artist->playcount }}</span>
                                @endif
                                <h2>{{ $artist->name }}</h2>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card bg-transparent col-lg-6 col-md-12">
                    <div class="bg-dark">
                        <div class="card-header">
                            <h2>Top albums</h2>
                            <h4>Last 7 days</h4>
                        </div>
                        <div class="row">
                            @foreach($data->topAlbums->album as $album)
                                @if($loop->index == 0)
                                    <div class="card-body col-lg-12">
                                        <img src={{ $album->image[2]->{"#text"} }}/>
                                        <span class="badge bg-success insideBadge">{{$album->playcount }}</span>
                                        <h2>{{ $album->name }}</h2>
                                        <h3>{{ $album->artist->name }}</h3>
                                    </div>
                                @else
                                    <div class="card-body col-lg-6 col-md-12">
                                        <img src={{ $album->image[1]->{"#text"} }}/>
                                        <span class="badge bg-primary insideBadge">{{ $album->playcount }}</span>
                                        <h2>{{ $album->name }}</h2>
                                        <h3>{{ $album->artist->name }}</h3>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card bg-transparent col-lg-6 col-md-12">
                    <div class="bg-dark">
                        <div class="card-header">
                            <h2>Top tracks</h2>
                            <h4>{{$fromDate}} - {{$toDate}}</h4>
                        </div>
                        <div class="row">
                            @foreach($data->weeklyTracks->track as $track)
                                @if($loop->index == 0)
                                    <div class="card-body col-lg-12">
                                        <img src={{ $track->image[2]->{"#text"} }}/>
                                        <span class="badge bg-success insideBadge">{{ $track->playcount }}</span>
                                        <h2>{{ $track->name }}</h2>
                                        <h3>{{ $track->artist->{"#text"} }}</h3>
                                    </div>
                                @else
                                    <div class="card-body col-lg-6 col-md-12">
                                        <img src={{ $track->image[1]->{"#text"} }}/>
                                        <span class="badge bg-primary insideBadge">{{ $track->playcount }}</span>
                                        <h2>{{ $track->name }}</h2>
                                        <h3>{{ $track->artist->{"#text"} }}</h3>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

