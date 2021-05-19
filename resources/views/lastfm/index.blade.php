@extends('layouts.app')

@section('content')
    <div id="lastfmBox" class="mx-auto text-center mb-5 container">
        <div class="row">
            <div class="card bg-dark">
                <h1 class="card-header">LastFM Leaderboards</h1>
                @if(Auth::user()->lastfm != $user)
                    <button class="btn btn-primary position-absolute"><i class="fad fa-backward"></i> Back</button>
                @endif
                <h4>{{$user}}</h4>
                <h4>Last week</h4>
                <h3>{{$fromDate}} - {{$toDate}}</h3>
                <h4><b> {{count($countWeeklyTracks->track)}} scrobbles</b></h4>
            </div>
            <div class="card bg-dark col-lg-12 col-md-12 my-4">
                <div class="card-header">
                    <h2>Top artists</h2>
                </div>
                <div class="row">
                    @foreach($weeklyArtists->artist as $artist)
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
                    </div>
                    <div class="row">
                        @foreach($topAlbums->album as $album)
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
                    </div>
                    <div class="row">
                        @foreach($weeklyTracks->track as $track)
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
    </div>
@endsection

