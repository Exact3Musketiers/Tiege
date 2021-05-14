@if(isset($musicFeed['recentTracks']))
    <div class="text-center music-widget">
        <h4>Now playing:</h4>
        <h3>{{ $musicFeed['recentTracks']->track[0]->artist->{'#text'} }}</h3>

        <img src={{ $musicFeed['recentTracks']->track[0]->image[1]->{"#text"} }}/>
        <h3>{{ $musicFeed['recentTracks']->track[0]->name }}</h3>
        <h6>{{ $musicFeed['recentTracks']->track[0]->album->{'#text'} }}</h6>
        <a href="{{route('lyrics')}}">See lyrics</a>
        <hr>
        @foreach($musicFeed['friendsTracks'] as $friendMusic)
            <div class="row mb-lg-2">
                @if($friendMusic['user'] != Auth::user()->lastfm)
                    <div class="col-lg-4 border-end">
                        <b>{{$friendMusic['user']}}</b>
                    </div>
                    <div class="col-lg-8 m-0 ps-lg-2 pe-lg-2">
                        <div class="row text-lg-start text-sm-center p-0 m-0"><b>{{$friendMusic['artist']}}</b></div>
                        <div class="row text-lg-start text-sm-center p-0 m-0">{{$friendMusic['song']}}</div>
                    </div>
                @endif
            </div>
        @endforeach
        {{--    <img src="{{asset('images/equalizer2.gif')}}" width="200"/>--}}
    </div>
@endif


