@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="card bg-dark col-md-12">
                <p>Hier is de game die je moet gaan spelen:</p>
                @dump($selectedGame)
            </div>
        </div>
    </div>
@endsection
