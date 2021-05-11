@extends('layouts.app')

@section('content')
    {{--    //TODO: make this a sidebar or something fancy you know--}}
    <div id="lyricsbox" class="mx-auto text-center mb-5">
        @if(isset($recentTracks))

            <h1>{{ $recentTracks->track[0]->artist->{'#text'} }}</h1>

            <img src={{ $recentTracks->track[0]->image[2]->{"#text"} }}/>
            <h1>{{ $recentTracks->track[0]->name }}</h1>
            <h4>{{ $recentTracks->track[0]->album->{'#text'} }}</h4>

            @if($service)
                <p>Lyrics from: {{$service}}</p>
            @endif

            <button class="btn btn-dark" onclick="changeFont(true)"><i class="fas fa-font"></i><i
                    class="fas fa-plus"></i>
            </button>
            <button class="btn btn-dark" onclick="changeFont(false)"><i class="fas fa-font"></i><i
                    class="fas fa-minus"></i>
            </button>

            <div class="pt-3 pb-5">
                @foreach($scrapedLyrics[0] as $sentence)
                    <div class="m-0 lyrics-sentence">
                        {{$sentence}}
                    </div>
                @endforeach
            </div>
        @else
            {{$scrapedLyrics[0][0]}}
        @endif
    </div>
@endsection
<script>
    function changeFont(direction) {
        const lyrics = document.getElementsByClassName("lyrics-sentence");
        if (!direction)
            for (let i = 0; i < lyrics.length; i++)
                lyrics[i].style.fontSize = parseInt(window.getComputedStyle(lyrics[i], null).getPropertyValue('font-size').replace("px", '')) - 4;
        else
            for (let i = 0; i < lyrics.length; i++)
                lyrics[i].style.fontSize = parseInt(window.getComputedStyle(lyrics[i], null).getPropertyValue('font-size').replace("px", '')) + 4;
    }
</script>

