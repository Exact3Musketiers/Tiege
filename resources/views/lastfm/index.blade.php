@extends('layouts.app')

@section('content')
    {{--    //TODO: make this a sidebar or something fancy you know--}}
    <div class="jumbotron jumbotron-fluid mx-auto text-center">
        <h1>{{ $recentTracks->track[0]->artist->{'#text'} }}</h1>
        <h1>{{ $recentTracks->track[0]->name }}</h1>
        <h4>{{ $recentTracks->track[0]->album->{'#text'} }}</h4>
        <img src={{ $recentTracks->track[0]->image[2]->{"#text"} }}/>

        {{--    //TODO: keep trying if nothing is found or something, it sometimes crashes--}}
        @foreach($scrapedLyrics[0] as $sentence)
            <div class="m-0 lyrics-sentence">
                {{
                    (strpos($sentence, "[")
                    ? substr($sentence, strpos($sentence, "[", strlen($sentence)))
                    : strpos($sentence, "]"))
                    ? substr($sentence, 0, strpos($sentence, "]"))
                    : $sentence
                }}
            </div>

        @endforeach
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

    main .jumbotron {
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
