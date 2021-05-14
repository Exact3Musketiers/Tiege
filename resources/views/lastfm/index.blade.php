@extends('layouts.app')

@section('content')
    {{--    //TODO: make this a sidebar or something fancy you know--}}
    <div id="lastfmbox" class="mx-auto text-center mb-5">
        <h1>LastFM Leaderboards</h1>
        <p>Aantal nummers geluisterd van {{$fromDate}} tot {{$toDate}}: <b>{{count($weeklyTracks->track)}}</b></p>
    </div>
@endsection


