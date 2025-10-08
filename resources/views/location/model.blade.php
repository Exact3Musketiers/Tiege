@push('leaflet')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
@endpush


@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-3">
            <div class="content-box">
                <div class="card-header">
                    <h1 class="h5"><a href="{{ route('location.index') }}"><i class="fas fa-angle-left pe-2"></i>terug</a> | Voeg een locatie toe voor Cyber Guesser</h1>
                </div>
                <hr class="m-0">
                <div class="card-body">
                    <form action="{{ $location->getActionRoute() }}" method="post">
                        @if($location->exists)
                            @method('PATCH')
                        @endif
                        @csrf
                        @include('includes._errors')

                        <div class="mb-3">
                            <label for="name" class="form-label">Naam</label>
                            <input class="form-control" name="name" id="name" value="{{ old('name') ?? $location->name }}"  placeholder="Naam" type="number">
                        </div>

                        <div class="mb-3">
                            <label for="panorama" class="form-label">Panorama</label>
                            <input name="" type="file" id="panorama" accept="image/png,image/jpg" class="form-control file" placeholder="Panorama">
                        </div>

                        <div class="mb-3">

                        </div>
                        <div id="map" style="height: 500px"></div>


                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Afbeelding</label>
                            <input name="thumbnail" type="file" id="thumbnail" accept="image/png,image/jpg" class="form-control file" placeholder="Thumbnail">
                        </div>

                        <button type="submit" class="btn btn-outline-primary w-100">Opslaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.imageOverlay('../../images/cyberpunk_map.webp', {
            maxZoom: 1,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    </script>
@endsection

