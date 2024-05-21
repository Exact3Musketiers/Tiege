@extends('layouts.app')

@section('content')
<div class="" style="width: 1000px; height: 1000px" id="map"></div>

<script>

    var map = L.map('map').setView([0, 0], 2);
    let opLat = 0;
    let opLng = 0;
    let markerIn = {};
    let markerOut = {};

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        noWrap: true
    }).addTo(map);

    map.on('click', function(e) {
        let lat = e.latlng.lat;
        let lng = e.latlng.lng;

        opLat = lat * -1;
        if (Math.sign(lng) === -1) {
            opLng = 180 - (lng *-1);
        } else {
            opLng = (180 - lng) *-1;
        }

        if (markerIn !== undefined) {
            map.removeLayer(markerIn);
        }
        if (markerOut !== undefined) {
            map.removeLayer(markerOut);
        }

        markerIn = L.marker([lat, lng]).addTo(map)
            .bindPopup('<a href="https://www.google.com/maps/?q='+lat+','+lng+'&ll='+lat+','+lng+'&z=5" target="_blank">Bekijk de locatie in Maps</a>')
            .openPopup();
        markerOut = L.marker([opLat, opLng]).addTo(map)
            .bindPopup('<a href="https://www.google.com/maps/?q='+opLat+','+opLng+'&ll='+opLat+','+opLng+'&z=5" target="_blank">Bekijk de locatie in Maps</a>')
            .openPopup();
    });

</script>
@endsection
