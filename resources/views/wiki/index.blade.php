@php
    use App\Services\Wiki;
@endphp
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-3">
        <h1>Welkom op Wiki Search</h1>
        <p>Bij dit spel moet je van Wikipedia pagina A naar Wikipedia pagina B navigeren in zo min mogelijk stappen. Je komt aan bij het doel door op de links te klikken en zo naar een volgende pagina te gaan. Aan het einde wordt je score opgeslagen zoen kunnen andere mensen het sneller proberen te doen.</p>
        @auth
            <div class="bg-dark rounded p-3 mb-3">
                <h1>Pagina A: <span class="badge bg-primary">{{ $wiki[0][0] }}</span>
                    <form class="d-inline" action="{{ route('wiki.refresh') }}">
                        <input type="hidden" name="page" value="1">
                        <button class="btn btn-lg btn-danger"><i class="fas fa-sync-alt"></i></button>
                    </form>
                </h1>
                <hr>
                <p class="m-0">{{ $wiki[0][1] }}</p>
            </div>
            <div class="bg-dark rounded p-3">
                <h1>Pagina B: <span class="badge bg-primary">{{ $wiki[1][0] }}</span>
                    <form class="d-inline" action="{{ route('wiki.refresh') }}">
                        <input type="hidden" name="page" value="2">
                        <button class="btn btn-lg btn-danger"><i class="fas fa-sync-alt"></i></button>
                    </form>
                </h1>
                <hr>
                <p>{{ $wiki[1][1] }}</p>
            </div>
            <div class="pt-3 d-flex flex-row align-items-center">
                <form method="POST" action="{{ route('wiki.store') }}">
                    @csrf
                    <button class="btn btn-success fs-4 px-2"><strong>Start, alleen!</strong></button>
                </form>
                <h1 class="px-2">of</h1>
                <form method="POST" action="{{ route('challenge.store') }}">
                    @csrf
                    <button class="btn btn-success fs-4 px-2"><strong>Start, met vrienden!</strong></button>
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

    <div class="mb-3">
        <h1>Leaderboard</h1>

        @foreach ($scores as $key => $items)
            @php
                $name = explode('_', $key)
            @endphp
            <div class="bg-dark rounded p-2 mb-1 d-flex justify-content-between align-items-center">
                <h2 class="text-secondary fs-5 mb-0 py-2">
                    <a class="link-light text-decoration-none" data-bs-toggle="collapse" href="#collapse_{{ $loop->iteration }}" role="button" aria-expanded="false" aria-controls="collapse_{{ $loop->iteration }}">
                        <i class="fas fa-chevron-down"></i></i> {{ $name[0] }} <i class="fas fa-long-arrow-alt-right"></i> {{ $name[1] }}
                    </a>
                </h2>
                @auth
                    <form method="POST" action="{{ route('wiki.store', ['challenge' => $key]) }}">
                        @csrf
                        <button class="btn btn-link link-primary">Ook proberen</button>
                    </form>
                @endauth
            </div>
            <div class="collapse w-100" id="collapse_{{ $loop->iteration }}">
                <div class="bg-dark rounded p-3 mb-3">
                    <div class="table-responsive w-100">
                        <table class="table table-dark align-middle caption-top">
                            <caption>Totaal: {{ count($items) }}</caption>
                            <thead>
                                <tr class="align-middle">
                                    <th>#</th>
                                    <th>Naam</th>
                                    <th>Kliks</th>
                                    <th>Datum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items->sortBy('click_count') as $score)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $score->user->name }}</td>
                                        <td>{{ $score->click_count }}</td>
                                        <td>{{ date_format($score->created_at, "d-m-Y") }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-3">
        <h1>Recente challenges</h1>

        @foreach ($scores as $key => $items)
            @php
                $name = explode('_', $key)
            @endphp
            <div class="bg-dark rounded p-2 mb-1 d-flex justify-content-between align-items-center">
                <h2 class="text-secondary fs-5 mb-0 py-2">
                    <a class="link-light text-decoration-none" data-bs-toggle="collapse" href="#collapse_{{ $loop->iteration }}" role="button" aria-expanded="false" aria-controls="collapse_{{ $loop->iteration }}">
                        <i class="fas fa-chevron-down"></i></i> {{ $name[0] }} <i class="fas fa-long-arrow-alt-right"></i> {{ $name[1] }}
                    </a>
                </h2>
                @auth
                    <form method="POST" action="{{ route('wiki.store', ['challenge' => $key]) }}">
                        @csrf
                        <button class="btn btn-link link-primary">Ook proberen</button>
                    </form>
                @endauth
            </div>
            <div class="collapse w-100" id="collapse_{{ $loop->iteration }}">
                <div class="bg-dark rounded p-3 mb-3">
                    <div class="table-responsive w-100">
                        <table class="table table-dark align-middle caption-top">
                            <caption>Totaal: {{ count($items) }}</caption>
                            <thead>
                            <tr class="align-middle">
                                <th>#</th>
                                <th>Naam</th>
                                <th>Kliks</th>
                                <th>Datum</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($items->sortBy('click_count') as $score)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $score->user->name }}</td>
                                    <td>{{ $score->click_count }}</td>
                                    <td>{{ date_format($score->created_at, "d-m-Y") }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script>

</script>
@endsection
