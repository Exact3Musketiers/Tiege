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
                <div class="card text-white bg-dark">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="https://www.alblasserdamsnieuws.nl/wordpress/wp-content/uploads/2014/07/lexus.jpg" class="img-fluid w-100 rounded-start" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <a href="#"><h5 class="card-title">Lexus CT 200h</h5></a>
                                <p class="card-text mb-0"></p>
                                <p class="card-text">Deze auto rijdt 1 op 24.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="#" class="btn btn-primary text-light mt-3">Nieuwe auto toevoegen? lekker bezig!</a>
            @endauth
        </div>
    </div>
@endsection
