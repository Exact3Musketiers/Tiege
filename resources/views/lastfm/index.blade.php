@extends('layouts.app')

@section('content')
    {{--    //TODO: make this a sidebar or something fancy you know--}}
    <div id="lyricsbox" class="mx-auto text-center mb-5">
        <h1>{{ $recentTracks->track[0]->artist->{'#text'} }}</h1>

        <img src={{ $recentTracks->track[0]->image[2]->{"#text"} }}/>
        <h1>{{ $recentTracks->track[0]->name }}</h1>
        <h4>{{ $recentTracks->track[0]->album->{'#text'} }}</h4>
        <div class="pt-3 pb-5">
            @foreach($scrapedLyrics[0] as $sentence)
                <div class="m-0 lyrics-sentence">
                    {{$sentence}}
                </div>
            @endforeach
        </div>
    </div>


    {{--    <form method="POST" id="lyricsForm" action="{{ route('Lastfm.fetch') }}">--}}
    {{--        @csrf--}}

    {{--        <div class="form-group row mb-0">--}}
    {{--            <div class="col-md-8 offset-md-4">--}}
    {{--                <button type="submit" class="btn btn-primary">--}}
    {{--                    {{ __('Get Lyrics') }}--}}
    {{--                </button>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </form>--}}
@endsection

<style>
    body {
        background-color: #2a2c2d !important;
    }

    #lyricsbox {
        background-color: #313334;
        color: #c5c1bc;
    }

    .lyrics-sentence {
        font-size: 18px;
    }

    .lyrics-sentence:hover {
        background: #252931;
    }

</style>
