@if(isset($musicFeed['recentTracks']))
    <div class="text-center">
        <h4>Now playing:</h4>
        <h3>{{ $musicFeed['recentTracks']->track[0]->artist->{'#text'} }}</h3>

        <img src={{ $musicFeed['recentTracks']->track[0]->image[1]->{"#text"} }}/>
        <h3>{{ $musicFeed['recentTracks']->track[0]->name }}</h3>
        <h6>{{ $musicFeed['recentTracks']->track[0]->album->{'#text'} }}</h6>
        <a href="{{route('lyrics')}}">See lyrics</a>
        <hr>
        @foreach($musicFeed['friendsTracks'] as $friendMusic)
            @if($friendMusic['user'] != Auth::user()->lastfm)
                {{$friendMusic['user']}}
                <b>{{$friendMusic['artist']}}</b>
                {{$friendMusic['song']}}
            @endif
        @endforeach
    </div>
    {{--    <img src="{{asset('images/equalizer2.gif')}}" width="200"/>--}}

@endif
