    <div class="navbar-dark-under py-3 w-100 mx-auto d-block">
            <div class="text-center">
                @if(!empty(Auth::user()->lastfm))
                    @if(isset($musicFeed['recentTracks']))

                        <h4>Now playing:</h4>
                        <h3>{{ Str::limit($musicFeed['recentTracks']->track[0]->artist->{'#text'}, 35) }}</h3>

                        <img src="{{ $musicFeed['recentTracks']->track[0]->image[1]->{"#text"} }}" alt="Album image" />
                        <h3>{{ Str::limit($musicFeed['recentTracks']->track[0]->name, 35) }}</h3>
                        <h6>{{ Str::limit($musicFeed['recentTracks']->track[0]->album->{'#text'}, 60) }}</h6>
                        <a href="{{route('lyrics')}}">See lyrics</a>
                    @endif
                @endif
                {{-- <h4>Friendsfeed:</h4>
                <hr>
                @foreach($musicFeed['friendsTracks'] as $friendMusic)
                    <div class="row mb-lg-2">
                        @if($friendMusic['user'] != Auth::user()->lastfm)
                            <div class="col-lg-4 border-end">
                                <a href="{{ route('lastfm', ['user' => $friendMusic['user']]) }}">
                                    <b>{{$friendMusic['name']}}</b></a>
                            </div>
                            <div class="col-lg-8 m-0 ps-lg-2 pe-lg-2">
                                <div class="row text-lg-start text-sm-center p-0 m-0"><b>{{$friendMusic['artist']}}</b></div>
                                <a href="{{ route('lyrics', ['user' => $friendMusic['user']]) }}">
                                    <div class="row text-lg-start text-sm-center p-0 m-0">{{$friendMusic['song']}}</div>
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach --}}
        </div>
    </div>
