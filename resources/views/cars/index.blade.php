@php
    use App\Models\RefuelingStat
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="py-3">
            <h1>Auto Efficiency</h1>
            <p>Houd hier bij hoe efficient je auto is. Vul in hoeveel je tankt en hoeveel kilometers en hoeveel kilometer je hebt gereden> Je kan ook je auto toevoegen Als je dat leuk lijkt!</p>
            @guest
                <h5>Om je kilometers bij te houden moet je wel inloggen.</h5>
                <a href="{{ route('login') }}" class="btn btn-primary text-white">Login</a>
                <span class="px-2">|</span>
                <a href="{{ route('register') }}" class="">Of maak hier een account</a>
            @endguest
            @auth
                <h5>Selecteer je auto om kilometers en zuinigheid bij te houden.</h5>
                <div class="row row-cols-xl-2 row-cols-1 g-3">
                    @foreach($cars as $car)
                        <div class="col d-flex">
                            <div class="card with-footer text-white bg-dark">
                                <div class="row h-100">
                                    <div class="col-md-5">
                                        <img src="{{ $car->get_image() }}" class="img-fluid w-100 object-fit-cover h-100" style="object-fit: cover;" alt="{{ $car->brand. ' ' .$car->model }}">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <a href="#"><h5 class="card-title">{{ $car->brand. ' ' .$car->model }}</h5></a>
                                            <ul>
                                                <li><b>Bouwjaar:</b> {{ $car->year }}</li>
                                                <li><b>Afstand gereden:</b> {{ $car->total_distance }} km</li>
                                                <li><b>Gemiddeld gebruik:</b> 1 op {{ RefuelingStat::convertToFloat($car->avg_usage) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <a href="{{ route('driving.edit', $car) }}">Edit</a>
                                    |
                                    <a href="{{ route('efficiency.index', $car) }}">Beheren</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('driving.create') }}" class="btn btn-primary text-light mt-3">Nieuwe auto toevoegen</a>
            @endauth
        </div>
    </div>
@endsection
