@if($recentTracks != null)
    <div class="text-center">
        <h4>Now playing:</h4>
        <h3>{{ $recentTracks->track[0]->artist->{'#text'} }}</h3>

        <img src={{ $recentTracks->track[0]->image[1]->{"#text"} }}/>
        <h3>{{ $recentTracks->track[0]->name }}</h3>
        <h6>{{ $recentTracks->track[0]->album->{'#text'} }}</h6>
    </div>
@endif
