@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-3">
        <h1>Welkom op Wiki Search</h1>
        <p>Bij dit spel moet je van Wikipedia pagina A naar Wikipedia pagina B navigeren in zo min mogelijk stappen. Je komt aan bij het doel door op de links te klikken en zo naar een volgende pagina te gaan. Aan het einde wordt je score opgeslagen zoen kunnen andere mensen het sneller proberen te doen.</p>
        @auth
            <h1>Pagina A: <span class="badge bg-primary">{{ $wiki[0] }}</span>
                <form class="d-inline" action="{{ route('wiki.refresh') }}">
                    <input type="hidden" name="page" value="1">
                    <button class="btn btn-lg btn-danger"><i class="fas fa-sync-alt"></i></button>
                </form>
            </h1>
            <h1>Pagina B: <span class="badge bg-primary">{{ $wiki[1] }}</span>
                <form class="d-inline" action="{{ route('wiki.refresh') }}">
                    <input type="hidden" name="page" value="2">
                    <button class="btn btn-lg btn-danger"><i class="fas fa-sync-alt"></i></button>
                </form>
            </h1>
            <div class="pt-3">
                <form method="POST" action="{{ route('wiki.store') }}">
                    @csrf
                    <button class="btn btn-success fs-4 px-5"><strong>start!</strong></button>
                </form>
            </div>
        @endauth
        @guest
            <p><strong>Om te spelen moet je een account hebben zodat we de scores kunnen opslaan.</strong></p>
            <a href="{{ route('login') }}" class="btn btn-primary text-white">Login</a>
            <span class="px-2">|</span>
            <a href="{{ route('register') }}" class="">Of maak hier een account</a>
        @endguest
    </div>
</div>
@endsection
