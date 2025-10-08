@push('leaflet')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panorama-wrapper">
            <iframe src="https://cdn.pannellum.org/2.5/pannellum.htm#panorama={{ urlencode('https://upload.wikimedia.org/wikipedia/commons/5/59/360_panorama_-_JR_Shinjuku_Station_south_east_ticket_gates_-_Dec_16_2020.jpeg') }}" allowfullscreen></iframe>
        </div>
    </div>
    <div id="map" class="h-100"></div>
    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.imageOverlay('./images/cyberpunk_map.webp', {
            maxZoom: 1,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    </script>
@endsection
