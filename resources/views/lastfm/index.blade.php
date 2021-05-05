@extends('layouts.app')

@section('content')
    {{--    //TODO: make this a sidebar or something fancy you know--}}
    <h2>{{ $recentTracks->track[0]->artist->{'#text'} }}</h2>
    <h3>{{ $recentTracks->track[0]->name }}</h3>
    <h4>{{ $recentTracks->track[0]->album->{'#text'} }}</h4>
    <img src={{ $recentTracks->track[0]->image[2]->{"#text"} }}/>
{{--    {{dd($recentTracks)}}--}}
@endsection
