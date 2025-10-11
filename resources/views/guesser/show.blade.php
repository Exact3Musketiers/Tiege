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
            <div id="map" style="
                width:450px;
                aspect-ratio: 16 / 9;
                position:absolute;
                bottom: 0;
                border-radius: 0 5px 0 0;
            "></div>
        </div>
    </div>

    <script>
        const map = L.map('map', {
            crs: L.CRS.Simple,
            minZoom: 1,
            maxZoom: 6,
            noWrap: true
        });

        let bound_size = map.getContainer().offsetWidth / 2

        const bounds = [[0, 0], [-bound_size, bound_size]];

        L.tileLayer('./maps/cyberpunk/{z}/{x}/{y}.jpg', {
            noWrap: true,
            minZoom: 1,
            maxZoom: 6,
            tileSize: bound_size,
            bounds: bounds
        }).addTo(map);

        map.fitBounds(bounds);
        map.setMaxBounds(bounds);

        let marker = {}
        map.on('click', function(e) {
            if (marker != undefined) {
                map.removeLayer(marker);
            };

            marker = L.marker(e.latlng).addTo(map);
        })
    </script>
@endsection
