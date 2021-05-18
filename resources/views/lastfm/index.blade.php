@extends('layouts.app')

@section('content')
    {{--    //TODO: make this a sidebar or something fancy you know--}}
    <div id="lastfmbox" class="mx-auto text-center mb-5">
        <div class="row">
            <h1 class="card bg-dark col-12">LastFM Leaderboards</h1>

            <div class="card bg-dark">
                <h4>Last week</h4>
                <h3>{{$fromDate}} - {{$toDate}}</h3>
                <b> {{count($weeklyTracks->track)}} scrobbles</b>
            </div>


            <div class="card bg-dark col-lg-6 col-md-12 m-4">
                <div class="card-header">
                    <h2>Top albums</h2>
                </div>
                <div class="row">
                    @foreach($topAlbums->album as $album)
                        <div class="card-body col-lg-6 col-md-12">
                            @if($loop->index == 0)
                                <img src={{ $album->image[2]->{"#text"} }}/>
                                <span class="badge bg-success">{{ $album->playcount }}</span>
                            @else
                                <img src={{ $album->image[1]->{"#text"} }}/>
                                <span class="badge bg-primary">{{ $album->playcount }}</span>
                            @endif
                            <h2>{{ $album->name }}</h2>
                            <h3>{{ $album->artist->name }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
            //TODO: die andere weeklyArtists
            <div class="card bg-dark col-lg-6 col-md-12 m-4">
                <div class="card-header">
                    <h2>Top albums</h2>
                </div>
                <div class="row">
                    @foreach($topAlbums->album as $album)
                        <div class="card-body col-lg-6 col-md-12">
                            @if($loop->index == 0)
                                <img src={{ $album->image[2]->{"#text"} }}/>
                                <span class="badge bg-success">{{ $album->playcount }}</span>
                            @else
                                <img src={{ $album->image[1]->{"#text"} }}/>
                                <span class="badge bg-primary">{{ $album->playcount }}</span>
                            @endif
                            <h2>{{ $album->name }}</h2>
                            <h3>{{ $album->artist->name }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

